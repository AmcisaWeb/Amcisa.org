<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Support\Facades\Auth;
use JWTAuth;
use Illuminate\Http\Request;

class FileController extends Controller{

    public function upload(Request $request)
    {
        $filename = microtime(true)*10000;
        $ext = $request->file('file')->getClientOriginalExtension();
        $request->file('file')->move('../upload/', $filename.'.'.$ext);

        return response()->json('Success upload',201);
    }

    public function download($name)
    {
        return response()->download(public_path()."/../upload/".$name);
    }
    public function downloadfolder($folder, $name)
    {
        return response()->download(public_path()."/../upload/".$folder.'/'.$name);
    }



}