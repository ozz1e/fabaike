<?php






//客户管理路由
Route::post('savecustomer','admin/customer/save')->name('customer.save');
Route::get('getcustomerlist','admin/customer/index')->name('customer.list');
Route::get('addcustomer','admin/customer/create')->name('customer.create');


//banner管理路由
Route::post('bannerdel','admin/banner/delete')->name('banner.del');
Route::get('banneradd','admin/banner/create')->name('banner.create');   //新增页面
Route::post('bannerisindex','admin/banner/update')->name('banner.is_index');
ROute::post('banneradd','admin/banner/add')->name('banner.add');        //新增操作
Route::get('bannerlist','admin/banner/index')->name('banner.list');

//登录路由
Route::get('login','admin/user/login')->name('user.login');
Route::post('signin','admin/user/signin')->name('user.signin');
Route::get('logout','admin/user/logout')->name('user.logout');


//后台首页
Route::get('backstage','admin/index/index')->name('admin.index');
