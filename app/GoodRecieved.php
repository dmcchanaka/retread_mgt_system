<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GoodRecieved extends Model
{
    use SoftDeletes;
    
    protected $table = 'good_recieveds';
    
    protected $primaryKey = 'grn_id';
    
    protected $fillable = [
        'grn_no','invoice_no','net_amount'
    ];
    
    public function grn_item(){
        return $this->hasMany('App\RecievedBelt', 'grn_id','grn_id');
    }
}
