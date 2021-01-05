<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Category;
use Validator;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function getAllCategoryName()
    {
        error_log('Rashmi is here');
        return Category::all();
    }

    public function storeCategoryName(Request $request)
    {
        $validator = Validator::make($request->all(), [
            
            'category' => 'required',
            
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        error_log('Rashmi was here');
        $category = Category::create($request->all());
        return response()->json([
            "message" => "category created",
        ], 201);

    }

    // public function update(Request $request, $id)
    // {
    //     error_log('in update');
    //     error_log($id);
        
    //     if(Category::where('id', $id)->exists()) {
    //         error_log($id);
    //         $category = Category::find($id);
    //         $category->category = is_null($request->category) ? $category->category : $request->category;
    //         $category->save();
    
    //         return response()->json([
    //             "message" => "records updated successfully"
    //         ], 200);
    //         } else {

    //         return response()->json([
    //             "message" => "record not found"
    //         ], 404);
            
    //     }
    // }

    public function update(Request $request, $id)
    {
        error_log('in update');
        error_log('cat id');
        error_log($request->id);
        error_log('category');
        error_log($request->category);

        error_log('in =================');
        // error_log($request);
        error_log($id);
        if (Category::where('id', $request->id)->exists()) {
            error_log($request->id);
            $category = Category::find($request->id);
            // $employee->update(['name'=>$request->name,'email' =>$request->email, 'gender'=>$request->gender,'address'=>$request->address]);
            $category->update($request->all());
            // $employee->save();

            return response()->json([
                "message" => "records updated successfully"
            ], 200);
        } else {
            return response()->json([
                "message" => "record not found"
            ], 404);
        }
    }


    public function destroy($id)
    {
        error_log('id to delete');
        error_log($id);
        if(Category::where('id', $id)->exists()) {
            $user = Category::find($id);
            $user->delete();
    
            return response()->json([
              "message" => "records deleted"
            ], 202);
          }

        $category->destroy();
        return response()->json(null, 204);

    }

}
