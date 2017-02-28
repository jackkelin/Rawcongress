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



Route::get('/bills', 'BillsController@getBills');
Route::get('/clearbills', 'BillsController@clearBillData');
Route::get('/storebills', 'BillsController@getBillsData');

Route::get('/', 'MembersController@getMembers');
Route::get('/store/{chamber}', 'MembersController@getCongressData');
Route::get('/clear', 'MembersController@clearData');
Route::get('/chamber/{chamber}', 'MembersController@getChamberType');
Route::get('/cid', 'MembersController@getCidData');
Route::get('/contributors', 'MembersController@getContributors');
Route::get('/contribution', 'MembersController@fillContribution');



//Route::get('/', function () {
//    $members = DB::table('members')->get();
//    return $members;
////    return view('welcome', compact('tasks'));
//});
