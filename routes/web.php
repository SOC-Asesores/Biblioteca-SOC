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
    return view('home');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

require __DIR__.'/auth.php';

Route::get('/','App\Http\Controllers\FoldersController@index')->middleware(['auth']);
Route::get('/administrador/main','App\Http\Controllers\FoldersController@allFiles')->middleware(['auth']);
Route::get('/administrador/main/{folder_url}','App\Http\Controllers\FoldersController@allFilesFolder')->middleware(['auth']);
Route::get('/{folder_main}','App\Http\Controllers\FoldersController@main_folder')->middleware(['auth']);
Route::get('/folder/{folder_main}','App\Http\Controllers\FoldersController@sub_folder')->middleware(['auth']);
Route::post('/folder/form_folder','App\Http\Controllers\FoldersController@form_folder')->name("form_folder")->middleware(['auth']);
Route::post('/folder/delete_file','App\Http\Controllers\FoldersController@delete_file')->name("delete_file")->middleware(['auth']);
Route::post('/folder/delete_folder','App\Http\Controllers\FoldersController@delete_folder')->name("delete_folder")->middleware(['auth']);
Route::post('/folder/insert','App\Http\Controllers\FoldersController@folder_insert')->name("folder_insert")->middleware(['auth']);
Route::post('/folder/contador','App\Http\Controllers\FoldersController@contador')->name("contador")->middleware(['auth']);
Route::post('/folder/file_insert','App\Http\Controllers\FoldersController@file_insert')->name("file_insert")->middleware(['auth']);
Route::get('/appredirect/{key}','App\Http\Controllers\FoldersController@autologin');
Route::post('/search','App\Http\Controllers\FoldersController@search')->middleware(['auth']);
Route::post('/folder/delete_file_multiple','App\Http\Controllers\FoldersController@delete_multiple')->name('delete_file_multiple')->middleware(['auth']);
Route::post('/folder/delete_folder_multiple','App\Http\Controllers\FoldersController@delete_multiple_folder')->name('delete_folder_multiple')->middleware(['auth']);
Route::post('/folder/update-file','App\Http\Controllers\FoldersController@update_file')->name('update-file')->middleware(['auth']);

Route::get('/home','App\Http\Controllers\FoldersController@index')->middleware(['auth']);


Route::post('clone_file_multiple','App\Http\Controllers\FoldersController@duplicateFile')->middleware(['auth']);
Route::post('clone_folder_multiple','App\Http\Controllers\FoldersController@duplicateFolder')->middleware(['auth']);
Route::post('move_file_multiple','App\Http\Controllers\FoldersController@moveFile')->middleware(['auth']);
Route::post('move_folder_multiple','App\Http\Controllers\FoldersController@moveFolder')->middleware(['auth']);