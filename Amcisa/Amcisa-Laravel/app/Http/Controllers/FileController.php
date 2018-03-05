<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Support\Facades\Auth;
use JWTAuth;
use Illuminate\Http\Request;

class FileController extends Controller{

    public function upload(Request $request)
    {
        if($request->input('extension') == null || $request->input('extension') == '')
            return response()->json("extension not provided",406);
        if(!$request->hasFile('file'))
            return response()->json("file not found",406);

        $filename = microtime(true)*10000;
        $ext = $request->input('extension');

        $request->file('file')->move('../upload/', $filename.'.'.$ext);
        return response()->json("success uploaded",201);
    }

    public function download($name)
    {
        return response()->download(public_path()."/../upload/".$name);
    }

}