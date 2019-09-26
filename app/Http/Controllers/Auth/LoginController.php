<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use DB;
use App\User;
use Auth;
use Session;
// use App\Posts;

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
    // protected $redirectTo = '/dashboard';


    public function redirectTo(){
        
    // User role
    $role = Auth::user();
    $id = Auth::id();
    // echo $id;

    $role = DB::table('role_user')->where('user_id', $id)->value('role_id');

    // dd($role);
    // Check user role
    switch ($role) {
        case '1':
                return '/dashboard';
            break;
        case '3':
                return '/home';
            break; 
        default:
                return '/login'; 
            break;
    }
}


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {   
        $this->middleware('guest')->except('logout');
    }

 


    // redirect to facebook callback
    public function redirectToFacebookProvider(){
        dd("hello");
        return Socialite::driver('facebook')->redirect();
    }

    // handle provider callback
    public function handleProviderCallback(Request $request)
    {
      
        dd("hello world");
        // $request->session()->flash('error', "Something went wrong. Please try again with correct credentials");
        return redirect()->route('home');
      
    } // function ends
}
