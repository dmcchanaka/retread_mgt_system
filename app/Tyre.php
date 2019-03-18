<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tyre extends Model
{
    use SoftDeletes;
    protected $table = 'tyres';
    
    protected $primaryKey = 'tyre_id';

    protected $fillable = [
        'tyre_name','tyre_size','manufac_id'
    ];

    public function manufacture(){
        return $this->belongsTo('App\Manufactures', 'manufac_id', 'manufac_id');
    }
}
