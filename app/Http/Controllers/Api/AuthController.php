<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiHelper;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /// Register
    public function register(Request $request)
    {
        ApiHelper::validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'name_ar' => ['required', 'string', 'regex:/[^\p{Arabic}]/u'],
            'mobile' => ['required', 'string', 'regex:/[0-9]{10}/', 'digits:10', 'unique:users'],
            'password' => ['required', 'string', 'min:6'],
            'birthday' => ['required', 'regex:/^\d{4}[\/\-]((0?[1-6])[\/\-](0?[1-9]|[12][0-9]|3[01])|(0?[7-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|30))$/']
        ]);

        $user = User::create($request->only(['name', 'name_ar', 'mobile', 'birthday']) + ['password' => Hash::make($request->password)]);

        $token = $user->createToken(env('APP_NAME'))->accessToken;
        return ApiHelper::output(['user' => $user, 'token' => $token]);
    }

    // Login
    public function login(Request $request)
    {
        ApiHelper::validate($request, ['mobile' => 'required|min:10', 'password' => 'required|min:6']);

        $mobile_number = $request->mobile;
        $password = $request->password;

        $user = User::where('mobile', $mobile_number)->first();

        if (empty($user)) {
            return ApiHelper::output('login error', 0);
        }

        if (!Hash::check($password, $user->password)) {
            return ApiHelper::output('login_error', 0);
        }

        $token = $user->createToken(env('APP_NAME'))->accessToken;
        return ApiHelper::output(['user' => $user, 'token' => $token]);
    }


    public function logout(Request $request)
    {
        ApiHelper::validate($request, [
            'user_id' => 'required',
        ]);
        $request->user()->token()->revoke();

        return ApiHelper::output('logout Succeed');
    }

}
