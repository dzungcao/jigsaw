<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Game;

class ApiController extends Controller
{
    public function getNewpics(){
        $max = env('MAX_ITEMS_HOME',30);
        $games = Game::where('custom_game',false)
                            ->orderBy('created_at','desc')
                            ->take($max)
                            ->get();
        
        return \Response::json($games)->header("Access-Control-Allow-Origin","*");
    }
    public function getPic($id){
        $game = Game::where('game_id',$id)->firstOrFail();
        $rows = array_filter(explode('@',$game->pieces));
        $elements = [];
        for ($i=0; $i < count($rows); $i++) { 
            $cells = array_filter(explode('|', $rows[$i]));
            for ($j=0; $j < count($cells); $j++) { 
                $cell = [];
                $dimensions = array_filter(explode('.',$cells[$j]));
                foreach ($dimensions as $dim) {
                    if(str_contains($dim,'top')){
                        $cell['top'] = $dim;
                    }
                    elseif(str_contains($dim,'right')){
                        $cell['right'] = $dim;
                    }
                    elseif(str_contains($dim,'bottom')){
                        $cell['bottom'] = $dim;
                    }
                    elseif(str_contains($dim,'left')){
                        $cell['left'] = $dim;
                    }
                }
                $elements[] = ['row'=>$i+1,'col'=>$j+1,'cells'=>$cell,'path'=>'/gamedir/'.$game->game_id.'/'.($i+1).''.($j+1).'.png'];
            }
        }
        return \Response::json(['game'=>$game,'pieces'=>$elements]);
    }
}
