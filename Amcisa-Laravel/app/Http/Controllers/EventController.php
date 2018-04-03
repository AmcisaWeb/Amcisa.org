<?php

namespace App\Http\Controllers;

use App\Event;
use App\EventData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Cast\Object_;

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
        $events = null;
        $eventsRes = null;

        if($id == '*'){
            $events = Event::all();
            $eventsRes = [];
        } else{
            $events[0] = Event::find($id);
            $eventsRes = new \stdClass();
        }


        $len = count($events);
        $temp = null;
        for($i=0; $i<$len; $i++){
            $events[$i]->content = json_decode($events[$i]->content);
            $pageArr = [];
            $pageLen = count($events[$i]->content->page);
            for($j=0; $j<$pageLen; $j++){
                if(EventController::roleFilter(($user ? $user->role : null), $events[$i]->content->page[$j]->role))
                    array_push($pageArr, $events[$i]->content->page[$j]);
            }
            if(count($pageArr)>0){
                $e = new \stdClass();
                $e->id = $events[$i]->id;
                $e->title = $events[$i]->content->title;
                $e->thumbnail = $events[$i]->content->thumbnail;
                $e->description = $events[$i]->content->description;
                $e->page = $pageArr;
                if(gettype($eventsRes)=='array')
                    array_push($eventsRes, $e);
                else if(gettype($eventsRes)=='object')
                    $eventsRes = $e;
            }
        }

        $response = [
            'events' => $eventsRes
        ];

        return response()->json($response, 200);

    }

    public function postEventData(Request $request, $eventId, $pageId)
    {
        $eventData = new EventData();
        $event = Event::find($eventId);
        $eventData->event_id = $eventId;
        $eventData->page_id = $pageId;
        $user_id = Auth::user()->id;
        $eventData->user_id = $user_id;

        $eventContent = json_decode($event->content);
        $eventDataDecode = json_decode($request->input('eventData'), true);

        foreach ($eventContent->page as $p){
            if($p->id == $pageId && $p->isSubmitOnce == true && count(EventData::where('user_id',$user_id)->where('page_id',$pageId)->get())>0){
                return response()->json( 'can only submit once',421);
            }
        }

        $files = $request->file('file');
        if($files!=null){
            $foldername = $eventId.'_'.$eventContent->title.'/response/'.Auth::user()->id.'_'.Auth::user()->name_ch.'/';
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
    public function getEventData(Request $request, $id){
        /*
        $fieldId = $request->input('fieldId');
        $eventData = EventData::where('event_id',$id)->get();

        $resArray = [];
        foreach ($eventData as $e){
            $decodedContent = json_decode($e->content,true);
            for($i=0; $i<count($decodedContent);$i++){
                $id = $decodedContent[$i]['id'];
                $content = $decodedContent[$i]['content'];
                if($id == $fieldId){
                    if(array_key_exists($content, $resArray)){
                        $resArray[$content] = $resArray[$content] + 1;
                    }else{
                        $resArray[$content] = 1;
                    }
                }
            }
        }
        return response()->json($resArray,200);
        */
        $fieldId = $request->input('fieldId');
        $eventData = EventData::where('event_id',$id)->get();
        $resArray = [];
        foreach ($eventData as $e){
            $decodedContent = json_decode($e->content,true);
            if($decodedContent == null || count($decodedContent) == 0) continue;
            for($i=0; $i<count($decodedContent);$i++){
                $id = $decodedContent[$i]['id'];
                if(!array_key_exists('content', $decodedContent[$i])) continue;
                $content = $decodedContent[$i]['content'];
                if($id == $fieldId){
                    if(array_key_exists($content, $resArray)){
                        $resArray[$content] = $resArray[$content] + 1;
                    }else{
                        $resArray[$content] = 1;
                    }
                }

            }






        }




        return response()->json($resArray,200);
    }
    private function roleFilter($userRole, $pageRole){
        if($userRole == 'member'){
            if($pageRole == 'member' ||
                $pageRole == 'guest') return true;
        }else if($userRole == 'president'){
            if($pageRole == 'member' ||
                $pageRole == 'president' ||
                $pageRole == 'guest') return true;
        }else if($userRole == 'admin') {
            if($pageRole == 'member' ||
                $pageRole == 'president' ||
                $pageRole == 'admin' ||
                $pageRole == 'guest') return true;
        }else if($userRole == null){
            if($pageRole == 'guest') return true;
        }
        return false;
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