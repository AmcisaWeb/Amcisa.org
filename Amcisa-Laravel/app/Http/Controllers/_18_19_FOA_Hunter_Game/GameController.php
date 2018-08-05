<?php

namespace App\Http\Controllers\_18_19_FOA_Hunter_Game;

use App\Events\_18_19_FOA_Hunter_Game;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use function Sodium\crypto_generichash_update;

class GameController extends Controller
{
    private $dataBase = '18/19_foa_hunter_game_database';
    private $tables = ['inventory', 'og1_players', 'og2_players'];

    public function purchase(Request $request){
        $itemPrices = [1800, 3600, 15000];
        $totalPrice = 0;
        $og = $request->input('og');

        //calculate total price
        $totalPrice += $request->input('back_pack') * $itemPrices[0];
        $totalPrice += $request->input('med_kit') * $itemPrices[1];
        $totalPrice += $request->input('frying_pan') * $itemPrices[2];
        $this->changeCash(-$totalPrice, $og);

        //add item to inventory
        $inventory = DB::connection($this->dataBase)->table($this->tables[0])
            ->where('og', $og)
            ->get()
            ->first();
        $inventory->back_pack += $request->input('back_pack');
        $inventory->med_kit += $request->input('med_kit');
        $inventory->frying_pan += $request->input('frying_pan');
        DB::connection($this->dataBase)->table($this->tables[0])
            ->where('og', $og)
            ->update(['back_pack' => $inventory->back_pack,
                'med_kit' => $inventory->med_kit,
                'frying_pan' => $inventory->frying_pan]);

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
        $endTime = $request->input('end_time');
        $idlePlayer = null;
        $table = null;

        //check if time format valid
        list($hr, $min, $sec) = explode(":", $endTime);
        try{
            $hr = (int)$hr;
            $min = (int)$min;
            $sec = (int)$sec;
        }catch (\Exception $e){
            return response()->json($e->getMessage(), 400);
        }

        if($hr>23 || $min>59 || $sec>59)
            return response()->json('time format error', 400);

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
            ->update(['end_time' => $endTime]);

        //compute cash
        $startTimeArr = explode(":", $idlePlayer->start_time);
        $endTimeArr = explode(":", $endTime);

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

        return response()->json('OG'.$og . ' Player' . $idlePlayer->id . ' End Time has been added: ' . $endTime, 200);
    }

    public function allPlayersEnd(Request $request){
        $now = Carbon::now('Asia/Singapore')->toTimeString();

        for($i=1; $i<3; $i++){
            $table = $this->tables[$i];
            $idlePlayers = DB::connection($this->dataBase)->table($table)
                ->whereNotNull('start_time')
                ->whereNull('end_time')
                ->get();

            DB::connection($this->dataBase)->table($table)
                ->whereNotNull('start_time')
                ->whereNull('end_time')
                ->update(['end_time' => $now]);

            //compute cash
            $deltaTime = 0;
            foreach ($idlePlayers as $idlePlayer){
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
                $deltaTime += $endTimeSec - $startTimeSec;
            }
            $this->changeCash($deltaTime, $i);
        }

        broadcast(new _18_19_FOA_Hunter_Game\PlayerEnded())->toOthers();
        return response()->json('All Players has ended: ' . $now, 200);
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

    public function addCash(Request $request){
        $og = $request->input('og');
        $cash = $request->input('cash');
        $this->changeCash($cash, $og);
        broadcast(new _18_19_FOA_Hunter_Game\Purchased())->toOthers();

        return response()->json('successfully added time', 200);
    }

    public function resetTime(){
        DB::connection($this->dataBase)->table($this->tables[1])
            ->update(['start_time' => null, 'end_time' => null]);
        DB::connection($this->dataBase)->table($this->tables[2])
            ->update(['start_time' => null, 'end_time' => null]);
        broadcast(new _18_19_FOA_Hunter_Game\PlayerEnded())->toOthers();
        return response()->json('OG1 & OG2 all players timing has been reset', 200);
    }

    public function resetCash(){
        DB::connection($this->dataBase)->table($this->tables[0])
            ->update(['cash' => 0]);
        broadcast(new _18_19_FOA_Hunter_Game\Purchased())->toOthers();
        return response()->json('OG1 & OG2 cash has been reset to 0', 200);
    }

    public function resetItems(){
        DB::connection($this->dataBase)->table($this->tables[0])
            ->update(['back_pack' => 0,
                'med_kit' => 0,
                'frying_pan' => 0]);
        broadcast(new _18_19_FOA_Hunter_Game\Purchased())->toOthers();

        return response()->json('OG1 & OG2 items has been reset', 200);
    }
}
