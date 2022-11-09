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

Route::get('/', function () {
    // return view('welcome');
    return view('index');
});
Route::match(['get', 'post'],'simpan-data','TaskController@simpanData');
Route::match(['get', 'post'],'task/getData','TaskController@getData');
Route::match(['get', 'post'],'task/deleteData','TaskController@hapus');
Route::match(['get', 'post'],'task/ubahData','TaskController@ubah');
Route::match(['get', 'post'],'task/aktifData','TaskController@aktifData');
Route::match(['get', 'post'],'task/completedData','TaskController@completedData');
Route::match(['get', 'post'],'task/markDataTrue','TaskController@markDataTrue');
Route::match(['get', 'post'],'task/markDataFalse','TaskController@markDataFalse');
// Route::post('simpan-data', ['as' => 'task.simpan-data', 'uses' => 'TaskController@simpanData']);
