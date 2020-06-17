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
//@@

Route::get('/', 'WebSaleController@index')->name('sale-page');

Auth::routes();

//user
Route::get('/login', 'MyLoginController@getLogin')->name('login.getLogin');
Route::post('/user-login', 'MyLoginController@postLogin')->name('login.postLogin');
Route::get('/myRegister', 'MyLoginController@getRegister')->name('myRegister.getRegister');
Route::get('/registerStall', 'MyLoginController@getRegisterStall')->name('registerStall.registerStall');
Route::post('/myRegister', 'MyLoginController@postRegister')->name('myRegister.postRegister');

Route::get('/cart-page', 'WebSaleController@cartPage');
Route::post('/bill', 'WebSaleController@bill');
Route::delete('/delete-all-cart', 'WebSaleController@deleteAll');
Route::get('/get-cart', 'WebSaleController@getCart');
Route::get('/get-manufacturer_products/{id}/{product_id}', 'WebSaleController@getManufacturerProduct')->name('product.getManufacturerProduct');
Route::post('/post-comment', 'WebSaleController@postComment')->name('product.postComment');
Route::post('/love-product/{id}', 'ProductDetailController@Love');
Route::get('/get-detail-product/{slug}', 'WebSaleController@detail');
Route::post('/add-cart/{id}', 'WebSaleController@addToCart');
Route::delete('/delete-one/{id}', 'WebSaleController@deleteOneProduct');
Route::post('/update-cart/{id}', 'WebSaleController@updateCart');
Route::get('/get-info/{id}', 'WebSaleController@getInfo');

// Message

Route::post('/sendMess', "SendMessageController@sendMessage");
Route::get('/getMess/{id}', "SendMessageController@getMessage");
Route::get('/getChatPartner/{id}', "SendMessageController@getChatPartner")->name('chatPartner');

// admin

// Route::get('/logout', function(){
// 	Auth::logout();
// 	return redirect('/login');
// });

Route::middleware('admin')->group(function() {
	Route::get('/profile', 'AdminController@getProFile')->name('admin.info');
	Route::get('/admin-logout', 'AdminController@getLogout')->name('admin.logout');
	Route::get('/admin-edit/{id}', 'AdminController@edit')->name('admin.edit');
	Route::post('/admin-update/{id}', 'AdminController@update')->name('admin.update');

	//product
	Route::get('/admin-products','ProductController@index')->name('admin-products.index');
	Route::post('/admin-products', 'ProductController@store')->name('admin-products.store');
	Route::get('/admin-products/create', 'ProductController@create')->name('admin-products.create');
	Route::get('/admin-getproducts','ProductController@getproducts')->name('admin-products.getproducts');
	Route::get('/admin-products/{id}/edit', 'ProductController@edit')->name('admin-products.edit');
	Route::post('/admin-products-update', 'ProductController@update')->name('admin-products.update');
	Route::get('/admin-products-detail/{id}', 'ProductController@show')->name('admin-products.show');
	Route::get('/admin-products/{id}', 'ProductController@destroy')->name('admin-products.destroy');

	//manufacturers
	Route::post('/admin-manufacturers', 'ManufacturerController@store')->name('admin-manufacturers.store');
	Route::get('/admin-manufacturers/create', 'ManufacturerController@create')->name('admin-manufacturers.create');
	Route::get('/getmanufacturers/{id}','ManufacturerController@getmanufacturers')->name('admin-manufacturers.getmanufacturers');
	Route::get('/admin-manufacturers/{id}/edit', 'ManufacturerController@edit')->name('admin-manufacturers.edit');
	Route::post('/admin-manufacturers/update', 'ManufacturerController@update')->name('admin-manufacturers.update');
	Route::get('/admin-manufacturers/{id}/show', 'ManufacturerController@show')->name('admin-manufacturers.show');
	Route::get('/admin-manufacturers/delete/{id}', 'ManufacturerController@destroy')->name('admin-manufacturers.destroy');

	//product detail
	Route::post('/admin-detail-products', 'ProductDetailController@store')->name('admin-detail-products.store');
	Route::get('/admin-getdetailproducts/{id}','ProductDetailController@getdetailproducts')->name('admin-getdetailproducts.getdetailproducts');
	Route::get('/admin-detail-products/{id}/edit', 'ProductDetailController@edit')->name('admin-detail-products.edit');
	Route::post('/admin-detail-products/update', 'ProductDetailController@update')->name('admin-detail-products.update');
	Route::get('/admin-detail-products/{id}/show', 'ProductDetailController@show')->name('admin-detail-products.show');
	Route::get('/admin-detail-products/{id}', 'ProductDetailController@destroy')->name('admin-detail-products.destroy');
	Route::get('/admin-upload-img/{id}', 'ProductDetailController@getImages')->name('product-up-multi-img');
	Route::post('admin-upload-img/store', 'ProductDetailController@postImages');
	Route::delete('admin-img/{id}', 'ProductDetailController@deleteImage');

	//order
	Route::get('/admin-orders','OrderController@index')->name('admin-orders.index');
	Route::get('/admin-orders-paid','OrderController@paid')->name('admin-orders-paid.index');
	Route::post('/admin-orders/{id}', 'OrderController@update')->name('admin-orders.update');
	Route::post('/admin-getorders','OrderController@getorders')->name('admin-getorders.getorders');
	Route::get('/admin-getorders-paid','OrderController@getorderspaid')->name('admin-getorders-paid.getorderspaid');
	Route::get('/admin-orders/{id}', 'OrderController@show')->name('admin-orders.show');
	Route::delete('/admin-orders/{id}', 'OrderController@destroy')->name('admin-orders.destroy');

	//order_details
	Route::get('/admin-getdetailorders/{id}','OrderDetailController@getdetailorders')->name('admin-getdetailorders.getdetailorders');
	Route::get('/admin-detail-orders/{id}', 'OrderDetailController@show')->name('admin-detail-orders.show');

	//statistical
	Route::get('/admin-statistical','ProductDetailController@statistical')->name('admin-statistical.index');
	Route::get('/admin-chart','ProductDetailController@chart');
});

