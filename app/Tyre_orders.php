<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tyre_orders extends Model
{
    use SoftDeletes;

    protected $table = 'tyre_orders';
    
    protected $primaryKey = 'order_id';

    protected $fillable = [
        'order_no','cus_id','order_amount','discount','discount_per','complete_status','added_by'
    ];

    public function customer (){
        return $this->belongsTo('App\Customer','cus_id','cus_id');
    }

    public function order_product(){
        return $this->hasMany('App\TyreOrderProduct','order_id','order_id');
    }
}
