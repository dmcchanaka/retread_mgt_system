<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Belt_price extends Model
{
    use SoftDeletes;

    protected $table = 'belt_prices';
    protected $primaryKey = 'price_id';
    protected $fillable = ['tyre_id', 'cat_id', 'sub_cat_id', 'price_no', 'rp_price', 'cus_price'];

    public function category()
    {
        return $this->belongsTo('App\Belt_category', 'cat_id', 'cat_id');
    }

    public function subcategory()
    {
        return $this->belongsTo('App\Belt_subcategory', 'sub_cat_id', 'sub_cat_id');
    }
    public function tyre()
    {
        return $this->belongsTo('App\Tyre', 'tyre_id', 'tyre_id');
    }
    public function received_balt(){
        return $this->hasMany('App\RecievedBelt', 'price_id','price_id');
    }

}
