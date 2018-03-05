<?php

namespace App\Http\Controllers;

use App\Amtee;
use App\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AmteeController extends Controller{

    public function vote(Request $request)
    {
        $user = Auth::user();
        $allAmtee = Amtee::all();
        foreach($allAmtee as $a){
            if($a->email == $user->email)
                return response()->json("You have already vote", 404);
        }
        $amtee = new Amtee();
        $amtee->email = $user->email;
        $amtee->vote = $request->input('vote');
        $amtee->save();
        
        return response()->json("vote successful", 200);
    }
}