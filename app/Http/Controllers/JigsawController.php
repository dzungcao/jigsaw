<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Game;
use App\Models\Picture;
use App\Models\GameScore;
use App\Helper\GameBuilder;

class JigsawController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function play($code)
    {
        $game = Game::where('game_id',$code)->firstOrFail();
        $category = $game->category;
        return view('play',compact('game','category'));
    }
    public function iframe($code)
    {
        $game = Game::where('game_id',$code)->firstOrFail();
        return view('iframe',compact('game'));
    }
    public function load($code)
    {
        $game = Game::where('game_id',$code)->firstOrFail();
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
        return \Response::json(['game_id'=>$game->game_id,'time'=>120,'pieces'=>$elements]);
    }
    public function count(){
        $rules = ['game_id'=>'required|exists:games'];
        $validation = \Validator::make(\Input::all(),$rules);
        if($validation->fails()){
            return \Response::json(['success'=>false]);
        }
        $gameScore = GameScore::where('created_by',\Auth::user()->id)
                                ->where('game_id',\Input::get('game_id'))
                                ->first();
        if(!$gameScore){
            $gameScore = new GameScore();
            $gameScore->created_by = \Auth::user()->id;
            $gameScore->game_id = \Input::get('game_id');
            $gameScore->score = 0;
            $gameScore->time = 0;
        }
        $gameScore->count += 1;
        $gameScore->save();
        return \Response::json(['success'=>true]);
    }
    public function score(){
        $rules = ['game_id'=>'required|exists:games','time'=>'required|integer'];
        $validation = \Validator::make(\Input::all(),$rules);
        if($validation->fails()){
            return \Response::json(['success'=>false]);
        }
        $gameScore = GameScore::where('created_by',\Auth::user()->id)
                                ->where('game_id',\Input::get('game_id'))
                                ->first();
        if(!$gameScore){
            return \Response::json(['success'=>false]);
        }
        $inputs = \Input::all();
        $gameScore->score = max(6-$gameScore->count,1);
        $gameScore->time = \Input::get('time');
        if(!$gameScore->completed){
            $user = \Auth::user();
            $user->score += $gameScore->score;
            $user->time += $gameScore->time;
            $user->pic_done += 1;
            $user->save();
            $gameScore->completed = true;
        }
        $gameScore->save();
        return \Response::json(['success'=>true]);
    }
    public function player($username){
        $user = User::where('username',$username)->first();
        return view('user',compact('user'));
    }
}
