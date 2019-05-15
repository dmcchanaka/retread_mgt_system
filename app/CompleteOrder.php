<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompleteOrder extends Model
{
    use SoftDeletes;
    
    protected $table = 'complete_orders';
    
    protected $primaryKey = 'com_order_id';

    protected $fillable = [
        'order_id','com_order_no','cus_id','com_order_amount','discount','discount_per','added_by'
    ];
    
    public function customer (){
        return $this->belongsTo('App\Customer','cus_id','cus_id');
    }
    
    public function tyre_order(){
        return $this->hasOne('App\Tyre_orders', 'order_id','order_id');
    }
    
    public function com_order_product(){
        return $this->hasMany('App\CompleteOrderProduct','com_order_id','com_order_id');
    }

    public function payment_details(){
        return $this->hasMany('App\PaymentDetails', 'com_order_id','com_order_id');
    }
}
