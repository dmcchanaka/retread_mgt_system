<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Belt_category extends Model
{
    use SoftDeletes;
    
    protected $table = 'belt_categories';
    
    protected $primaryKey = 'cat_id';

    protected $fillable = [
        'cat_name'
    ];
    
    public function sub_category(){
        return $this->hasMany('App\Belt_subcategory','cat_id','cat_id');
    }
    
    public function price(){
        return $this->hasMany('App\Belt_price', 'cat_id', 'cat_id');
    }
}
