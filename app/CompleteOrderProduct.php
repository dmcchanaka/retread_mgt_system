<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompleteOrderProduct extends Model
{
    use SoftDeletes;

    protected $table = 'complete_order_products';

    protected $primaryKey = 'cop_id';

    protected $fillable = [
        'com_order_id','tyre_id','price_id','discount','discount_per','qty','line_amount','serial_no'
    ];
    
    public function complete_order(){
        return $this->belongsTo('App\CompleteOrder','com_order_id','com_order_id');
    }
    public function tyre(){
        return $this->belongsTo('App\Tyre', 'tyre_id', 'tyre_id');
    }
    public function price(){
        return $this->belongsTo('App\Belt_price', 'price_id', 'price_id');
    }
}
