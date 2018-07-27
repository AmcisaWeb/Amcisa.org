<?php

namespace App\Http\Controllers;

use App\Info;
use Illuminate\Http\Request;

class InfoController extends Controller{
    public function postInfo(Request $request)
    {
        $info = new Info();
        $info->content = json_encode($request->input('info'));
        $info->save();
        return response()->json("success posted",200);
    }
    public function getInfo()
    {
        $info = Info::all();
        $i = 0;
        $len = count($info);
        for($i=0; $i<$len; $i++){
            $info[$i]->content = json_decode($info[$i]->content);
        }
        $response = [
            'info' => $info
        ];
        return response()->json($response, 200);
    }
}