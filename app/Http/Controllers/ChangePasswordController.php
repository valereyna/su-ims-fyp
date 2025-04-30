<?php

namespace App\Http\Controllers;

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

class ChangePasswordController extends Controller
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
    
}
