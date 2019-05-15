<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentCheque extends Model
{
    use SoftDeletes;

    protected $table = 'payment_cheque';
    
    protected $primaryKey = 'pc_id';

    protected $fillable = [
        'pay_id','cheque_no','bank','branch','cheque_date'
    ];
}
