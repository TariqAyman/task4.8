<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
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
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'name_ar' => ['required', 'string', 'regex:/[^\p{Arabic}]/u'],
            'mobile' => ['required', 'string', 'regex:/[0-9]{10}/', 'digits:10', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'birthday' => ['required', 'regex:/^\d{4}[\/\-]((0?[1-6])[\/\-](0?[1-9]|[12][0-9]|3[01])|(0?[7-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|30))$/']
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'name_ar' => $data['name_ar'],
            'mobile' => $data['mobile'],
            'birthday' => $data['birthday'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
