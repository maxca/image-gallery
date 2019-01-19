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
});

//Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::resource('/images', 'ImageGalleriesController')->middleware('check.auth');
Route::get('usage-compositions', 'ImageGalleriesController@getUsageComposition')->middleware('check.auth');
Route::get('usage-overview', 'ImageGalleriesController@getUsageOverview')->middleware('check.auth');

# get view gallery
Route::get('gallery', 'ImageGalleriesController@renderWebGallery')->middleware('check.auth');



