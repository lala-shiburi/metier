<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        $token = $this->guard()->attempt($this->credentials($request));

        if ($token) {
            $this->guard()->setToken($token);

            return true;
        }

        return false;
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        $this->clearLoginAttempts($request);

        // check if user is activated or deactivated
        if($request->user()->is_active == 1){
            $token = (string) $this->guard()->getToken();
            $expiration = $this->guard()->getPayload()->get('exp');

            return [
                'token' => $token,
                'token_type' => 'bearer',
                'expires_in' => $expiration - time(),
            ];
        }
        else{
            $this->guard()->logout();
            return response()->json(['error'=>'Unauthorised', 
                'message'=>"Your account was deactivated by our systems administrator due to a report
                of misconduct. If you wish to restore your privileges, please <a href=".url('/contact-us').">contact us</a>"
            ], 401);
        }
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();
    }
}
