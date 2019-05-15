<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use SoftDeletes;
    
    protected $table = 'payment';
    
    protected $primaryKey = 'pay_id';

    protected $fillable = [
        'pay_no','pay_amount','cus_id','com_order_id','added_by'
    ];

    public function customer (){
        return $this->belongsTo('App\Customer','cus_id','cus_id');
    }

    public function user (){
        return $this->belongsTo('App\User','added_by','id');
    }

    public function payment_details (){
        return $this->hasMany('App\PaymentDetails', 'pay_id','pay_id');
    }

    public function payment_cheque(){
        return $this->hasOne('App\PaymentCheque', 'pay_id','pay_id');
    }
}
