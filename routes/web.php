<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;



//use ;
use App\Models\Counter;
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

Auth::routes();
Route::get('/',"HomeController@index")->name('home')->middleware('auth');
Route::any('tracking',"Courier\CourierMovementController@tracking")->name('tracking');

Route::get('home',"HomeController@index" )->middleware('auth');


//change password

Route::get('change_password', 'HomeController@showChangePswd');
Route::post('change_password_store', 'HomeController@changePswd')->name('changePswdPost');




Route::get('complete_form/{ref}/index', 'Orders\OrdersController@complete_form')->name('complete.form');
Route::get('complete_form/{ref}/save', 'Orders\OrdersController@complete_form_store')->name('complete.form_store');




//Orders Routes
Route::group(['prefix' => 'orders'], function () {
Route::resource('orders','Orders\OrdersController')->middleware('auth');
Route::resource('order_payment','Orders\OrderPaymentController')->middleware('auth');
Route::get('order_payments/{id}', 'Orders\OrdersController@get_payment')->name('orders.get_payment')->middleware('auth');
Route::get('orders_pdfview',array('as'=>'orders_pdfview','uses'=>'Orders\OrdersController@invoice_pdfview'))->middleware('auth');
Route::get('payment_success', 'Orders\OrdersController@success')->name('orders.payment_success')->middleware('auth');
Route::get('payment_error', 'Orders\OrdersController@error')->name('orders.payment_error')->middleware('auth');
Route::get('order_cancelled/{id}', 'Orders\OrdersController@cancel')->name('orders.cancel')->middleware('auth');
});


Route::resource('product','ProductController')->middleware('auth');
Route::resource('product_category','ProductCategoryController')->middleware('auth');
Route::get('product_list', 'ProductController@list')->name('product.list')->middleware('auth');






  







   

    Route::group(['prefix' => 'access_control'], function () {
Route::resource('permissions', 'PermissionController')->middleware('auth');
Route::resource('departments', 'DepartmentController')->middleware('auth');
Route::resource('designations', 'DesignationController')->middleware('auth');
Route::resource('roles', 'RoleController')->middleware('auth');

Route::resource('users', 'UsersController')->middleware('auth');
Route::get('users_all', 'UsersController@users_all')->name('users_all')->middleware('auth');

Route::get('affiliate_users_all', 'UsersController@affiliate_users_all')->name('affiliate_users_all')->middleware('auth');
Route::get('affiliate_users_show/{id}/show', 'UsersController@affiliate_users_show')->name('affiliate_users_show')->middleware('auth');

Route::get('findDepartment', 'UsersController@findDepartment')->middleware('auth');  
Route::resource('users_details', 'User\UserDetailsController')->middleware('auth');

Route::resource('clients', 'ClientController')->middleware('auth');

Route::resource('system', 'SystemController')->middleware('auth');

//user Details
Route::resource('user_details', 'UserDetailsController')->middleware('auth');
    });
