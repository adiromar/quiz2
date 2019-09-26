<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use Session;
use DB;
use App\User;
use Auth;

class SocialAuthGoogleController extends Controller
{
    public function redirect()
    {	

        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try{
            $userSocial = Socialite::driver('google')->user();
        } catch(InvalidStateException $e){
            echo 'Caught exception: ',  $e->getMessage(), "\n";
                die; 
        }

        $userEmail = $userSocial->user['email'];
        if (empty($userEmail)) {
            $userEmail = 'default@example.com';
        }
        $user = User::where('email', $userEmail)->first();
        if ($user)
        {
            if (Auth::loginUsingId($user->id, true)) {
                $usr = Auth::User();
                $titles = DB::table('role_user')->where('user_id', $chk_user->id)->pluck('role_id');
                // dd($titles);

                // Check user role
                switch ($titles[0]) {
                    case '1':
                            return redirect()->route('dash')->with('success', 'You are now logged in from Google as Admin');
                        break;
                    case '3':
                            return redirect()->route('home')->with('success', 'You are now logged in from Google as User');
                        break; 
                    default:
                            return redirect()->route('home'); 
                        break;
                }

                // return redirect()->route('home')->with('success', 'You are now logged in From Google');
            }
        }
        else
        {
            // echo "here you are";die;
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
                return redirect()->route('home')->with('success', 'You are now logged in from Google Account.');
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
