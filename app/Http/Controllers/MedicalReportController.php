<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Mail\MedicalReportMail;
use App\MedicalReport;
use App\Task;
use App\Traits\FetchResourceByRole;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use phpDocumentor\Reflection\DocBlock\Tags\Author;

class MedicalReportController extends Controller
{
    use FetchResourceByRole;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        if (auth()->user()->role_id == 1 || auth()->user()->role_id == 2) {
            $medicalReports = MedicalReport::Latest()->get();
        } elseif (auth()->user()->role_id == 6) {
            $medicalReports = MedicalReport::Latest()->whereIn('user_id', auth()->user()->companies->first()->users->pluck('id'))->get();
        } elseif (auth()->user()->role_id == 5) {
            $medicalReports = MedicalReport::where('patient_id', auth()->user()->id)->get();
        } else {
            $medicalReports = MedicalReport::Latest()->where('user_id', auth()->user()->id)->get();
        }

        return view('medical-report.index', compact('medicalReports'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $patients = $this->fetchPatientsByRole();

        return view('medical-report.create-edit', compact('patients'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $json_data = json_decode($request->data);
            $data['user_id'] = auth()->id();
            $data['patient_id'] = $json_data->claimant->patient_id != '' && $json_data->claimant->patient_id != 'N/A'
                ? $json_data->claimant->patient_id
                : $this->createPatient($json_data->claimant)->id;
            $json_data->claimant->patient_id = $data['patient_id'];
            $data['data'] = json_encode($json_data);

            MedicalReport::create($data);

            return redirect()->back()->withSuccess('Report created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\MedicalReport $medicalReport
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(MedicalReport $medicalReport)
    {
        return view('medical-report.show', compact('medicalReport'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\MedicalReport $medicalReport
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(MedicalReport $medicalReport)
    {
        $patients = $this->fetchPatientsByRole();

        return view('medical-report.create-edit')->with(['medicalReport' => $medicalReport, 'patients' => $patients]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\MedicalReport $medicalReport
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, MedicalReport $medicalReport)
    {
        try {
            $json_data = json_decode($request->data);
            $data['patient_id'] = $json_data->claimant->patient_id != '' && $json_data->claimant->patient_id != 'N/A'
                ? $json_data->claimant->patient_id
                : $this->createPatient($json_data->claimant)->id;
            $json_data->claimant->patient_id = $data['patient_id'];
            $data['data'] = json_encode($json_data);
            $medicalReport->update($data);

            return redirect()->back()->withSuccess('Report updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\MedicalReport $medicalReport
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(MedicalReport $medicalReport)
    {
        try {
            $medicalReport->delete();

            return redirect()->back()->withSuccess('Report deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    private function createPatient($climate)
    {
        $lastInsertedPatient = User::withTrashed()->latest()->first();
        $user = new User();
        $user->title = $climate->title;
        $user->firstname = $climate->firstName ? $climate->firstName : 'first name';
        $user->lastname = $climate->lastName ? $climate->lastName : 'last name';
        $user->gender = $climate->gender ? $climate->gender : 'male';
        $user->date_of_birth = $climate->dob ? Carbon::parse($climate->dob)->toDateString() : Carbon::now()->toDateString();
        $user->address = $climate->address;
        $user->username = strtolower($climate->firstName) . ($lastInsertedPatient->id + 1);
        $user->password = Hash::make($user->firstname);
        $user->user_id = auth()->user()->id;
        $user->creator_id = auth()->user()->id;
        $user->save();
        return $user;
    }

    public function sendMailToPatient(Request $request)
    {
        $this->validate($request, [
            'report_id' => 'required|string',
            'email' => 'required|email',
            'message' => 'nullable|string'
        ]);
        $medical_report = MedicalReport::findOrFail(decrypt($request->report_id));
        try {
            Mail::to($request->email)->send(new MedicalReportMail($medical_report, $request->message));
            return redirect()->back()->with('success', 'Mail sent');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function patientMedialReport($encrypted_id)
    {
        try {
            $medicalReport = MedicalReport::findOrFail(decrypt($encrypted_id));
            $patients = User::where(['id' => $medicalReport->patient_id])->get();
            // $patients = $this->fetchPatientsByRole();
            return view('medical-report.patient-medical-report-update')->with(['medicalReport' => $medicalReport, 'patients' => $patients, 'encrypted_id' => $encrypted_id]);
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function patientMedialReportStore(Request $request)
    {

        try {
            $encrypted_id = $request->encrypted_id;
            $medicalReport = MedicalReport::findOrFail(decrypt($encrypted_id));
            $json_data = json_decode($request->data); 
            $data['data'] = json_encode($json_data);
            $medicalReport->update($data);

            return redirect()->back()->withSuccess('Report updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

}
