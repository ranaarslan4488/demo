<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\DoctorMeta;
use Stripe\Account;
use Stripe\Stripe;
use Stripe\Exception\ApiErrorException;
use Illuminate\Validation\ValidationException;
use DB;
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
    protected $redirectTo = RouteServiceProvider::HOME;

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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'days' => ['array'],
            'start_time' => ['date_format:H:i'],
            'end_time' => ['date_format:H:i'],
            'check_time_duration' => ['string'],
            'fees' => ['string'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        DB::beginTransaction();
        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => 'doctor',
            ]);
    
          
    
            $account = Account::create([
                'type' => 'custom', // or 'custom' based on your requirements
                'country' => 'US', // Use the appropriate country code
                'email' => $user->email,
                'capabilities' => [
                    'card_payments' => ['requested' => true],
                    'transfers' => ['requested' => true],
                ],
                
            ]);

            $doctor = DoctorMeta::create([
                'user_id' => $user->id,
                'days' => json_encode($data['days']),
                'start_time' => $data['start_time'],
                'end_time' => $data['end_time'],
                'check_time_duration' => $data['check_time_duration'],
                'fees' => $data['fees'],
                'stripe_account_id' => $account['id']
            ]);
        
            DB::commit();
            
            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
    
            // Log the error or handle it as needed
            \Log::error($e);
    
            throw ValidationException::withMessages(['error' => 'An error occurred during registration.']);
        }
    }
}
