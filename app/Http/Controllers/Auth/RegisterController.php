<?php

namespace App\Http\Controllers\Auth;

use App\Entities\Customer;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Entities\User;
use App\Facades\Utils;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
    protected $redirectTo = '/users';

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
            'password' => ['required', 'string', 'min:5', 'confirmed']
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
       
        $customer = $this->createNewCustomer($data['name']);
       
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'active' => 1,
            'customer_id' => $customer->id,
            'phone_number' => $data['phone_number'],
            'role' => Utils::getRole('Owner'),
        ]);

        $customer->owner_id = $user->id;
        $customer->save();
        return $user;
    }

    private function createNewCustomer($name){
        $customer = new Customer();
        $customer->name = $name.'(Default Customer)';
        $customer->active = 1;
        $customer->save();

        return $customer;
    }
}
