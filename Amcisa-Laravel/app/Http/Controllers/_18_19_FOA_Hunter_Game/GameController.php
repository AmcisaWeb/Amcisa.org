<?php

namespace App\Http\Controllers\_18_19_FOA_Hunter_Game;

use App\Events\_18_19_FOA_Hunter_Game;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class GameController extends Controller
{
    private $dataBase = '18/19_foa_hunter_game_database';
    private $tables = ['inventory', 'og1_players', 'og2_players'];

    public function purchase(Request $request){
        $itemPrices = [100, 500, 300, 50, 800];
        $totalPrice = 0;
        $og = $request->input('og');

        //calculate total price
        $totalPrice += $request->input('item1') * $itemPrices[0];
        $totalPrice += $request->input('item2') * $itemPrices[1];
        $totalPrice += $request->input('item3') * $itemPrices[2];
        $totalPrice += $request->input('item4') * $itemPrices[3];
        $totalPrice += $request->input('item5') * $itemPrices[4];
        $this->changeCash(-$totalPrice, $og);

        //add item to inventory
        $items = DB::connection($this->dataBase)->table($this->tables[0])
            ->where('og', $og)
            ->get()
            ->first();
        $items->item1 += $request->input('item1');
        $items->item2 += $request->input('item2');
        $items->item3 += $request->input('item3');
        $items->item4 += $request->input('item4');
        $items->item5 += $request->input('item5');
        DB::connection($this->dataBase)->table($this->tables[0])
            ->where('og', $og)
            ->update(['item1' => $items->item1,
                'item2' => $items->item2,
                'item3' => $items->item3,
                'item4' => $items->item4,
                'item5' => $items->item5]);

        broadcast(new _18_19_FOA_Hunter_Game\Purchased())->toOthers();

        return response()->json('Successfully Purchased', 200);
    }

    public function getTime(){
        $og1 = DB::connection($this->dataBase)->table($this->tables[1])->get();
        $og2 = DB::connection($this->dataBase)->table($this->tables[2])->get();
        $response = [
            'og1' => $og1,
            'og2' => $og2
        ];
        return response()->json($response, 200);
    }

    public function getInventory(){
        $response = DB::connection($this->dataBase)->table($this->tables[0])->get();
        return response()->json($response, 200);
    }

    public function playerStart(Request $request){


        $og = $request->input('og');
        $now = Carbon::now('Asia/Singapore')->toTimeString();
        $idlePlayer = null;
        $table = null;

        switch ($og){
            case 1:
                $table = $this->tables[1];
                break;
            case 2:
                $table = $this->tables[2];
                break;
            default:
                return response()->json('You have send a wrong data',400);
        }
        $idlePlayer = DB::connection($this->dataBase)->table($table)
            ->whereNull('start_time')
            ->first();
        if($idlePlayer == null)
            return response()->json('No more idle player', 200);
        DB::connection($this->dataBase)->table($table)
            ->where('id', $idlePlayer->id)
            ->update(['start_time' => $now]);

        broadcast(new _18_19_FOA_Hunter_Game\PlayerStarted())->toOthers();

        return response()->json('OG'.$og . ' Player' . $idlePlayer->id . ' Start Time has been added: ' . $now, 200);
    }

    public function playerEnd(Request $request){
        $og = $request->input('og');
        $now = Carbon::now('Asia/Singapore')->toTimeString();
        $idlePlayer = null;
        $table = null;

        switch ($og){
            case 1:
                $table = $this->tables[1];
                break;
            case 2:
                $table = $this->tables[2];
                break;
            default:
                return response()->json('You have send a wrong data',400);
        }
        $idlePlayer = DB::connection($this->dataBase)->table($table)
            ->whereNull('end_time')
            ->first();
        if($idlePlayer == null)
            return response()->json('No more idle player', 200);
        if($idlePlayer->start_time == null)
            return response()->json('OG'.$og . ' Player' . $idlePlayer->id . ' has not started, cannot be ended', 200);
        DB::connection($this->dataBase)->table($table)
            ->where('id', $idlePlayer->id)
            ->update(['end_time' => $now]);

        //compute cash
        $startTimeArr = explode(":", $idlePlayer->start_time);
        $endTimeArr = explode(":", $now);

        foreach ($startTimeArr as $key => $value){
            $startTimeArr[$key] = (int)$value;
        }
        foreach ($endTimeArr as $key => $value){
            $endTimeArr[$key] = (int)$value;
        }
        $startTimeSec = $startTimeArr[0]*3600 + $startTimeArr[1]*60 + $startTimeArr[2];
        $endTimeSec = $endTimeArr[0]*3600 + $endTimeArr[1]*60 + $endTimeArr[2];
        $deltaTime = $endTimeSec - $startTimeSec;
        $this->changeCash($deltaTime, $og);

        broadcast(new _18_19_FOA_Hunter_Game\PlayerEnded())->toOthers();

        return response()->json('OG'.$og . ' Player' . $idlePlayer->id . ' End Time has been added: ' . $now, 200);
    }

    private function changeCash($offset, $og){   //return the final cash
        $inventory = DB::connection($this->dataBase)->table($this->tables[0])
            ->where('og', $og)
            ->get()
            ->first();
        if($inventory->cash == null) $inventory->cash = 0;
        $cash = $inventory->cash + $offset;
        if($cash<0) return -1;
        DB::connection($this->dataBase)->table($this->tables[0])
            ->where('og', $og)
            ->update(['cash' => $cash]);
        return $cash;
    }

    public function resetTime(){
        DB::connection($this->dataBase)->table($this->tables[1])
            ->update(['start_time' => null, 'end_time' => null]);
        DB::connection($this->dataBase)->table($this->tables[2])
            ->update(['start_time' => null, 'end_time' => null]);
        return response()->json('OG1 & OG2 all players timing has been reset', 200);
    }

    public function resetCash(){
        DB::connection($this->dataBase)->table($this->tables[0])
            ->update(['cash' => 0]);
        return response()->json('OG1 & OG2 cash has been reset to 0', 200);
    }

    public function resetItems(){
        DB::connection($this->dataBase)->table($this->tables[0])
            ->update(['item1' => 0,
                'item2' => 0,
                'item3' => 0,
                'item4' => 0,
                'item5' => 0]);
        return response()->json('OG1 & OG2 items has been reset', 200);
    }
}
