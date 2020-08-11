<?php

//平台用户管理
Route::post('userdel','admin/user/delete')->name('user.del');
Route::post('useradd','admin/user/save')->name('user.add');
Route::get('usersearch','admin/user/search')->name('user.search');
Route::post('userresetpass','admin/user/resetpass')->name('user.resetpass');
Route::get('userreset','admin/user/reset')->name('user.reset');
Route::get('usercreate','admin/user/create')->name('user.create');
Route::get('userlist','admin/user/index')->name('user.list');

//角色管理
Route::post('authgroupdel','admin/auth_group/delete')->name('authgroup.del');
Route::post('authgroupadd','admin/auth_group/save')->name('authgroup.save');
Route::get('authgroupsearch','admin/auth_group/search')->name('authgroup.search');
Route::get('authgrouplist','admin/auth_group/index')->name('authgroup.list');

//实名认证
Route::post('authenticationmanage','admin/authentication/manage')->name('authentication.manage');
Route::get('authenticationsearch','admin/authentication/search')->name('authentication.search');
Route::get('authenticationlist','admin/authentication/index')->name('authentication.list');



//订单管理
Route::get('orderlist','admin/order/index')->name('order.list');
Route::get('ordersearch','admin/order/search')->name('order.search');

//提现管理
Route::get('withdrawalsearch','admin/withdrawal/search')->name('withdrawal.search');
Route::get('withdrawallist','admin/withdrawal/index')->name('withdrawal.list');

//经纪人管理
Route::get('agentsearch','admin/agent/search')->name('agent.search');
Route::get('agentlist','admin/agent/index')->name('agent.list');


//客户管理路由
Route::post('customersave','admin/customer/save')->name('customer.save');
Route::get('customersearch','admin/customer/search')->name('customer.search');
Route::get('customerlist','admin/customer/index')->name('customer.list');
Route::get('customercreate','admin/customer/create')->name('customer.create');

//课程管理
Route::post('coursedel','admin/course/delete')->name('course.del');
Route::post('courseaddvideo','admin/course/addvideo')->name('course.addvideo');
Route::post('courseadd','admin/course/add')->name('course.add');
Route::post('courseupdate','admin/course/update')->name('course.update');
Route::get('courseedit','admin/course/edit')->name('course.edit');
Route::post('courseoffsale','admin/course/offsale')->name('course.offsale');
Route::get('coursecreate','admin/course/create')->name('course.create');
Route::get('coursesearch','admin/course/search')->name('course.search');
Route::get('courselist','admin/course/index')->name('course.list');

//合同管理
Route::get('contractsearch','admin/contract/search')->name('contract.search');
Route::post('contractdel','admin/contract/delete')->name('contract.del');
Route::post('contractadd','admin/contract/add')->name('contract.add');
Route::get('contractcreate','admin/contract/create')->name('contract.create');
Route::post('contractupdate','admin/contract/update')->name('contract.update');
Route::get('contractedit','admin/contract/edit')->name('contract.edit');
Route::get('contractlist','admin/contract/index')->name('contract.list');

//权限管理
Route::post('authdel','admin/auth/delete')->name('auth.del');
Route::post('authupdate','admin/auth/update')->name('auth.update');
Route::get('authedit','admin/auth/edit')->name('auth.edit');
Route::post('authadd','admin/auth/save')->name('auth.add');
Route::get('authcreate','admin/auth/create')->name('auth.create');
Route::get('authlist','admin/auth/index')->name('auth.list');
Route::get('notfound','admin/auth/notfound')->name('auth.lost');


//banner管理路由
Route::post('bannerdel','admin/banner/delete')->name('banner.del');
Route::get('bannercreate','admin/banner/create')->name('banner.create');   //新增页面
Route::post('bannerisindex','admin/banner/update')->name('banner.is_index');
ROute::post('banneradd','admin/banner/add')->name('banner.add');        //新增操作
Route::get('bannerlist','admin/banner/index')->name('banner.list');

//登录路由
Route::get('login','admin/user/login')->name('user.login');
Route::post('signin','admin/user/signin')->name('user.signin');
Route::get('logout','admin/user/logout')->name('user.logout');


//后台首页
Route::get('backstage','admin/index/index')->name('admin.index');