Route::middleware('customer')->group(function() {
	Route::get('/customer-profile', 'CustomerController@getProFile')->name('customer.info');
	Route::get('/customer-logout', 'CustomerController@getLogout')->name('customer.logout');
	Route::get('/customer-edit/{id}/edit', 'CustomerController@edit')->name('customer.edit');
	Route::post('/customer-update/{id}', 'CustomerController@update')->name('customer.update');

	//product
	Route::get('/customer-products','ProductController@index')->name('customer-products.index');
	Route::get('/customer-getproducts','ProductController@getproducts')->name('customer-products.getproducts');
	Route::get('/customer-products/{id}', 'ProductController@show')->name('customer-products.show');

	//manufacturers
	Route::get('/customer-getmanufacturers/{id}','ManufacturerController@getmanufacturers')->name('customer-getmanufacturers.getmanufacturers');
	Route::get('/customer-manufacturers/{id}', 'ManufacturerController@show')->name('customer-manufacturers.show');

	//product detail
	Route::get('/customer-getdetailproducts/{id}','ProductDetailController@getdetailproducts');
	Route::get('/customer-detail-products/{id}', 'ProductDetailController@show')->name('customer-detail-products.show');

	//order
	Route::get('/customer-orders','OrderController@index')->name('customer-orders.index');
	Route::get('/customer-orders-paid','OrderController@paid')->name('customer-orders-paid.index');
	Route::get('/customer-orders/{id}/edit', 'OrderController@edit')->name('customer-orders.edit');
	Route::post('/customer-orders/{id}', 'OrderController@update')->name('customer-orders.update');
	Route::get('/customer-getorders','OrderController@getorders')->name('customer-getorders.getorders');
	Route::get('/customer-getorders-paid','OrderController@getorderspaid')->name('customer-getorders-paid.getorderspaid');
	Route::get('/customer-orders/{id}', 'OrderController@show')->name('customer-orders.show');

	Route::get('/customer-orders','OrderController@index')->name('customer-orders.index');
	Route::post('/customer-orders/{id}', 'OrderController@update')->name('customer-orders.update');
	Route::get('/customer-getorders','OrderController@getorders')->name('customer-getorders.getorders');
	Route::get('/customer-orders/{id}', 'OrderController@show')->name('customer-orders.show');
	Route::delete('/customer-orders/{id}', 'OrderController@destroy')->name('customer-orders.destroy');

	//order_details
	Route::get('/customer-getdetailorders/{id}','OrderDetailController@getdetailorders')->name('customer-getdetailorders.getdetailorders');
	Route::get('/customer-detail-orders/{id}', 'OrderDetailController@show')->name('customer-detail-orders.show');

});
