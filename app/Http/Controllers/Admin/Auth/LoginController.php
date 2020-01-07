<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
		//$this->middleware('guest:admin')->except('logout');
    }
	
	public function showAdminLoginForm()
    {
        return view('admin.auth.login', ['title' => 'Admin Login','loginRoute'=>'admin_login']);
    }
	
	public function adminLogin(Request $request)
    {
		
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {

            return redirect()->intended('admin/dashboard');
        }
        return back()->withInput($request->only('email', 'remember'));
    }
	
	public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->flush();

        //$request->session()->regenerate();

        return redirect(route('admin_login'));
    }
	
	protected function guard()
    {
        return Auth::guard('admin');
    }
	//Auth::guard('admin')->login($user);
}
