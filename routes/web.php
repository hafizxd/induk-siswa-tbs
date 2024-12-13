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

    Route::group(['prefix' => 'students', 'as' => 'students.'], function() {
        Route::resource('students', 'StudentController');
        Route::get('/', 'StudentController@index')->name('index');
        Route::get('datatables', 'StudentController@datatables')->name('datatables');
        Route::get('create', 'StudentController@create')->name('create');
        Route::post('/', 'StudentController@store')->name('store');
        Route::get('{id}/info', 'StudentController@edit')->name('edit_info');
        Route::get('{id}/grades/{type}', 'StudentController@editGrade')->name('edit_grade');
        Route::put('{id}', 'StudentController@update')->name('update');
        Route::put('{id}/update/score', 'StudentController@updateScore')->name('update.score');
        Route::post('{id}/delete', 'StudentController@destroy')->name('delete');
    });

    Route::group(['prefix' => 'grades/{type}', 'as' => 'grades.'], function() {
        Route::get('/', 'GradeController@index')->name('index');
        Route::post('datatables', 'GradeController@datatables')->name('datatables');
        Route::put('/{id}/update', 'GradeController@update')->name('update');
    });

    Route::group(['prefix' => 'subjects/{type}', 'as' => 'subjects.'], function() {
        Route::get('/', 'SubjectController@index')->name('index');
        Route::get('datatables', 'SubjectController@datatables')->name('datatables');
        Route::post('store', 'SubjectController@store')->name('store');
        Route::put('update', 'SubjectController@update')->name('update');
        Route::delete('delete', 'SubjectController@destroy')->name('delete');
    });

    Route::group(['prefix' => 'import', 'as' => 'import.'], function () {
        Route::get('/', 'ImportController@index')->name('index');
        Route::post('upload', 'ImportController@upload')->name('upload');
        // Route::post('upload-replace', 'ImportController@uploadReplace')->name('upload-replace');
    });

    Route::get('/export', 'ExportController@index')->name('export.index');

    Route::group(['prefix' => 'admins', 'as' => 'admins.'], function() {
        Route::get('/', 'AdminController@index')->name('index');
        Route::get('datatables', 'AdminController@datatables')->name('datatables');
        Route::post('store', 'AdminController@store')->name('store');
        Route::put('update', 'AdminController@update')->name('update');
        Route::put('update-me', 'AdminController@updateMe')->name('update_me');
        Route::delete('delete', 'AdminController@destroy')->name('delete');
    });
});

Route::get('/home', 'HomeController@index')->name('home');
