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
        Route::get('{id}/info', 'StudentController@edit')->name('edit.info');
        Route::put('{id}/update', 'StudentController@update')->name('update');
        Route::post('{id}/delete', 'StudentController@destroy')->name('delete');

        Route::get('{id}/grades/periods/{class}', 'GradeController@editGrade')->name('edit.grade')->where('class', '7|8|9');
        Route::get('{id}/grades/ujian', 'GradeController@editGradeUjian')->name('edit.grade.ujian');
        Route::put('{id}/grades/update', 'GradeController@updateGrade')->name('update.grade');
        Route::put('{id}/grades/ujian/update', 'GradeController@updateGradeUjian')->name('update.grade.ujian');
        Route::post('{id}/grades/periods-assign', 'GradeController@assignPeriod')->name('period.assign');
    });

    Route::group(['prefix' => 'grades/{type}', 'as' => 'grades.'], function() {
        Route::get('/', 'GradeController@index')->name('index');
    });

    Route::group(['prefix' => 'curriculums', 'as' => 'curriculums.'], function () {
        Route::get('/', 'CurriculumController@index')->name('index');
        Route::post('/', 'CurriculumController@store')->name('store');
        Route::put('{id}', 'CurriculumController@update')->name('update');
        Route::delete('{id}', 'CurriculumController@destroy')->name('delete');

        Route::post('{curId}/cols', 'CurriculumController@storeCol')->name('cols.store');
        Route::put('{curId}/cols/{colId}', 'CurriculumController@updateCol')->name('cols.update');
        Route::delete('{curId}/cols/{colId}', 'CurriculumController@destroyCol')->name('cols.delete');
    }); 

    Route::group(['prefix' => 'periods', 'as' => 'periods.'], function () {
        Route::get('/', 'PeriodController@index')->name('index');
        Route::post('/', 'PeriodController@store')->name('store');
        Route::put('{periodId}', 'PeriodController@update')->name('update');
        Route::get('{periodId}/subjects', 'PeriodController@getSubjects')->name('detail.subject.index');
        Route::put('{periodId}/subjects/assign', 'PeriodController@assignSubjects')->name('detail.subject.assign');
        Route::put('{periodId}/subjects/copy', 'PeriodController@copySubjects')->name('detail.subject.copy');
        Route::put('year/{year}', 'PeriodController@updateInYear')->name('year.update');
        Route::delete('year/{year}', 'PeriodController@destroyInYear')->name('year.delete');
    }); 

    Route::group(['prefix' => 'subjects/{type}', 'as' => 'subjects.'], function() {
        Route::get('/', 'SubjectController@index')->name('index');
        Route::get('datatables', 'SubjectController@datatables')->name('datatables');
        Route::post('store', 'SubjectController@store')->name('store');
        Route::put('update', 'SubjectController@update')->name('update');
        Route::delete('delete', 'SubjectController@destroy')->name('delete');
    });

    Route::group(['prefix' => 'import', 'as' => 'import.'], function () {
        Route::get('students', 'ImportController@index')->name('students.index');
        Route::post('students/upload', 'ImportController@upload')->name('students.upload');
        Route::post('students/upload-update', 'ImportController@uploadUpdate')->name('students.upload.update');

        Route::get('grades', 'ImportController@gradeIndex')->name('grades.index');
        Route::post('grades/{periodId}/upload', 'ImportController@gradeUpload')->name('grades.upload');
        Route::post('grades/{periodId}/upload-update', 'ImportController@gradeUploadUpdate')->name('grades.upload.update');
    });

    Route::group(['prefix' => 'export', 'as' => 'export.'], function () {
        Route::get('/student', 'ExportController@student')->name('student');
        Route::get('/student/new', 'ExportController@studentTemplate')->name('student.template');

        Route::get('/grades/{periodId}', 'ExportController@grade')->name('grades');
        Route::get('/grades/{periodId}/new', 'ExportController@gradeTemplate')->name('grades.template');
    });

    Route::group(['prefix' => 'print', 'as' => 'print.'], function () {
        Route::get('/students/{studentId}/biodata', 'PrintController@student')->name('student');
        Route::get('/students/{studentId}/grade', 'PrintController@grade')->name('grade');
    });

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
