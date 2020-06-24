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
    return view('welcome');
});

Auth::routes();

Route::get('/cursos', function () {
    return view('courses.index');
});

Route::get('/cursos/{id}', function () {
    return view('courses.show');
});

Route::get('/estudiantes', function () {
    return view('students.index');
});

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('/students', 'StudentController')->middleware('auth');

Route::post('/courses/suscribe/{id}', 'CourseController@suscribe')
    ->name('courses.suscribe')
    ->middleware('auth');
Route::post('/courses/unsuscribe/{id}', 'CourseController@unsuscribe')
    ->name('courses.unsuscribe')
    ->middleware('auth');
Route::get('/courses/stats', 'CourseController@stats')->middleware('auth');
Route::resource('/courses', 'CourseController')->middleware('auth');
