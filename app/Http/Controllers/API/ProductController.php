<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Product;
use App\Category;
use App\Product_variation;
use Validator;
use Session;
use DB;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    // To show all category

    //     public function index(Request $request, $slug)
    // {
    //     $products = Product::whereHas('product_category', function ($query) use ($categorySlug) {
    //         $query->where('category_slug', $categorySlug);
    //     })->get();
    // }

    public function getAllProductName()
    {
        error_log('Product');
        return Product::all();
    }

    public function getAllProductWithWishlist()
    {
        error_log('Product all');
        $allProduct = Product::select('products.*', 'wishlists.is_deleted')
            ->leftJoin('wishlists', 'wishlists.productid', 'products.productid')
            ->get();
        return response()->json($allProduct);
    }

    public function getAllProductById($id)
    {
        error_log('Product all by id');
        // $product = Product::select('products.*','wishlists.is_deleted')
        //                 ->leftJoin('wishlists','wishlists.productid','products.productid')
        //                 ->where('products.productid','=',$id)
        //                 ->get();

        $call = 'call_charge';
        $product = Product::select('products.*', 'wishlists.is_deleted')
            ->selectRaw('(select applicationconfigs.parametervalue from applicationconfigs WHERE applicationconfigs.parametername = ? ) as call_charge', ['call_charge'])
            ->selectRaw('(select applicationconfigs.parametervalue from applicationconfigs WHERE applicationconfigs.parametername = ? ) as chat_charge', ['chat_charge'])
            ->leftJoin('wishlists', 'wishlists.productid', 'products.productid')
            ->where('products.productid', '=', $id)
            ->get();
        return response()->json($product);
    }

    public function storeProduct(Request $request)
    {
        error_log("king is here");
        // error_log($request);
        $validator = Validator::make($request->all(), [

            'category_id'  => 'required',
            'product_name'  => 'required',
            'product_description'  => 'required',
            'product_price'  => 'required',
            'location'  => 'required',
            'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $upload_path = 'images/';
        $product_image_url = null;
        $success1 = 0;
        if ($request->file('product_image_1')) {
            error_log("product image data");

            $productImage = $request->file('product_image_1');
            $productImageSaveAsName = time() . "-" . $request->user_id . "-product." . $productImage->getClientOriginalExtension();
            $product_image_url = $upload_path . $productImageSaveAsName;
            $success1 = $productImage->move($upload_path, $productImageSaveAsName);
            error_log($success1);
        } else {
            return response()->json(['error' => "iamge not found"], 401);
        }
        if ($success1 == 0) {
            return response()->json(['error' => "iamge not uploaded"], 401);
        }

        // error_log("product data");
        // error_log($request->product_name);
        // error_log($request->product_description);
        // error_log($request->product_price);
        // error_log($request->location);
        // error_log($request->category_id);
        // error_log($request->user_id);
        // error_log($product_image_url);
        // error_log($request->file('product_image_1'));

        $product =  Product::create([
            'product_name' => $request->product_name,
            'product_description' => $request->product_description,
            'product_price' => $request->product_price,
            'location' => $request->location,
            'category_id' => $request->category_id,
            'user_id' => $request->user_id,
            'product_image_1' => $product_image_url,
        ]);

        // error_log('Rashmi was here');
        $success['message'] =  "Success";
        // $success['name'] =  $product->productid;
        // $success['product_name'] =  $product->product_name;
        return response()->json(['success' => $success], 201);

        // $product = Product::create($request->all());
        // return response()->json([
        //     "message" => "Product added",
        // ], 201);
    }

    public function index()
    {
        error_log("in index");
        $category = Product::select('categories.category_name', 'products.*')
            ->leftJoin('categories', 'categories.categoryid', 'products.product_categoryid')->get();
        foreach ($category as $c) {
            $output[] = array(
                "category" => $c->category_name
            );
        }
        return response()->json($category);
    }


    public function create()
    {
        error_log("in create");
        $product = Product::select('product_variations.attribute_rate', 'products.*')
            ->leftJoin('product_variations', 'product_variations.product_id', 'products.productid')->get();
        foreach ($product as $p) {
            error_log("product");
            $output[] = array(
                "product" => $p->attribute_rate

            );
        }
        return response()->json($product);
    }

    // $order=new Order();
    //         	$order->dealerid=$request->dealerid;
    //         	$order->executiveid=$request->executiveid;
    //         	$order->amount=$request->totalamount;
    //         	$order->orderdate=date('Y-m-d');
    //         	$order->orderstatus='pending';
    //         	$order->paymentstatus='pending';
    //             $items=json_decode($request->items);
    //         	if($order->save())
    //         	{
    //         		$id=$order->id;
    //         		foreach($items as $item)
    //         		{
    //         			$od=new Orderitem();
    //         			$od->orderid=$id;
    //         			//$od->dealerid=$request->dealerid;
    //         			$od->quantity=$item->quantity;
    //         			$od->productid=$item->productid;
    //         			$od->itemprice=$item->itemprice;
    //         			$od->totalamount=$item->quantity*$item->itemprice;
    //         			$od->save();
    //         		}
    //         		$resp = ['success'=>'true','response'=>'Order received successfully'];
    //         	}
    public function product(Request $request)
    {
        error_log("in create");
        $data = new Product();
        $data->productid = $request->productid;
        $data->product_name = $request->product_name;
        $data->product_slug = $request->product_slug;
        $data->product_category = $request->product_category;
        $data->product_categoryid = $request->product_categoryid;
        $data->category_name = $request->category_name;
        $data->short_description = $request->short_description;
        // Print_r ($data);
        $variations = json_decode($request->variation);
        if ($data->save()) {
            echo $data->id;
            $id = $data->id;
            foreach ($variations as $variation) {
                $var = new Product_variation();
                $var->id = $id;
                $var->productid = $pid;
                $var->attribute_id = $attribute_id;
                $var->attribute_value = $attribute_value;
                $var->attribute_rate = $attribute_rate;
                $var->save();
            }
            //print_r($variations);

        }

        $resp = ['success' => 'true', 'response' => 'Product received successfully'];
    }

    // get  product by category name
    public function getProductByCategory($category)
    {

        $categoryID = Category::where('category_name', $category)->pluck('categoryid');

        $allproduct = Product::select('categories.category_name', 'products.*')
            ->leftJoin('categories', 'categories.categoryid', 'products.category_id')
            ->where('categories.categoryid', $categoryID)
            ->get();

        return response()->json($allproduct);
    }

    public function deleteProduct(Request $request)
    {

        $updated = Product::where('productid', $request->productid)
            ->update(['is_deleted_at' => 0]);

        if (!$updated) {
            return response()->json(['message' => 'Product not deleted.']);
        }

        return response()->json(['message' => 'Product deleted.']);
    }

    public function sellProduct(Request $request)
    {
        $updated = Product::where('productid', $request->productid)
            ->update(['is_available' => 0]);

        if (!$updated) {
            return response()->json(['message' => 'Product status not updated.']);
        }

        return response()->json(['message' => 'Product status updated.']);
    }

    public function getProductByUser(Request $request)
    {
        error_log(" in get product by user");
        $myproduct = Product::select('products.*')
            // ->leftJoin('categories', 'categories.categoryid', 'products.category_id')
            // ->leftJoin('users', 'users.id', 'products.user_id')
            ->where('products.user_id', $request->user_id)
            ->get();

        return response()->json($myproduct);
    }

    public function searchProduct($search)
    {
        $searchProducts = Product::where("productname", "LIKE", "%{$search}%")
            ->orWhere("product_description", "LIKE", "%{$search}%")
            ->orWhere("short_description", "LIKE", "%{$search}%")
            ->orWhere("short_description", "LIKE", "%{$search}%")
            ->groupBy('id');

        return response()->json($searchProducts);
    }
    // public function product()
    // {  
    //     error_log("in create");
    //     $product = Product::select('products.*','product_variations.*')
    //                 ->leftJoin('product_variations','product_variations.product_id','products.productid')->get();


    public function updateUserStatus(Request $request)
    {
        // $user= User::all();

        // $update = Post::find($id);
        // $user_id = $request->id;
        
        if($request->is_deleted == 'true'){
            error_log('Status');
            $ravi = Product::where('productid', $request->id)
            ->update(['is_deleted' => 1]);
        }else{
            error_log('inactive');
            $ravi = Product::where('productid', $request->id)
            ->update(['is_deleted' => 0]);
        }
        if (!$ravi) {
            return response()->json(['message' => 'status not updated.']);
        }

        return response()->json(['message' => 'status updated.']);
    }



}
