<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use ResetsPasswords;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Support\Facades\Password;

class UserController extends Controller{
    public function register(Request $request)
    {
        $this->validate($request, [
            'email_school' => 'required|email|unique:users',    //don't confuse with the email_school and email, this code validate if the value of 'email_school' json object (which from the $request) is in correct email format.
            'password' => 'required'
        ]);
        $user = new User();
        $user->email_school =  $request->input('email_school');
        $user->password = bcrypt($request->input('password'));
        $user->save();
        return response()->json([
            'message' => 'Successfully register'
        ], 201);
    }
    public function getUser (Request $request) {
        $user = Auth::user();
        if($user != null){
            $response = [
                'user' => $user
            ];
            return response()->json($response, 200);
        }
    }
}