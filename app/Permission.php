<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    use SoftDeletes;
    
    protected $table = 'permission';
    
    protected $primaryKey = 'per_id';
    
    protected $fillable = [
        'section_name','parent_id'
    ];
}
