<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;

    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'users';

    protected $fillable = [
        'name', 'u_tp_id', 'email','nic','mobile_no', 'gender', 'address', 'password','pg_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function userTypes(){
        return $this->belongsTo('App\UserType', 'u_tp_id', 'u_tp_id');
    }

    public function permission_group(){
        return $this->belongsTo('App\PermissionGroup', 'pg_id', 'pg_id');
    }

    public function user_permission(){
        return $this->hasMany('App\UserPermission','pg_id','pg_id');
    }

}
