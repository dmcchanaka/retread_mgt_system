<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;

    protected $table = 'customers';
    
    protected $primaryKey = 'cus_id';

    protected $fillable = [
        'customer_name','gender','address','nic','mobile_no','email','customer_type','credit_limit_availability','credit_amount'
    ];
}
