<?php

namespace App\Http\Controllers\API;

use App\Applicationconfig;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApplicationconfigController extends Controller
{
    public function addconfiguration(Request $request){

        error_log("in app config controller");
        $product = Applicationconfig::create($request->all());
        return response()->json([
            "message" => "Parameter added",
        ], 201);
    }

    public function getAllConfiguration()
    {
        error_log('Product');
        $config= Applicationconfig::all();
        return response()->json($config);
    }

    public function updateUserStatus(Request $request)
    {
        // $user= User::all();

        // $update = Post::find($id);
        // $user_id = $request->id;
        
        if($request->active_status == 'true'){
            error_log('Status');
            $ravi = User::where('id', $request->id)
            ->update(['active_status' => 1]);
        }else{
            error_log('inactive');
            $ravi = User::where('id', $request->id)
            ->update(['active_status' => 0]);
        }
        if (!$ravi) {
            return response()->json(['message' => 'active status not updated.']);
        }

        return response()->json(['message' => 'Active status updated.']);
    }




    


}
