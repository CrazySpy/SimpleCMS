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

Route::get('/', 'IndexController@index')->name('index');
Route::get('/index','IndexController@index');

Route::get('/login','Auth\LoginController@index')->name('login');
Route::get('/password/find','Auth\PasswordController@inputEmail')->name('password.request');
Route::get('/register','Auth\RegisterController@index')->name('register');
Route::any('/logout', 'Auth\LoginController@logout')->name('logout');
Route::any('avatar', 'AvatarController@getAvatar')->name('avatar');

Route::get('/CmsManage/node/index','CmsManage\NodeController@list')->name('node.list');
Route::get('/CmsManage/admin/index','CmsManage\AdminController@list')->name('admin.list');
Route::get('/CmsManage/role/index','CmsManage\RoleController@list')->name('role.list');

Route::get('/CmsManage/node/add','CmsManage\NodeController@addShow')->name('node.add.show');
Route::get('/CmsManage/node/edit/{node}','CmsManage\NodeController@editShow')->name('node.edit.show');
Route::post('/CmsManage/node/edit/{node}','CmsManage\NodeController@edit')->name('node.edit.edit');
Route::post('/CmsManage/node/add','CmsManage\NodeController@add')->name('node.add.add');

Route::get('/CmsManage/admin/add','CmsManage\AdminController@addShow')->name('admin.add.show');
Route::get('/CmsManage/admin/edit/{admin}','CmsManage\AdminController@editShow')->name('admin.edit.show');
Route::post('/CmsManage/admin/edit/{admin}','CmsManage\AdminController@edit')->name('admin.edit.edit');
Route::post('/CmsManage/admin/add','CmsManage\AdminController@add')->name('admin.add.add');

Route::get('/CmsManage/role/add','CmsManage\RoleController@addShow')->name('role.add.show');
Route::get('/CmsManage/role/edit/{role}','CmsManage\RoleController@editShow')->name('role.edit.show');
Route::post('/CmsManage/role/edit/{role}','CmsManage\RoleController@edit')->name('role.edit.edit');
Route::post('/CmsManage/role/add','CmsManage\RoleController@add')->name('role.add.add');
Route::get('/CmsManage/role/grant/{role}','CmsManage\RoleController@grantShow')->name('role.grant.show');
Route::post('/CmsManage/role/grant/{role}','CmsManage\RoleController@grant')->name('role.grant.grant');


Route::post('/login','Auth\LoginController@login');
Route::post('/register','Auth\RegisterController@create');
Route::post('/password/find','Auth\PasswordController@sendEmail')->name('password.email');

Route::get('/error', function() {
	return 'error';
})->name('error');


Route::post('/CmsManage/node/enable', 'CmsManage\NodeController@enable')->name('node.changeStatus.enable');
Route::post('/CmsManage/node/disable', 'CmsManage\NodeController@disable')->name('node.changeStatus.disable');
Route::post('/CmsManage/node/delete', 'CmsManage\NodeController@delete')->name('node.delete.delete');

Route::post('/CmsManage/admin/enable', 'CmsManage\AdminController@enable')->name('admin.changeStatus.enable');
Route::post('/CmsManage/admin/disable', 'CmsManage\AdminController@disable')->name('admin.changeStatus.disable');
Route::post('/CmsManage/admin/delete', 'CmsManage\AdminController@delete')->name('admin.delete.delete');
Route::get('CmsManage/admin/avatar/{admin}', 'CmsManage\AdminController@getAvatar')->name('admin.getAvatar');
Route::post('CmsManage/admin/avatar/{admin}', 'CmsManage\AdminController@setAvatar')->name('admin.setAvatar');


Route::post('/CmsManage/role/enable', 'CmsManage\RoleController@enable')->name('role.changeStatus.enable');
Route::post('/CmsManage/role/disable', 'CmsManage\RoleController@disable')->name('role.changeStatus.disable');
Route::post('/CmsManage/role/delete', 'CmsManage\RoleController@delete')->name('role.delete.delete');


Route::get('/CmsManage/node/me', 'CmsManage\NodeController@me');

