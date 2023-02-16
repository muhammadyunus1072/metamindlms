<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
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

Route::get("/login", [AuthController::class, "login"])->name("login.index");
Route::post("/auth/login", [AuthController::class, "do_login"])->name('login.do_login');
Route::get("/logout", [AuthController::class, "logout"])->name('logout');

// Kursus
Route::group(["controller" => CourseController::class, "prefix" => "course", "as" => "course."], function () {
    Route::get('/', 'index')->name('index');
    Route::get('/show/{id}', 'show')->name('show');
    Route::get('/pagination_course_data', 'pagination_course_data')->name('pagination_course_data');
    
    Route::get('/search', 'search')->name('search');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get("/", [DashboardController::class, "index"])->name('dashboard.index');

    
});
