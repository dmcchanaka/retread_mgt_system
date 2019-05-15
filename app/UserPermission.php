<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserPermission extends Model
{
    use SoftDeletes;

    protected $table = 'user_permission';
    
    protected $primaryKey = 'up_id';
    
    protected $fillable = [
        'pg_id','per_id'
    ];

    public function permission_group(){
        return $this->belongsTo('App\PermissionGroup','pg_id','pg_id');
    }

    public function permission(){
        return $this->belongsTo('App\Permission','per_id','per_id');
    }
}
