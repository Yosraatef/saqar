<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

 
Route::get('/', function () {
    return view('welcome');
})->name('welcomeView');
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
     return "true";
});
Route::post('messages','dash\MessageController@store')->name('messages.store');

Route::group(['prefix' => 'dashboard' , 'namespace'=>'dash'],function (){
    
     Route::middleware('auth:admin')->group(function(){

    Route::get('dashboard','DashboardController@index')->name('adminPanal');   
  	Route::post('dynamic_dependent/fetch', 'DashboardController@fetch')->name('dynamicdependent.fetch');

  	   //users
       Route::resource('users','UserController');

       //categories
       Route::resource('categories','CategoryController');

       //subCategories
       Route::resource('subCategories','SubCategoryController');
        //orders
       Route::resource('order','OrderController');

       //products
       Route::resource('products','ProductController');

        //services
       Route::resource('services','ServiceController');
       Route::get('getSubcategories/{id}','ServiceController@getSubCategories')->name('getSubCat');
        Route::put('available/update/{id}','ServiceController@available')->name('available.update');
       //shredder
       Route::resource('shredders','ShredderController');

       //weight
       Route::resource('weights','WeightController');  
        //Subscriptions
        Route::resource('subscriptions','SubscriptionController');  
         //Accounts
        Route::resource('accounts','AccountController'); 
         //Commissions
        Route::resource('commissions','CommissionController');  
        //orders
       Route::resource('orders','OrderController');
       Route::post('status/{id}','OrderController@status')->name('status');

        //contact
       Route::resource('contact','ContactController');
       //Settings
        Route::get('settings','SettingController@index')->name('settings');
        Route::get('settings/create','SettingController@create')->name('settings.create');
        Route::post('settings','SettingController@store')->name('settings.store');
});
     Route::get('login','UserController@showLogin')->name('admin.showLogin');
     Route::post('login','UserController@login')->name('login');
     Route::post('logout','UserController@logout')->name('admin.logout');
  
 });