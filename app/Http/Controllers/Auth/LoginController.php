<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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
     protected function authenticated(Request $request, $user)
    {
        if($user->user-type == 1)
            {
                return "Hello Admin";

            }

            elseif($user->user-type == 2)

                {
                    return" Hello Auther";
                }
                else
                    {
                        return "Good Bye";
                    }
    }

    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
}
