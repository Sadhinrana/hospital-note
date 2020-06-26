<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\CompanyDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Str;
use Twilio\Rest\Client;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'business_name' => ['required', 'string', 'max:255'],
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'username' => $data['username'],
            'role_id' => 6,
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        // Create a twilo sub account
        // Your Account SID and Auth Token from twilio.com/console
        /*$sid    = env( 'TWILIO_SID' );
        $token  = env( 'TWILIO_TOKEN' );
        $twilio = new Client( $sid, $token );

        $account = $twilio->api->v2010->accounts->create(array("friendlyName" => $request->business_name))->toArray();*/

        // Register company
        $company = new CompanyDetail();
        $company->uuid = Str::uuid()->toString();
        $company->name = $request->business_name;
        $company->address = $request->address ?? 'No address';
        /*$company->sid = $account['sid'];
        $company->token = $account['authToken'];
        $company->twilio_response = json_encode($account);*/
        $company->user_id = $user->id;
        $company->save();

        // Define relation
        $company->users()->attach($user->id);
    }
}
