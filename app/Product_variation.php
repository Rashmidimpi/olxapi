<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product_variation extends Model
{
    //
    protected $table = 'product_variations';
    protected $fillable = [
        'product_id' ,
        'attribute_id',
        'attribute_value',
        'attribute_rate',
          
    ];
}
