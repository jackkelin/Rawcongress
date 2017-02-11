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

Route::get('/store/{chamber}', 'Controller@getCongressData');
Route::get('/clear', 'Controller@clearData');
Route::get('/chamber/{chamber}', 'Controller@getMembersType');
Route::get('/', 'Controller@getHouseMembers');


Route::get('/bills', 'BillsController@getBills');
Route::get('/store/bills', 'BillsController@getBillsData');


//Route::get('/', function () {
//    $members = DB::table('members')->get();
//    return $members;
////    return view('welcome', compact('tasks'));
//});