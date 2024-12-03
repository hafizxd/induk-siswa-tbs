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


Route::middleware('guest')->group(function () {
    Route::get('login', 'AuthController@login')->name('login.index');
    Route::post('login', 'AuthController@store')->name('login.store');
});

Route::get('/', function () {
    return redirect()->route('login.index');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', 'AuthController@logout')->name('auth.logout');

    Route::get('students/datatables', 'StudentController@datatables')->name('students.datatables');
    Route::resource('students', 'StudentController');
    Route::put('students/{id}/update/score', 'StudentController@updateScore')->name('students.update.score');
    Route::post('students/{id}/delete', 'StudentController@destroy')->name('students.delete');

    Route::post('grades/datatables', 'GradeController@datatables')->name('grades.datatables');
    Route::resource('grades', 'GradeController');

    Route::group(['prefix' => 'import', 'as' => 'import.'], function () {
        Route::get('/', 'ImportController@index')->name('index');
        Route::post('upload', 'ImportController@upload')->name('upload');
        Route::post('upload-replace', 'ImportController@uploadReplace')->name('upload-replace');
    });

    Route::get('/export', 'ExportController@index')->name('export.index');
});

Route::get('/home', 'HomeController@index')->name('home');
