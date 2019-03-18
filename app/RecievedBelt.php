<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RecievedBelt extends Model
{
    use SoftDeletes;
    
    protected $table = 'received_belts';
    
    protected $primaryKey = 'rec_id';
    
    protected $fillable = [
        'grn_id','tyre_id','price_id','qty','remaining_qty'
    ];
    
    public function grn(){
        return $this->belongsTo('App\GoodRecieved','grn_id','grn_id');
    }
    public function tyre(){
        return $this->belongsTo('App\Tyre', 'tyre_id', 'tyre_id');
    }
    public function price(){
        return $this->belongsTo('App\Belt_price', 'price_id', 'price_id');
    }
}
