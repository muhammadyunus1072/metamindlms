<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Member\CourseController as M_CourseController;
use App\Http\Controllers\Member\DashboardController as M_DashboardController;

use App\Http\Controllers\Admin\DashboardController as A_DashboardController;
use App\Http\Controllers\Admin\CategoryCourseController as A_CategoryCourseController;
use App\Http\Controllers\Admin\GroupCategoryCourseController as A_GroupCategoryCourseController;
use App\Http\Controllers\Admin\LevelController as A_LevelController;
use App\Http\Controllers\Admin\CourseController as A_CourseController;

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
Route::get('/', [AuthController::class, 'login']);
Route::post("/auth/login", [AuthController::class, "do_login"])->name('login.do_login');
Route::get("/logout", [AuthController::class, "logout"])->name('logout');

Route::middleware('role:admin')->group(function(){

    Route::group(["prefix" => "admin", "as" => "admin."], function () {

        Route::get("/", [A_DashboardController::class, "index"])->name('dashboard.index');

        // Master Data Kategori Kursus
        Route::group(["controller" => A_GroupCategoryCourseController::class, "prefix" => "group_category_course", "as" => "group_category_course."], function () {
            Route::get("/", "index")->name('index');
            Route::get("/json", "json")->name('json');
            Route::get("/create", "create")->name('create');
            Route::post("/store", "store")->name('store');
            Route::get("/edit/{id}", "edit")->name('edit');
            Route::post("/update/{id}", "update")->name('update');
            Route::post("/delete/{id}", "destroy")->name('destroy');
            Route::post("/active/{id}", "active")->name('active');
        });
        
        // Master Data Kategori Kursus
        Route::group(["controller" => A_CategoryCourseController::class, "prefix" => "category_course", "as" => "category_course."], function () {
            Route::get("/", "index")->name('index');
            Route::get("/json", "json")->name('json');
            Route::get("/create", "create")->name('create');
            Route::post("/store", "store")->name('store');
            Route::get("/edit/{id}", "edit")->name('edit');
            Route::post("/update/{id}", "update")->name('update');
            Route::post("/delete/{id}", "destroy")->name('destroy');
            Route::post("/active/{id}", "active")->name('active');

            Route::get("/search_group_category", "search_group_category")->name('search_group_category');
        });
        
        // Master Data Level Kursus
        Route::group(["controller" => A_LevelController::class, "prefix" => "level", "as" => "level."], function () {
            Route::get("/", "index")->name('index');
            Route::get("/json", "json")->name('json');
            Route::get("/create", "create")->name('create');
            Route::post("/store", "store")->name('store');
            Route::get("/edit/{id}", "edit")->name('edit');
            Route::post("/update/{id}", "update")->name('update');
            Route::post("/delete/{id}", "destroy")->name('destroy');
            Route::post("/active/{id}", "active")->name('active');
        });

        // Master Data Kursus
        Route::group(["controller" => A_CourseController::class, "prefix" => "course", "as" => "course."], function () {
            Route::get("/", "index")->name('index');
            Route::get("/json", "json")->name('json');
            Route::get("/create", "create")->name('create');
            Route::post("/store", "store")->name('store');
            Route::get("/edit/{id}", "edit")->name('edit');
            Route::post("/update/{id}", "update")->name('update');
            Route::post("/delete/{id}", "destroy")->name('destroy');
            Route::post("/active/{id}", "active")->name('active');
            
            Route::post("/store_section/{id}", "store_section")->name('store_section');
            Route::get("/edit_section/{id}", "edit_section")->name('edit_section');
            Route::post("/update_section/{id}", "update_section")->name('update_section');
            Route::post("/destroy_section/{id}", "destroy_section")->name('destroy_section');
            
            Route::get("/json_lesson/{id}", "json_lesson")->name('json_lesson');
            
            Route::post("/store_learn_description/{id}", "store_learn_description")->name('store_learn_description');
            Route::post("/edit_learn_description/{id}", "edit_learn_description")->name('edit_learn_description');
            Route::post("/update_learn_description/{id}", "update_learn_description")->name('update_learn_description');
            Route::post("/destroy_learn_description/{id}", "destroy_learn_description")->name('destroy_learn_description');

            Route::get("/create_lesson/{id}", "create_lesson")->name('create_lesson');
            Route::post("/store_lesson/{id}", "store_lesson")->name('store_lesson');
            Route::get("/edit_lesson/{id}", "edit_lesson")->name('edit_lesson');
            Route::post("/update_lesson/{id}", "update_lesson")->name('update_lesson');
            Route::post("/destroy_lesson/{id}", "destroy_lesson")->name('destroy_lesson');
            Route::post("/active_lesson/{id}", "active_lesson")->name('active_lesson');

            Route::get("/search_level", "search_level")->name('search_level');
            Route::get("/search_category", "search_category")->name('search_category');
        });
    });

});

Route::middleware('role:member')->group(function(){

    Route::group(["prefix" => "member", "as" => "member."], function () {

        Route::get("/", [M_DashboardController::class, "index"])->name('dashboard.index');

        Route::group(["controller" => M_CourseController::class, "prefix" => "course", "as" => "course."], function () {
            Route::get('/', 'index')->name('index');
            Route::get('/show/{id}', 'show')->name('show');
            Route::get('/pagination_course_data', 'pagination_course_data')->name('pagination_course_data');
            
            Route::get('/search', 'search')->name('search');
        });

    });

});



