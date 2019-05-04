<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reason extends Model
{
    use SoftDeletes;
    
    protected $table = 'reason';
    
    protected $primaryKey = 'rsn_id';
    
    protected $fillable = [
        'rsn_type','rsn_name'
    ];
}
