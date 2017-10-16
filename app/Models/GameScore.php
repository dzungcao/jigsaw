<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameScore extends Model
{
    protected $fillable = ['game_id','created_by','time','count','score','completed'];

    public function game(){
    	return Game::where('game_id',$this->game_id)->first();
    }
}
