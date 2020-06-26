<?php

namespace App\Http\Controllers;

use App\AppointmentRecord;
use App\EmbedUrl;
use App\Mail\AppointmentCreated;
use App\Mail\VideoAppointment;
use App\Traits\FetchResourceByRole;
use Illuminate\Http\Request;

use App\Http\Requests\Appointments\UpdateAppointment;

use App\Appointment;
use App\Service;
use App\User;
use App\CompanyDetail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AppointmentsController extends Controller
{
    use FetchResourceByRole;

    public function patientName($id)
    {
        $user = User::withTrashed()->findOrFail($id);

        if ($user) {
            return $user->firstname . ' ' . $user->lastname;
        } else {
            return '';
        }
    }

    public function __construct()
    {
        $this->middleware(['servicesCount'])->only(['create', 'store']);
    }

    public function fullCalendar()
    {
        // set appointment from-to null data to appropiate
        $nullAppointments = Appointment::whereNull('from')->get();
        foreach ($nullAppointments as $appointment) {
            $addTime = $appointment->doctor ? $appointment->doctor->slot : 0;
            $appointment->from = date('H:i:s', strtotime($appointment->appointment_date));
            $appointment->to = date('H:i:s', strtotime('+' . $addTime . ' minutes', strtotime($appointment->appointment_date)));
            $appointment->update();
        }

        $data = $this->fetchAppointmentsByRole();
        $patients = $this->fetchPatientsByRole();
        $users = $this->fetchAvailableDoctorsByRole();
        $services = $this->fetchServicesByRole();

        $events = $resources = [];

        foreach ($data as $datum) {
            $events[] = array(
                'resourceId' => $datum->doctor->id,
                'title' => $datum->user->firstname . ' ' . $datum->user->lastname,
                'url' => route('appointments.show', $datum->id),
                'start' => date('Y-m-d', strtotime($datum->appointment_date)) . ' ' . $datum->from,
                'end' => date('Y-m-d', strtotime($datum->appointment_date)) . ' ' . $datum->to,
            );
        }

        foreach ($users as $user) {
            // if not staff user
            if ($user->role_id != 4) {
                // if the user is available
                if ($user->availability == 1) {
                    $resources[] = array(
                        'id' => $user->id,
                        'title' => $user->firstname . ' ' . $user->lastname,
                        'room' => $user->room ? $user->room->name : '',
                    );
                }
            }
        }

        $events = json_encode($events);
        $resources = json_encode($resources);

        return view('appointments.calendar', compact('users', 'patients', 'services', 'events', 'resources'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $appointments = $this->fetchAppointmentsByRole();
        $patients = $this->fetchPatientsByRole();
        $users = $this->fetchAvailableDoctorsByRole();
        $services = $this->fetchServicesByRole();

        return view('appointments.index', compact('appointments', 'patients', 'users', 'services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $patients = User::latest()->where('role_id', 5)->get();

        $users = User::where('role_id', '!=', 5)
            ->where('role_id', '!=', 1)
            ->where('role_id', '!=', 2)
            ->where('availability', 1)
            ->get();

        $services = $this->fetchServicesByRole();

        return view('appointments.create', compact('patients', 'users', 'services'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        // Validate form data
        $request->validate([
            'description' => 'nullable|string',
            'appointment_date' => 'required|date_format:Y-m-d|after:yesterday',
            'from' => 'required|date_format:h:iA',
            'service_id' => 'required|integer',
            'doctor_id' => 'required|integer',
            'user_id' => 'required|integer',
        ]);

        $appointment = new Appointment;

        $appointment->service_id = $request->service_id;
        $appointment->appointment_date = date('Y-m-d H:i:s', strtotime($request->appointment_date));
        $appointment->end_time = $request->end_time;
        $appointment->from = date('H:i:s', strtotime($request->from));

        if ($slot = User::find($request->doctor_id)->slot) {
            $appointment->to = date('H:i:s', strtotime($request->from) + $slot * 60);
        } else {
            $appointment->to = date('H:i:s', strtotime($request->from) + 900);
        }

        $appointment->status = 'open';
        $appointment->description = $request->description;
        $appointment->is_video_conference = $request->is_video_conference ?? 0;

        $appointment->user_id = $request->user_id;
        $appointment->doctor_id = $request->doctor_id;
        $appointment->creator_id = auth()->user()->id;

        $appointment->save();

        if (isset($request->is_video_conference)) {
            if ($appointment->user && $appointment->user->email) {
                Mail::to($appointment->user->email)->send(new VideoAppointment($appointment, route('appointment.video.conference', base64_encode($appointment->id)) . '?roomid=' . base64_encode($appointment->id)));
            }

            if ($appointment->doctor && $appointment->doctor->email) {
                Mail::to($appointment->doctor->email)->send(new VideoAppointment($appointment, route('appointment.video.conference', base64_encode($appointment->id))));
            }
        } else {
            if ($appointment->user && $appointment->user->email) {
                Mail::to($appointment->user->email)->send(new AppointmentCreated($appointment));
            }

            if ($appointment->doctor && $appointment->doctor->email) {
                Mail::to($appointment->doctor->email)->send(new AppointmentCreated($appointment));
            }
        }

        return redirect('appointments')->with('success', 'Appointment Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $appointment = Appointment::findOrfail($id);

        $company = $this->activeCompany();

        return view('appointments.show', compact('appointment', 'company'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $appointment = Appointment::findOrfail($id);

        $patients = $this->fetchPatientsByRole();
        $services = $this->fetchServicesByRole();
        $users = $this->fetchUsersByRole();
        return view('appointments.edit', compact('appointment', 'users', 'services', 'patients'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateAppointment $request, $id)
    {
        $appointment = Appointment::findOrfail($id);
        $appointment->service_id = $request->service_id;
        $appointment->appointment_date = date('Y-m-d H:i:s', strtotime($request->appointment_date));
        $appointment->end_time = $request->end_time;
        $appointment->from = date('H:i:s', strtotime($request->from));

        if ($slot = User::find($request->doctor_id)->slot) {
            $appointment->to = date('H:i:s', strtotime($request->from) + $slot * 60);
        } else {
            $appointment->to = date('H:i:s', strtotime($request->from) + 900);
        }

        $appointment->description = $request->description;
        $appointment->user_id = $request->user_id;
        $appointment->doctor_id = $request->doctor_id;
        $appointment->save();

        return redirect()->route('appointments.show', $appointment->id)->with('success', 'Appointment Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $appointment = Appointment::findOrfail($id);

        $appointment->delete();

        return redirect('appointments')->with('success', 'Appointment Deleted Successfully');
    }

    public function close(Request $request, $id)
    {
        $appointment = Appointment::findOrfail($id);

        $appointment->end_time = $request->end_time;

        $appointment->status = 'close';

        $appointment->save();

        return redirect()->back()->with('success', 'Appointment closed successfully');
    }

    public function open($id)
    {
        $appointment = Appointment::findOrfail($id);

        $appointment->status = 'open';

        $appointment->save();

        return redirect()->back()->with('success', 'Appointment opened successfully');
    }

    public function progress(Request $request, $id)
    {
        $appointment = Appointment::findOrfail($id);

        $appointment->progress = $request->progress;

        $appointment->save();

        return redirect()->back()->with('success', 'Appointment progress changed successfully');
    }

    public function activeCompany()
    {
        $companies = CompanyDetail::all();

        foreach ($companies as $company) {
            if ($company->status == 1) {
                return $company->first();
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createAppointment(Request $request)
    {
        if (isset($request->id)) {
            $url = EmbedUrl::find($request->id);
            if ($url) {
                $clinic = CompanyDetail::find($url->company_detail_id);

                if ($clinic) {
                    if (count($url->services)) {
                        $services = Service::whereIn('id', $url->services->pluck('service_id'))->get();
                    } else {
                        $services = Service::whereIn('user_id', $clinic->users->pluck('id'))->get();
                    }
                } else {
                    abort(403);
                }
            } else {
                abort(403);
            }
        } elseif (isset($request->clinic)) {
            if (!$request->clinic) abort(403);
            $clinic = CompanyDetail::where('uuid', $request->clinic)->first();
            if (!$clinic || !$clinic->owner) abort(403);
            $services = Service::whereIn('user_id', $clinic->users->pluck('id'))->get();
        } else {
            abort(403);
        }

        return view('appointments.book', compact('services'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function appointmentBook(Request $request)
    {
        // Validate form data
        $request->validate([
            'description' => 'nullable|string',
            'appointment_date' => 'required|date_format:Y-m-d|after:yesterday',
            'from' => 'required|date_format:h:iA',
            'service_id' => 'required|integer',
            'doctor_id' => 'required|integer',
            'firstname' => 'required|string|max:191',
            'lastname' => 'required|string|max:191',
            'gender' => 'required|string|max:191',
            'email' => 'required|string|max:191',
            'phone' => 'required|string|max:191',
            'dob_day' => 'required|integer',
            'dob_month' => 'required|integer',
            'dob_year' => 'required|integer',
            'more_info' => 'nullable|string',
        ]);

        try {
            $service = \App\Service::find($request->service_id);
            $doctor = User::find($request->doctor_id);

            if ($service->is_payment) {
                // Validate form data
                $request->validate([
                    'stripeToken' => 'required|string',
                ]);

                if (count($doctor->companies)) {
                    $company = $doctor->companies->first();

                    if ($company->owner->stripe_user_id) {
                        $stripe_user_id = $company->owner->stripe_user_id;
                    } else {
                        return redirect()->back()->withErrors(['error' => 'Company\'s stripe account not connected!']);
                    }
                } else {
                    return redirect()->back()->withErrors(['error' => 'Company not found!']);
                }

                \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));// `source` is obtained with Stripe.js; see https://stripe.com/docs/payments/accept-a-payment-charges#web-create-token

                $charge = \Stripe\Charge::create([
                    'amount' => (double)$service->price * 100,
                    'currency' => 'GBP',
                    'description' => $service->name . ' Fee charge.',
                    'source' => $request->stripeToken,
                    "application_fee_amount" => 0.04 * ((double)$service->price * 100),
                ], ["stripe_account" => $stripe_user_id]);
            }

            $user = User::where(['role_id' => 5, 'email' => $request->email])->first();

            if (!$user) {
                $lastInsertedPatient = User::latest()->first();
                $user = new User();
                $user->username = strtolower($request->firstname) . ($lastInsertedPatient->id + 1);
                $user->firstname = $request->firstname;
                $user->lastname = $request->lastname;
                $user->email = $request->email;
                $user->phone = $request->phone;
                $user->gender = $request->gender;
                $user->date_of_birth = date('Y-m-d', strtotime($request->dob_year . '-' . $request->dob_month . '-' . $request->dob_day));
                $user->more_info = $request->more_info;
                $user->password = Hash::make('12345678');
                $user->save();
            }

            $appointment = new Appointment;
            $appointment->service_id = $request->service_id;
            $appointment->appointment_date = date('Y-m-d H:i:s', strtotime($request->appointment_date));
            $appointment->end_time = $request->end_time;
            $appointment->color = $request->color;
            $appointment->from = date('H:i:s', strtotime($request->from));

            if ($doctor->slot) {
                $appointment->to = date('H:i:s', strtotime($request->from) + $doctor->slot * 60);
            } else {
                $appointment->to = date('H:i:s', strtotime($request->from) + 900);
            }

            $appointment->status = 'open';
            $appointment->description = $request->description;
            $appointment->is_video_conference = $request->is_video_conference ?? 0;

            if ($service->is_payment) {
                $appointment->transaction_id = $charge->id;
                $appointment->stripe_response = $charge;
            }

            $appointment->user_id = $user->id;
            $appointment->doctor_id = $request->doctor_id;
            $appointment->creator_id = 2;
            $appointment->save();

            if (isset($request->is_video_conference)) {
                if ($appointment->user && $appointment->user->email) {
                    Mail::to($appointment->user->email)->send(new VideoAppointment($appointment, route('appointment.video.conference', base64_encode($appointment->id)) . '?roomid=' . base64_encode($appointment->id)));
                }

                if ($appointment->doctor && $appointment->doctor->email) {
                    Mail::to($appointment->doctor->email)->send(new VideoAppointment($appointment, route('appointment.video.conference', base64_encode($appointment->id))));
                }
            }

            return redirect()->back()->with('success', 'Appointment Created Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function pngToBase64(Request $request)
    {
        $image64 = base64_encode(file_get_contents($request->link));
        return response(['success' => true, 'image64' => $image64]);
    }

    public function base64ToPng(Request $request)
    {
        $data = base64_decode($request['imgData']);
        $destinationPath = public_path('/');
        $file_path = rand(00000000, 99999999) . '.png';
        $folder = 'images/template';
        $file = $destinationPath . $folder . '/' . $file_path;
        if (!file_exists($destinationPath . $folder)) {
            mkdir($destinationPath . $folder, 0777, true);
        }
        file_put_contents($file, $data);
        return response(['success' => true, 'imageSrc' => $folder . '/' . $file_path]);
    }

    public function allAppointments(Request $request)
    {
        try {
            if (auth()->user() != null && isset(auth()->user()->company->company)) {
                auth()->user()->company = auth()->user()->company->company;
            }

            $input = $request->input();
            $input['keyword'] = isset($input['keyword']) ? $input['keyword'] : '';
            $pageNo = isset($input['pageNo']) && $input['pageNo'] > 0 ? $input['pageNo'] : 1;
            $limit = isset($input['perPage']) ? $input['perPage'] : 10;
            $skip = $limit * ($pageNo - 1);
            $sort_by = isset($input['sort_by']) ? $input['sort_by'] : 'id';
            $order_by = isset($input['order_by']) ? $input['order_by'] : 'desc';

            if (auth()->user()->role_id == 6) {
                $input['doctors'] = auth()->user()->company->users->pluck('id');
            } elseif ((auth()->user()->role_id == 3 && auth()->user()->role_type != 3) || auth()->user()->role_id == 4) {
                if (count(auth()->user()->companies)) {
                    $input['doctors'] = auth()->user()->companies->first()->users->pluck('id');
                } else {
                    $input['doctors'] = [];
                }
            }

            $sql = Appointment::with('record')->select('appointments.*', 'services.name as service_name',
                \DB::raw("CONCAT(A.firstname, ' ', A.lastname) as patient_name"),
                \DB::raw("CONCAT(B.firstname, ' ', B.lastname) as doctor_name"))
                ->leftjoin('services', 'services.id', '=', 'appointments.service_id')
                ->leftjoin('users AS A', 'A.id', '=', 'appointments.user_id')
                ->leftjoin('users AS B', 'B.id', '=', 'appointments.doctor_id')
                ->where(function ($query) use ($input) {
                    if (auth()->user()->role_id == 3 || auth()->user()->role_id == 6 || auth()->user()->role_id == 4) {
                        if (isset($input['doctors'])) {
                            $query->where(function ($q) use ($input) {
                                $q->whereIn('appointments.doctor_id', $input['doctors']);
                            });
                        } else {
                            $query->where(function ($q) use ($input) {
                                $q->where('appointments.doctor_id', auth()->user()->id);
                            });
                        }
                    }

                    if (auth()->user()->role_id == 5) {
                        $query->where(function ($q) use ($input) {
                            $q->where('appointments.user_id', auth()->user()->id);
                        });
                    }

                    $query->where(function ($q) use ($input) {
                        $q->where('appointments.progress', 'like', '%' . $input['keyword'] . '%')
                            ->orWhere('appointments.status', 'like', '%' . $input['keyword'] . '%')
                            ->orWhere('appointments.appointment_date', 'like', '%' . $input['keyword'] . '%')
                            ->orWhere('appointments.from', 'like', '%' . $input['keyword'] . '%')
                            ->orWhere('services.name', 'like', '%' . $input['keyword'] . '%')
                            ->orWhere(\DB::raw("CONCAT(A.firstname, ' ', A.lastname)"), 'like', '%' . $input['keyword'] . '%')
                            ->orWhere(\DB::raw("CONCAT(B.firstname, ' ', B.lastname)"), 'like', '%' . $input['keyword'] . '%')
                            ->orWhere('appointments.to', 'like', '%' . $input['keyword'] . '%');
                    });

                    if (isset($input['appointment_date']) && isset($input['end_date'])) {
                        $query->whereBetween('appointments.appointment_date', [$input['appointment_date'], $input['end_date']]);
                    } elseif (isset($input['appointment_date'])) {
                        $query->whereDate('appointments.appointment_date', $input['appointment_date']);
                    }

                    if (isset($input['doctor_id']) && $input['doctor_id'] != 'all') {
                        $query->where('appointments.doctor_id', $input['doctor_id']);
                    }
                });

            $total = $sql->count();

            if ($sort_by == 'patient') {
                $sql->orderBy(\DB::raw("CONCAT(A.firstname, ' ', A.lastname)"), $order_by);
            } elseif ($sort_by == 'doctor') {
                $sql->orderBy(\DB::raw("CONCAT(B.firstname, ' ', B.lastname)"), $order_by);
            } elseif ($sort_by == 'service') {
                $sql->orderBy(\DB::raw('services.name'), $order_by);
            } else {
                $sql->orderBy($sort_by, $order_by);
            }

            $appointments = $sql->skip($skip)->take($limit)->get();

            return response()->json(['status' => 200, 'data' => ['appointments' => $appointments, 'counts' => $total]], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'errors' => $e->getMessage()], 200);
        }
    }

    // ===============================
    // videoAppointmentConference
    // ===============================
    public function videoAppointmentConference(Request $request, $code)
    {
        $appointment = Appointment::findOrFail(base64_decode($code));

        /*if ($appointment->doctor_id != auth()->id() && $appointment->user_id != auth()->id()) {
            abort(404);
        }

        if ($appointment->user_id == auth()->id() && ($request->query('roomid') == null || base64_decode($request->query('roomid')) != $appointment->id)) {
            abort(404);
        }

        if (date('Y-m-d') < date('Y-m-d', strtotime($appointment->appointment_date))) {
            $overdue = false;
            return view('appointments.video-conference-info', compact('overdue', 'appointment'));
        } elseif (date('Y-m-d') > date('Y-m-d', strtotime($appointment->appointment_date))) {
            $overdue = true;
            return view('appointments.video-conference-info', compact('overdue', 'appointment'));
        } else {
            if (time() < strtotime($appointment->from)) {
                $overdue = false;
                return view('appointments.video-conference-info', compact('overdue', 'appointment'));
            } elseif (time() > strtotime($appointment->to)) {
                $overdue = true;
                return view('appointments.video-conference-info', compact('overdue', 'appointment'));
            }
        }*/

        if ($appointment->user_id == auth()->id()) {
            $appointment->update(['patient_join', 1]);
        }
        $appointment->update(['session_start', 1]);

        return view('appointments.video-conference', compact('appointment', 'code'));
    }

    public function uploadVideo(Request $request)
    {
        // Validate form data
        $rules = array(
            'video' => 'required|file',
            'appointment_id' => 'required|integer',
        );

        $validator = validator($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => 200, 'errors' => $validator->getMessageBag()->toarray()]);
        }

        try {
            $data = $request->only('appointment_id');

            if ($request->hasFile('video')) {
                $video = $request->video->store('public/appointment');
                $video = str_replace("public/", "", $video);
                $data['video'] = $video;
            }

            AppointmentRecord::create($data);

            return response()->json(['status' => 200, 'msg' => 'Video saved successfully.']);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'msg' => $e->getMessage()]);
        }
    }

    public function downloadVideo(AppointmentRecord $appointmentRecord)
    {
        try {
            return response()->download('storage/' . $appointmentRecord->video);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
