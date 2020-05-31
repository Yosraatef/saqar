<?php

use Illuminate\Http\Request;

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
//AuthController
Route::post('register','Api\AuthController@registerPhone');
Route::post('login','Api\AuthController@login');
Route::post('activcodeuser','Api\AuthController@activcodeuser');
Route::get('setting','Api\AuthController@setting');
Route::post('contact','Api\AuthController@contact');
Route::post('reset','Api\AuthController@reset');
Route::post('resetPassword','Api\AuthController@resetPassword');
Route::post('profileUser','Api\AuthController@profileUser');
Route::post('editUser','Api\AuthController@editUser');
   Route::post('logout','Api\AuthController@logout');
//CategoryController
Route::get('getCategory','Api\CategoryController@getCategory');
//ServiceController
Route::post('getServices','Api\ServiceController@getServices');
Route::post('search','Api\ServiceController@search');
//OrderController
Route::post('getNotfy','Api\OrderController@getNotfy');
Route::group(['middleware' => 'auth:api' , 'namespace'=>'Api'],function(){
    
    //ServiceController
	Route::post('addServices','ServiceController@addServices');
	//OrderController
	Route::post('addOrder','OrderController@addOrder');
	Route::post('detailsOrder','OrderController@detailsOrder');
	Route::post('acceptanceOrder','OrderController@acceptanceOrder');
	Route::post('acceptancePrice','OrderController@acceptancePrice');
	Route::post('addPriceOrder','OrderController@addPriceOrder');
	
	//CommissionController
	Route::get('getAccounts','CommissionController@getAccounts');
	Route::post('addAmountMony','CommissionController@addAmountMony');
	Route::post('addCommission','CommissionController@addCommission');
});