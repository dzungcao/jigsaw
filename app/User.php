<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\User;
use App\Models\Application;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','admin','manager','approver','editor','user','username','score','time','pic_done'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getAvatar(){
        if(isset($this->avatar))
            return $this->avatar;
        return '/img/default-profile.jpg';
    }
    public function games(){
        return $this->hasMany('\App\Models\GameScore','created_by');
    }
}
