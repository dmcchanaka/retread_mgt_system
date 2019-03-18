<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Belt_subcategory extends Model
{
    use SoftDeletes;

    protected $table = 'belt_subcategories';
    
    protected $primaryKey = 'sub_cat_id';

    protected $fillable = [
        'sub_cat_name','cat_id'
    ];

    public function belt_category(){
        return $this->belongsTo('App\Belt_category','cat_id','cat_id');
    }
}
