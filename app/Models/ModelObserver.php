<?php
namespace App\Models;

class ModelObserver {

    public function saving($model)
    {
    	if(empty($model->id) ){
        	$model->user_id = \Auth::id();
    	}
    }

    public function saved($model)
    {
        //
    }

}