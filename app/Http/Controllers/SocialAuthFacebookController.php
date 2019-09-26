<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Laravel\Socialite\Facades\Socialite;
use Socialite;
use Session;
use DB;
use App\User;
use Auth;

class SocialAuthFacebookController extends Controller
{
    public function redirect()
    {	

        return Socialite::driver('facebook')->redirect();
    }

    public function callback()
    {
        try{
            $userSocial = Socialite::driver('facebook')->user();
        } catch(InvalidStateException $e){
            echo 'Caught exception: ',  $e->getMessage(), "\n";
                die; 
        }

        $userEmail = $userSocial->user['email'];
        $userPass = bcrypt($userSocial->user['id']);
        
        if (empty($userEmail)) {
            $userEmail = 'default@example.com';
        }
        $chk_user = User::where('email', $userEmail)->first();
        // $chk_pass = User::where('password', $userPass)->first();
        
        if ($chk_user == true)
        {
            if (Auth::loginUsingId($chk_user->id, true)) {

                $usr = Auth::User();
                $titles = DB::table('role_user')->where('user_id', $chk_user->id)->pluck('role_id');
                // dd($titles);

                // Check user role
                switch ($titles[0]) {
                    case '1':
                            return redirect()->route('dash')->with('success', 'You are now logged in from Facebook as Admin');
                        break;
                    case '3':
                            return redirect()->route('home')->with('success', 'You are now logged in from Facebook as User');
                        break; 
                    default:
                            return redirect()->route('home'); 
                        break;
                }

                // if ($titles[0] == 'User') {
                //     return redirect()->route('home')->with('success', 'You are now logged in from Facebook as User');
                // }elseif($titles[0] == ['Admin','SuperAdmin']){
                //     return redirect()->route('dash')->with('success', 'You are now logged in from Facebook as Admin');
                // }
                
            }else{
                return redirect()->route('home')->with('info', 'Email Already Used.');
            }

        }else {
            // echo "here you are";die;
            $role = 'User';
            $userSignup = User::create([
                    'name' => $userSocial->user['name'],
                    'email' => $userEmail,
                    'password' => bcrypt($userSocial->user['id']),
            ]);
            $uid = $userSignup->id;
            
            DB::table('role_user')->insert([
                    'user_id' => $uid,
                    'role_id' => 3
                    ]);

            $data = '';
            // now signup 
            if ($userSignup)
            {
              if (Auth::loginUsingId($userSignup->id, true))
              {
                return redirect()->route('home')->with('success', 'You are now logged in from Facebook Account.');
              }
            }
        }

        // $username = $userSocial->name;
        // $email = $userSocial->email;
        // $avatar = $userSocial->avatar;
        // $id = $userSocial->id;
        // dd($userSocial);
        // auth()->login($user);
        return redirect()->to('/home');
    }
}
