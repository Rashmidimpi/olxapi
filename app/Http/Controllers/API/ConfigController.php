<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\College;
use Validator;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    //

    public function getAllCollegeName()
    {
        error_log('Rashmi is here');
        return College::all();
    }

    public function storeCollegeName(Request $request)
    {
        $validator = Validator::make($request->all(), [
            
            'college_name' => 'required',
            
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        error_log('Rashmi was here');
        $college = College::create($request->all());
        return response()->json([
            "message" => "college record created",
        ], 201);

    }

}
