<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;


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

    public function loginView()
    {
        return view('auth.login.login');
    }

    public function loginPost(Request $request)
    {
        $this->validate($request, [
            'mail_address' => 'required|email',
            'password' => 'required',
        ]);

        $userdata = $request->only('mail_address', 'password');
        // dd($userdata);
        if (Auth::attempt($userdata)) {
            return redirect('/top'); // トップページへのリダイレクト
        } else {
            return redirect('/login')->with('flash_message', 'メールアドレスまたはパスワードが正しくありません')->withInput();
        }

    }

}
