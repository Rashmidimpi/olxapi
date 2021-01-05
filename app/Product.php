<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $table = 'products';
    protected $fillable = [
        'product_name','category_id','product_description', 'product_price','location','product_image_1',
        'user_id',       
          
    ];

    public function Category() 
    {
        return $this->belongsTo('App\Category', 'product_categoryid', 'categoryid');
    }
}
