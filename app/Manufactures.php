<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Manufactures extends Model
{
    use SoftDeletes;

    protected $table = 'manufactures';

    protected $fillable = [
        'manufacture_name'
    ];
}
