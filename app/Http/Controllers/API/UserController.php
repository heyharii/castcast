<?php

namespace Castcast\Http\Controllers\API;

use Hash;
use Auth;
use Validator;
use Castcast\User;
use Castcast\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mail;
use Castcast\Mail\ConfirmYourEmailAPI;

class UserController extends Controller
{
   public function login(Request $request){

       $validator = Validator::make($request->all(),[
           'email' => 'required|email',
           'password' => 'required'
       ]);

       if($validator->fails()){
           return response()->json(['error' => $validator->error()], 401);
       }

       if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
           $user = Auth::user();
           $success['token'] = $user->createToken('Castcast')->accessToken;
           $success['message'] = 'Successfully logged in.';
           return response()->json(['success' => $success], 200);
       }
       else{
           return response()->json(['error' => 'Unauthorised'], 401);
       }
   }

   public function register(Request $request){
      
      $validator = Validator::make($request->all(),[
          'name' => 'required|string|max:255',
          'email' => 'required|string|email|max:255|unique:users',
          'password' => 'required|string|min:6',
      ]);

       if($validator->fails()){
           return response()->json(['error' => $validator->error()], 401);
       }

       $input = $request->all();

       $user = User::create([
            'name' => $input['name'],
            'username' => str_slug($input['name']),
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'confirm_token'=> str_random(25)
        ]);

       $success['message'] = 'Registration Success ! Please confirm your email address';

       Mail::to($user)->send(new ConfirmYourEmailAPI($user));  

       return response()->json(['success' => $success], 200);

   }

    public function confirm() 
    {
    	$user = User::where('confirm_token', request('token'))->first();
        
        $success['message'] = 'Your email has been confirmed.';

    	if($user) {
    		$user->confirm();
    		return response()->json(['success' => $success], 200);
    	} else {
    		return response()->json(['error' => 'Confirmation token not recognised.'], 403);
    	}
    }

    public function profile(User $user)
    {
        return response()->json(['user' => $user,'series' => $user->seriesBeingWatched() ], 403);

    }

     public function updateCard(){
        
        $this->validate(request(), [
            'stripeToken' => 'required'
        ]);
        
        $token = request('stripeToken');
        $user = auth()->user();

        $user->updateCard($token);

        $success['message'] = 'Update Success !';
        
        return response()->json(['success' => $success], 200);
    
    }
}
