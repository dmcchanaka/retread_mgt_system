<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    protected $table = 'user_types';

    protected $fillable = [
        'user_type'
    ];

    public function user(){
        return $this->hasMany('App\User', 'u_tp_id', 'u_tp_id');
    }
}
