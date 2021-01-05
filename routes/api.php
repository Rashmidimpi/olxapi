<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

    //For login and register
    Route::post('login', 'API\UserController@login');
    Route::post('register', 'API\UserController@register');
    // Route::post('storeuser', 'API\UserController@storeAllUserName');

    //To get the list of user
    Route::get('getuser', 'API\UserController@getAllUserName');
    //To store and get the college name
    Route::get('college', 'API\ConfigController@getAllCollegeName');
    Route::post('college', 'API\ConfigController@storeCollegeName');
    //CRUD of category
    Route::get('category', 'API\CategoryController@getAllCategoryName');
    Route::post('category', 'API\CategoryController@storeCategoryName');
    Route::put('category/{id}', 'API\CategoryController@update');
    Route::delete('category/{id}', 'API\CategoryController@destroy');
    

    Route::get('product', 'API\ProductController@getAllProductName');
    Route::get('getproduct', 'API\ProductController@getAllProductWithWishlist');
    Route::get('getproductdetail/{id}', 'API\ProductController@getAllProductById');
    Route::post('addProduct', 'API\ProductController@storeProduct');
    Route::post('getMyProduct', 'API\ProductController@getProductByUser');
    Route::post('wishlist', 'API\WishlistController@store');

    Route::post('addconfig', 'API\ApplicationconfigController@addconfiguration');
    Route::post('updatestatus', 'API\ApplicationconfigController@updateUserStatus');
    Route::post('status', 'API\ProductController@updateUserStatus');
    Route::get('getconfig', 'API\ApplicationconfigController@getAllConfiguration');


    Route::post('product', 'API\ProductController@storeProductName');
    Route::get('product1', 'API\ProductController@index');
    Route::get('product2', 'API\ProductController@create');
    Route::post('product3', 'API\ProductController@product');
    Route::post('productvar', 'API\ProductVariationController@store');
    Route::get('productvar', 'API\ProductVariationController@getAllVariationName');
    
    Route::get('wishlist', 'API\WishlistController@getAllWishlistName');

    //chat

    Route::post('createChatRoom', 'API\ChatController@createChatRoom');
    Route::post('addNewMessage', 'API\ChatController@addNewMessage');
    Route::post('markRead', 'API\ChatController@markRead');
    Route::post('getInboxlist', 'API\ChatController@getInboxlist');
    Route::post('noOfUnread', 'API\ChatController@noOfUnread');
   
   
    Route::group(['middleware' => 'auth:api'], function(){
    Route::post('details', 'API\UserController@details');
   

   
    });