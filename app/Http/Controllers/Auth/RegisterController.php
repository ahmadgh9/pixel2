<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Rules\Name;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{

    use RegistersUsers;

    protected $redirectTo = RouteServiceProvider::LOGIN;


    public function __construct()
    {
        $this->middleware('guest');
    }


    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255' , new Name],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'max:255', 'confirmed'],
        ],[
            'name.required' => 'name is required',
            'name.string' => 'name must be string without numbers',
            'name.max' => 'name must be less than 255 characters',

            'email.required' => 'email is required',
            'email.string' => 'email must be string',
            'email.max' => 'email must be less than 255 characters',
            'email.email' => 'format of email is wrong',
            'email.unique' => 'email exists',

            'password.required' => 'password is required',
            'password.string' => 'password must be string',
            'password.min' => 'password must be at least 6 characters',
            'password.max' => 'password must be less than 255 characters',
            'password.confirmed' => 'password and confirm-password are not same',
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
        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

}
