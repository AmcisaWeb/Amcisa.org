<?php

namespace App\Http\Controllers;

use App\Event;
use App\EventData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EventController extends Controller{
    public function postEvent(Request $request)
    {
        $event = new Event();
        $nextId = DB::table('events')->max('id') + 1;
        $eventDecode = json_decode($request->input('event'), true);
        $event->id = $nextId;

        $files = $request->file('file');
        if($files!=null){
            $foldername = '../upload/'.$nextId.'_'.$eventDecode['title'].'/';
            $fileNameArr = [];

            foreach($files as $file) {
                $filename = microtime(true)*10000;
                $ext = $file->getClientOriginalExtension();
                $file->move($foldername, $filename.'.'.$ext);
                array_push($fileNameArr, '/'.$nextId.'_'.$eventDecode['title'].'/'.$filename.'.'.$ext);
            }
            $eventDecode = EventController::changeAllValuesByKey($eventDecode, 'file',null);
            $startOn = 0;
            $eventDecode = EventController::changeAllArrayValuesByKey($eventDecode, 'filename',$fileNameArr , $startOn);
        }

        $eventEncode = json_encode($eventDecode);
        $event->content = $eventEncode;

        $event->save();

        return response()->json('success posted' ,201);
    }
    public function getEvents($id)
    {
        $user = auth('api')->user();
        if($id == '*'){
            $events = Event::all();
            $eventsArr = [];
            $i = 0;
            $len = count($events);
            for($i=0; $i<$len; $i++){
                $events[$i]->content = json_decode($events[$i]->content);
                if($user != null){
                    if($user->role == 'member' || $user->role == ''){
                        if($events[$i]->content->role == 'member') array_push($eventsArr, $events[$i]);
                    }else if($user->role == 'president'){
                        if($events[$i]->content->role == 'member' ||
                            $events[$i]->content->role == 'president') array_push($eventsArr, $events[$i]);
                    }else if($user->role == 'admin') {
                        if($events[$i]->content->role == 'member' ||
                            $events[$i]->content->role == 'president' ||
                            $events[$i]->content->role == 'admin') array_push($eventsArr, $events[$i]);
                    }
                } else {
                    if($events[$i]->content->role == 'guest')
                        array_push($eventsArr, $events[$i]);
                }
            }
            $response = [
                'events' => $eventsArr
            ];
            return response()->json($response, 200);
        } else {
            $eventRes = null;
            $event = Event::find($id);
            $event->content = json_decode($event->content);

            if($user != null){
                if($user->role == 'member' || $user->role == ''){
                    if($event->content->role == 'member') $eventRes = $event;
                }else if($user->role == 'president'){
                    if($event->content->role == 'member' ||
                        $event->content->role == 'president') $eventRes = $event;
                }else if($user->role == 'admin') {
                    if($event->content->role == 'member' ||
                        $event->content->role == 'president' ||
                        $event->content->role == 'admin') $eventRes = $event;
                }
            } else {
                $eventRes = $event;
            }

            if($eventRes != null){
                $response = [
                    'event' => $eventRes
                ];
                return response()->json($response, 200);
            } else {
                return response()->json('Insufficient permission', 401);
            }

        }

    }
    public function postEventData(Request $request, $id)
    {
        $eventData = new EventData();
        $event = Event::find($id);
        $eventData->event_id = $event->id;
        $eventData->user_id = Auth::user()->id;

        $eventContent = json_decode($event->content);
        $eventDataDecode = json_decode($request->input('eventData'), true);


        $files = $request->file('file');
        if($files!=null){
            $foldername = $id.'_'.$eventContent->title.'/response/'.Auth::user()->id.'_'.Auth::user()->name_ch.'/';
            $fileNameArr = [];

            foreach($files as $file) {
                $filename = microtime(true)*10000;
                $ext = $file->getClientOriginalExtension();
                $file->move('../upload/'.$foldername, $filename.'.'.$ext);
                array_push($fileNameArr, $foldername.$filename.'.'.$ext);
            }
            $eventDataDecode = EventController::changeAllValuesByKey($eventDataDecode, 'file',null);
            $startOn = 0;
            $eventDataDecode = EventController::changeAllArrayValuesByKey($eventDataDecode, 'filename',$fileNameArr , $startOn);
        }

        $eventDataEncode = json_encode($eventDataDecode);
        $eventData->content = $eventDataEncode;
        $eventData->save();

        return response()->json('success posted' ,201);
    }
    private function changeAllArrayValuesByKey($array, $key, $valueArray, &$startOn){
        if(array_key_exists($key,$array))
        {
            $array[$key] = $valueArray[$startOn];
            $startOn++;
        }

        foreach($array as $a => $vals){
            if(is_array($vals)){
                $array[$a] = EventController::changeAllArrayValuesByKey($vals,$key,$valueArray, $startOn);
            }
        }
        return $array;
    }
    private function changeAllValuesByKey($array, $key, $value){
        if(array_key_exists($key,$array))
            $array[$key] = $value;

        foreach($array as $a => $vals){
            if(is_array($vals)){
                $array[$a] = EventController::changeAllValuesByKey($vals,$key,$value);
            }
        }
        return $array;
    }

}