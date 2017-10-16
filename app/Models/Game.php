<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = ['game_id','title','original_picture','promotion_picture','featured','public','created_by','pieces','time','description','custom_game','category_id'];

    public function getPieces(){
    	$arr = [];
    	for ($i=1; $i <= 6; $i++) { 
	    	for ($j=1; $j <= 6; $j++) { 
	    		$arr[] = array('path'=>'/gamedir/'.$this->game_id.'/'.$i.''.$j.'.png',
	    						'row'=>$i,
	    						'col'=>$j
	    						);
	    	}
    	}
    	return $arr;
    }
    public function author(){
        return $this->belongsTo('App\User','created_by');
    }
    public function category(){
        return $this->belongsTo('App\Models\Category','category_id');
    }
}
