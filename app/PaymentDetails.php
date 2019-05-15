<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentDetails extends Model
{
    use SoftDeletes;

    protected $table = 'payment_details';
    
    protected $primaryKey = 'pd_id';

    protected $fillable = [
        'pay_id','com_order_id','paid_amount'
    ];

    public function complete_order (){
        return $this->belongsTo('App\CompleteOrder','com_order_id','com_order_id');
    }
}
