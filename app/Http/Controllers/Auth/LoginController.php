<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        // Check validation
        $this->validate($request, [
            'mobile' => 'required|regex:/[0-9]{10}/|digits:10',
        ]);

        // Get user record
        $user = User::where('mobile', $request->get('mobile'))->first();

        // Check Condition Mobile No. Found or Not
        if (!isset($user) || $request->get('mobile') != $user->mobile) {
            return redirect()->route('login')->withErrors('Your mobile number not match in our system..!!');
        }
        if (!Hash::check($request->get('password'), $user->password)) {
            return redirect()->route('login')->withErrors('Your Password wrong !!');
        }

        // Set Auth Details
        \Auth::login($user);

        // Redirect home page
        return redirect()->route('home');
    }
}
