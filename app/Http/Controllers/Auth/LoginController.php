<?php

namespace Castcast\Http\Controllers\Auth;

use \Illuminate\Http\Request;
use Castcast\Exceptions\AuthFailedException;
use Castcast\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    protected $redirectTo = '/';

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

    * The user has been authenticated.$_COOKIE

    *
    
    *@param \Illuminate\Http\Request $request
    *@param mixed $user
    *@return mixed

    */

    

    protected function authenticated(Request $request, $user)
    {

     session()->flash('success', 'Successfully logged in.');

            if(request()->ajax()){
                return response()->json([
                'status' => 'ok'
                ]);
            }
        return redirect('/');   
    }
    

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        return $this->authenticated($request, $this->guard()->user())
                ?: redirect()->intended($this->redirectPath());
    }

     
    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        throw new AuthFailedException;
    }

}
