<?php
namespace App\Http\Controllers\ApiAuth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\User;

class LoginController extends Controller
{
	use AuthenticatesUsers;

	public function login(Request $request) {


	    if ($this->attemptLogin($request)) {
	    	
	        $user = $this->guard()->user();
	        $token = $user->generateToken();

	        $user->update( ['api_token', $token] );

	        return response()->json([
	        	'message'  => "Succesfully Logged In",
	            'data' => $user->toArray(),
	        ]);

	    }else{

	    	return response()->json(['message' => 'User Not Found']);

	    }

	}



}