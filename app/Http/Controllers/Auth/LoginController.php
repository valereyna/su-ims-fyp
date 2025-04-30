<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use DB;
use Auth;
use Session;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use App\Rules\MatchOldPassword;

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
        $this->middleware('guest')->except([
            'logout',
            'locked',
            'unlock'
        ]);
    }
    /** index page login */
    public function login()
    {
        return view('auth.login');
    }

    /** login with databases */
    public function authenticate(Request $request)
    {
        $request->validate([
            'email'    => 'required|string',
            'password' => 'required|string',
        ]);
        
        DB::beginTransaction();
        try {
            $email     = $request->email;
            $password  = $request->password;

            if (Auth::attempt(['email'=>$email,'password'=>$password])) {
                /** get session */
                $user = Auth::User();

                $allowedRoles = ['admin', 'coordinator', 'advisor', 'student'];
                if (!in_array(strtolower($user->role_name), $allowedRoles)) {
                    Auth::logout();
                    Toastr::error('Your role ('.$user->role_name.') is not authorized to access this system', 'Error');
                    return redirect()->route('login');
                }
                Session::put('name', $user->name);
                Session::put('email', $user->email);
                Session::put('user_id', $user->user_id);
                Session::put('join_date', $user->join_date);
                Session::put('phone_number', $user->phone_number);
                Session::put('status', $user->status);
                Session::put('role_name', $user->role_name);
                Session::put('avatar', $user->avatar);
                Session::put('position', $user->position);
                Session::put('department', $user->department);
                Toastr::success('Login successfully :)','Success');

                switch ($user->role_name) {
                    case 'admin':
                        return redirect()->route('home');
                    case 'coordinator':
                        return redirect()->route('coordinator.dashboard');
                    case 'advisor':
                        return redirect()->route('advisor.dashboard'); // or advisor.dashboard
                    case 'student':
                        return redirect()->route('home');
                    default:
                        Auth::logout();
                        Toastr::error('Unauthorized role', 'Error');
                        return redirect()->route('login');
                }
                
            } else {
                DB::rollBack();
                Toastr::error('fail, WRONG USERNAME OR PASSWORD :)','Error');
                return redirect('login');
            }
           
        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('fail, LOGIN :)','Error');
            return redirect()->back();
        }
    }

    // change password
    public function changePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password'     => ['required', new MatchOldPassword],
            'new_password'         => ['required', 'min:8', 'confirmed'],
        ]);
    
        $user = auth()->user();
    
        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => "Current password incorrect."]);
        }
        
        $user->password = Hash::make($validated['new_password']);
        $user->save();
    
        Toastr::success('Password changed successfully :)', 'Success');
        return redirect()->back();
    }

    /** logout */
    public function logout( Request $request)
    {
        Auth::logout();
        // forget login session
        $request->session()->forget('name');
        $request->session()->forget('email');
        $request->session()->forget('user_id');
        $request->session()->forget('join_date');
        $request->session()->forget('phone_number');
        $request->session()->forget('status');
        $request->session()->forget('role_name');
        $request->session()->forget('avatar');
        $request->session()->forget('position');
        $request->session()->forget('department');
        $request->session()->flush();

        Toastr::success('Logout successfully :)','Success');
        return redirect('login');
    }

    
}
