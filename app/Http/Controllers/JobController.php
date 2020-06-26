<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\CompanyDetail;
use App\JobPractitioner;
use App\Jobs\SendSms;
use App\Mail\AppointmentReminder;
use App\Sms;
use App\SmsJob;
use App\JobClient;
use App\SmsTemplate;
use App\Traits\FetchResourceByRole;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Twilio\Rest\Client;

class JobController extends Controller
{
    use FetchResourceByRole;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        try {
            if(auth()->user() != null && isset(auth()->user()->company->company)){
                auth()->user()->company = auth()->user()->company->company;
            }

            if (auth()->user()->role_id == 6) {
                $jobs = auth()->user()->company->jobs;
            } else {
                $jobs = SmsJob::latest()->get();
            }

            return view('job.index', compact('jobs'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        try {
            // Check role
            if (auth()->user() != null && isset(auth()->user()->company->company)) {
                auth()->user()->company = auth()->user()->company->company;
            }

            if (auth()->user()->role_id == 6) {
                if (auth()->user()->company) {
                    $patients = User::latest()->where('role_id', 5)->whereIn('user_id', auth()->user()->company->users->pluck('id'))->get();
                    $doctors = User::latest()->where('role_id', 3)->whereIn('id', auth()->user()->company->users->pluck('id'))->get();
                    $companies = CompanyDetail::where('id', auth()->user()->company->id)->get();
                } else {
                    $patients = collect();
                    $doctors = collect();
                    $companies = collect();
                }
            } elseif (auth()->user()->role_id == 3 || auth()->user()->role_id == 4 || auth()->user()->role_id == 5) {
                return redirect()->back()->with('error', 'Permission denied!');
            } else {
                $patients = User::latest()->where('role_id', 5)->get();
                $doctors = User::latest()->where('role_id', 3)->get();
                $companies = CompanyDetail::latest()->get();
            }

            if (auth()->user()->role_id == 1 || auth()->user()->role_id == 2) {
                $smsTemplates = SmsTemplate::all();
            } else {
                $smsTemplates = SmsTemplate::whereIn('user_id', count(auth()->user()->companies) ? auth()->user()->companies->first()->users->pluck('id') : [])->get();
            }
            $patients = $this->fetchPatientsByRole();
            return view('job.create', compact('smsTemplates', 'patients', 'doctors', 'companies'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate form data
        $request->validate([
            'message' => 'required|string',
            'user_id' => 'nullable|array',
            'user_id.*' => 'required|integer',
            'doctor_id' => 'required|integer',
            //'doctor_id.*' => 'required|integer',
            'company_detail_id' => 'required|integer',
            'reminder_period' => 'nullable|integer|min:1',
            'reminder_time_from' => 'nullable|date_format:H:i',
            'reminder_time_to' => 'nullable|date_format:H:i|after:reminder_time_from',
            'reminder_type' => 'nullable|integer',
        ]);

        try {
            $job = SmsJob::create([
                'template' => $request->message,
                'company_detail_id' => $request->company_detail_id,
                'reminder_period' => $request->reminder_period,
                'reminder_time_from' => $request->reminder_time_from,
                'reminder_time_to' => $request->reminder_time_to,
                'reminder_type' => $request->reminder_type,
            ]);

            JobPractitioner::create([
                'user_id' => $request->doctor_id,
                'sms_job_id' => $job->id,
            ]);

            Appointment::whereDate('appointment_date', '>', date('Y-m-d H:i:s'))->where('user_id', $request->doctor_id)->update(['send_sms' => 1, 'send_mail' => 1]);

            if (isset($request->user_id) && is_array($request->user_id)) {
                foreach ($request->user_id as $id) {
                    $client[] = array(
                        'user_id' => $id,
                        'sms_job_id' => $job->id,
                    );
                }
            }

            if (isset($client) && count($client)) {
                JobClient::insert($client);// Eloquent approach
            }

            /*if (isset($request->doctor_id) && is_array($request->doctor_id)) {
                foreach ($request->doctor_id as $id) {
                    $doctor[] = array(
                        'user_id' => $id,
                        'sms_job_id' => $job->id,
                    );
                }
            }

            if (isset($doctor) && count($doctor)) {
                JobPractitioner::insert($doctor);// Eloquent approach
            }*/

            return redirect()->back()->with('success', 'SmsJob created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SmsJob  $job
     * @return \Illuminate\Http\Response
     */
    public function show(SmsJob $job)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SmsJob  $job
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(SmsJob $job)
    {
        try {
            // Check role
            if (auth()->user() != null && isset(auth()->user()->company->company)) {
                auth()->user()->company = auth()->user()->company->company;
            }

            if (auth()->user()->role_id == 6) {
                if (auth()->user()->company) {
                    $patients = User::latest()->where('role_id', 5)->whereIn('user_id', auth()->user()->company->users->pluck('id'))->get();
                    $doctors = User::latest()->where('role_id', 3)->whereIn('id', auth()->user()->company->users->pluck('id'))->get();
                    $companies = CompanyDetail::where('id', auth()->user()->company->id)->get();
                } else {
                    $patients = collect();
                    $doctors = collect();
                    $companies = collect();
                }
            } elseif (auth()->user()->role_id == 3 || auth()->user()->role_id == 4 || auth()->user()->role_id == 5) {
                return redirect()->back()->with('error', 'Permission denied!');
            } else {
                $patients = User::latest()->where('role_id', 5)->get();
                $doctors = User::latest()->where('role_id', 3)->get();
                $companies = CompanyDetail::latest()->get();
            }

            if (auth()->user()->role_id == 1 || auth()->user()->role_id == 2) {
                $smsTemplates = SmsTemplate::all();
            } else {
                $smsTemplates = SmsTemplate::whereIn('user_id', count(auth()->user()->companies) ? auth()->user()->companies->first()->users->pluck('id') : [])->get();
            }
            $job = SmsJob::find($job->id);

            return view('job.edit', compact('job', 'smsTemplates', 'patients', 'doctors', 'companies'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SmsJob  $job
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, SmsJob $job)
    {
        // Validate form data
        $request->validate([
            'message' => 'required|string',
            'user_id' => 'nullable|array',
            'user_id.*' => 'required|integer',
            'doctor_id' => 'required|integer',
            //'doctor_id.*' => 'required|integer',
            'company_detail_id' => 'required|integer',
            'reminder_period' => 'nullable|integer|min:1',
            'reminder_time_from' => 'nullable|date_format:H:i',
            'reminder_time_to' => 'nullable|date_format:H:i|after:reminder_time_from',
            'reminder_type' => 'nullable|integer',
        ]);

        try {
            $job = SmsJob::find($job->id);
            $job->template = $request->message;
            $job->company_detail_id = $request->company_detail_id;
            $job->reminder_period = $request->reminder_period;
            $job->reminder_time_from = $request->reminder_time_from;
            $job->reminder_time_to = $request->reminder_time_to;
            $job->reminder_type = $request->reminder_type;
            $job->save();

            JobPractitioner::where('sms_job_id', $job->id)->update(['user_id' => $request->doctor_id]);

            if (isset($request->user_id) && is_array($request->user_id)) {
                JobClient::whereNotIn('user_id', $request->user_id)->where('sms_job_id', $job->id)->delete();

                foreach ($request->user_id as $id) {
                    if (JobClient::where(['user_id' => $id, 'sms_job_id' => $job->id])->first() == null) {
                        $client[] = array(
                            'user_id' => $id,
                            'sms_job_id' => $job->id,
                        );
                    }
                }
            } else {
                JobClient::where('sms_job_id', $job->id)->delete();
            }

            if (isset($client) && count($client)) {
                JobClient::insert($client);// Eloquent approach
            }

            /*JobPractitioner::whereNotIn('user_id', $request->doctor_id)->delete();

            if (isset($request->doctor_id) && is_array($request->doctor_id)) {
                foreach ($request->doctor_id as $id) {
                    if (JobPractitioner::where('user_id', $id)->first() == null) {
                        $doctor[] = array(
                            'user_id' => $id,
                            'sms_job_id' => $job->id,
                        );
                    }
                }
            }

            if (isset($doctor) && count($doctor)) {
                JobPractitioner::insert($doctor);// Eloquent approach
            }*/

            return redirect()->back()->with('success', 'SmsJob updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SmsJob  $job
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(SmsJob $job)
    {
        try {
            SmsJob::destroy($job->id);

            return redirect()->back()->with('success', 'SmsJob deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Sends appointment schedule before specified datetime.
     *
     * @param  \App\SmsJob  $job
     * @return \Illuminate\Http\RedirectResponse
     */
    public function scheduledJob()
    {
        try {
            $jobs = SmsJob::latest()->get();

            foreach ($jobs as $job) {
                if ($job->reminder_type !== 0) {
                    $now = strtotime(date('H:i:s'));

                    if ($job->reminder_time_from && $job->reminder_time_to) {
                        if ($now > strtotime($job->reminder_time_from) && $now < strtotime($job->reminder_time_to)) {
                            $this->run($job);
                        }
                    } else {
                        $this->run($job);
                    }
                }
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Sends appointment schedule before specified datetime.
     *
     * @param  \App\SmsJob  $job
     * @return \Illuminate\Http\RedirectResponse
     */
    public function run($job){
        try {
            foreach ($job->users as $user) {
                $date = date('Y-m-d', strtotime(now()->addDays($job->reminder_period)));

                if ($user->user->phone) {
                    $appointments = Appointment::whereDate('appointment_date', $date)->where(['user_id' => $user->user->id, 'send_sms' => 1])->get();

                    foreach ($appointments as $appointment) {
                        $body = str_replace('{{Business.Name}}', $job->company->name, $job->template);
                        $body = str_replace('{{Appointment.Date}}', date('Y-m-d', strtotime($appointment->appointment_date)), $body);
                        $body = str_replace('{{Appointment.StartTime}}', date('h:iA', strtotime($appointment->from)), $body);
                        $body = str_replace('{{Practitioner.FullNameWithTitle}}', $user->user->doctor ? $user->user->doctor->firstname . ' ' . $user->user->doctor->lastname : '', $body);
                        $body = str_replace('{{From}}', $job->company->name, $body);

                        SendSms::dispatch($user->user, $body, $appointment);
                    }
                }

                if ($job->reminder_type == 2 && $user->user->email) {
                    $appointments = Appointment::whereDate('appointment_date', $date)->where(['user_id' => $user->user->id, 'send_mail' => 1])->get();

                    foreach ($appointments as $appointment) {
                        $body = str_replace('{{Business.Name}}', $job->company->name, $job->template);
                        $body = str_replace('{{Appointment.Date}}', date('Y-m-d', strtotime($appointment->appointment_date)), $body);
                        $body = str_replace('{{Appointment.StartTime}}', date('h:iA', strtotime($appointment->from)), $body);
                        $body = str_replace('{{Practitioner.FullNameWithTitle}}', $user->user->doctor ? $user->user->doctor->firstname . ' ' . $user->user->doctor->lastname : '', $body);
                        $body = str_replace('{{From}}', $job->company->name, $body);

                        // Send the mail
                        Mail::send(new AppointmentReminder($user->user, $appointment, $body));
                    }
                }
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
