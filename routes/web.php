<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes([
    'register' => false,
    'reset'    => false,
]);
Route::get('/', function () {return view('auth.login');});


Route::group(['middleware' => 'admin'], function() {
    Route::get('/admin', 'AdminController@index')->name('admin.index');
    Route::get('/admin/warranty', 'Admin\Warranty\HomeController@index')->name('admin.warranty.index');
    Route::post('/admin/warranty', 'Admin\Warranty\HomeController@index')->name('admin.warranty.index');
    Route::get('/admin/warranty/detail', 'Admin\Warranty\DetailController@index')->name('admin.detail.index');
    Route::get('/admin/document/pdf', 'Admin\Warranty\DocumentController@pdf')->name('admin.document.pdf');
    Route::get('/admin/customer/create', 'Admin\Customer\CreateController@index')->name('admin.customer.create.index');
    Route::post('/admin/customer/create/confirm', 'Admin\Customer\CreateController@confirm')->name('admin.customer.create.confirm');
    Route::post('/admin/customer/create/send', 'Admin\Customer\CreateController@send')->name('admin.customer.create.send');
    Route::get('/admin/customer/detail', 'Admin\Customer\DetailController@index')->name('admin.customer.detail.index');
    Route::get('/admin/customer/edit', 'Admin\Customer\EditController@index')->name('admin.customer.edit.index');
    Route::post('/admin/customer/edit/send', 'Admin\Customer\EditController@send')->name('admin.customer.edit.send');
    Route::get('/admin/customer/delete', 'Admin\Customer\DeleteController@index')->name('admin.customer.delete.index');
    Route::post('/admin/customer/delete/confirm', 'Admin\Customer\DeleteController@confirm')->name('admin.customer.delete.confirm');
    Route::post('/admin/customer/delete/send', 'Admin\Customer\DeleteController@send')->name('admin.customer.delete.send');

});
Route::group(['middleware' => 'login'], function() {
    Route::get('/{login_id}', 'HomeController@index')->name('index');
    Route::post('/{login_id}', 'HomeController@index')->name('index');
    Route::get('/{login_id}/create', 'CreateController@index')->name('create.index');
    Route::post('/{login_id}/create/confirm', 'CreateController@confirm')->name('create.confirm');
    Route::post('/{login_id}/create/send', 'CreateController@send')->name('create.send');
    Route::get('/{login_id}/copy', 'CopyController@index')->name('copy.index');
    Route::post('/{login_id}/copy/confirm', 'CopyController@confirm')->name('copy.confirm');
    Route::post('/{login_id}/copy/send', 'CopyController@send')->name('copy.send');
    Route::get('/{login_id}/detail', 'DetailController@index')->name('detail.index');
    Route::get('/{login_id}/document', 'DocumentController@index')->name('document.index');
    Route::get('/{login_id}/document/pdf', 'DocumentController@pdf')->name('document.pdf');
    Route::get('/{login_id}/document/print', 'DocumentController@print')->name('document.print');
    Route::get('/{login_id}/edit', 'EditController@index')->name('edit.index');
    Route::post('/{login_id}/edit/send', 'EditController@send')->name('edit.send');
    Route::get('/{login_id}/delete', 'DeleteController@index')->name('delete.index');
    Route::post('/{login_id}/edit/delete', 'DeleteController@send')->name('delete.send');
    Route::get('/{login_id}/invoice', 'Invoice\HomeController@index')->name('invoice.index');
    Route::post('/{login_id}/invoice', 'Invoice\HomeController@index')->name('invoice.index');
    Route::get('/{login_id}/invoice/edit', 'Invoice\EditController@index')->name('invoice.edit.index');
    Route::post('/{login_id}/invoice/edit/send', 'Invoice\EditController@send')->name('invoice.edit.send');
    Route::get('/{login_id}/import', 'ImportController@index')->name('import.index');
    Route::post('/{login_id}/import/send', 'ImportController@send')->name('import.send');
});