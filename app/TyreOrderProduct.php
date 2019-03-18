<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TyreOrderProduct extends Model
{
    use SoftDeletes;

    protected $table = 'tyre_order_product';

    protected $primaryKey = 'op_id';

    protected $fillable = [
        'order_id','tyre_id','price_id','discount','discount_per','qty','line_amount'
    ];
    public function order_product(){
        return $this->belongsTo('App\Tyre_orders','order_id','order_id');
    }
    public function tyre(){
        return $this->belongsTo('App\Tyre', 'tyre_id', 'tyre_id');
    }
    public function price(){
        return $this->belongsTo('App\Belt_price', 'price_id', 'price_id');
    }
}
