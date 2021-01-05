<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product_variation;
use Validator;

class ProductVariationController extends Controller
{
    //

    public function getAllVariationName()
    {
        error_log('Rashmi is here');
        return Product_variation::all();
    }

    public function store(Request $request)
{
    //
    $validator = Validator::make($request->all(), [
        
       
        'product_id'  => 'required',
        'attribute_id' => 'required',
        'attribute_value' => 'required',
        'attribute_rate' => 'required',
          
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 401);
    }

    error_log('Rashmi was here');
    $productvar = Product_variation::create($request->all());
    return response()->json([
        "message" => "Product variation stored",
    ], 201);

}
}
   

