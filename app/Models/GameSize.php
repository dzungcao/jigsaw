<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameSize extends Model
{
    protected $fillable = ['title','row','col','pieces'];
}
