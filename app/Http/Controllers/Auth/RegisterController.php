<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\BtcDetail;
use App\Notifications\UserRegister;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

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
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'  => ['required', 'string', 'min:8', 'confirmed'],
            'phone'     => ['required', 'numeric', 'digits_between:8,16'],
            'address'   => ['required', 'string', 'max:250'],
            'country'   => ['required', 'string', 'max:50'],
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
         if(isset($data['ref'])){
            $referUser = User::where('email',$data['ref'])->first();
        }
        
        $user = User::create([
            'name'          => $data['name'],
            'email'         => $data['email'],
            'phone'         => $data['phone'],
            'address'       => $data['address'],
            'country'       => $data['country'],
             'ref'       => isset($data['ref']) ?  $referUser->id : '0',
            'min_withdrawl' => User::where("role_id", 1)->first()->min_withdrawl,
            'commission'    => User::where("role_id", 1)->first()->commission,
            'password'      => Hash::make($data['password']),
        ]);

        BtcDetail::create([
            "user_id" => $user->id,
            "pub_key" => "YOUR BTC PUB KEY",
            "api_key" => "YOUR BTC API KEY"
        ]);

        $user->notify(new UserRegister($user));

        return $user;
    }
}