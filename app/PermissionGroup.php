<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PermissionGroup extends Model
{
    use SoftDeletes;
    
    protected $table = 'permission_group';
    
    protected $primaryKey = 'pg_id';
    
    protected $fillable = [
        'group_name','u_tp_id'
    ];

    public function user_type(){
        return $this->belongsTo('App\UserType','u_tp_id','u_tp_id');
    }

    public function user_permission(){
        return $this->hasMany('App\UserPermission','pg_id','pg_id');
    }
}
