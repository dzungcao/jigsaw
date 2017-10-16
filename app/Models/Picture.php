<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{
	protected $fillable = ['created_by','path','custom_pic'];
}
