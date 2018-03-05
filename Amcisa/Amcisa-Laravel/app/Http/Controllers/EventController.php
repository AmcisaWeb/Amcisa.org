<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;

class EventController extends Controller{
    public function postEvent(Request $request)
    {
        $event = new Event();
        $event->content = json_encode($request->input('event'));
        $event->save();
        return response()->json("success posted",201);
    }
    public function getEvents($id)
    {
        if($id == '*'){
            $events = Event::all();
            $i = 0;
            $len = count($events);
            for($i=0; $i<$len; $i++){
                $events[$i]->content = json_decode($events[$i]->content);
            }
            $response = [
                'events' => $events
            ];
        } else {
            $event = Event::find($id);
            $event->content = json_decode($event->content);
            $response = [
                'event' => $event
            ];
        }
        return response()->json($response, 200);
    }
}