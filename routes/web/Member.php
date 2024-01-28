<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Member\CartController;
use App\Http\Controllers\Member\CourseController;
use App\Http\Controllers\Member\QrScanController;
use App\Http\Controllers\Member\ProfileController;
use App\Http\Controllers\Member\FavoriteController;
use App\Http\Controllers\Member\DashboardController;
use App\Http\Controllers\Member\ECommerceController;
use App\Http\Controllers\Member\DiscussionController;
use App\Http\Controllers\Member\TransactionController;
use App\Http\Controllers\Member\CourseMemberController;
use App\Http\Controllers\Member\OfflineCourseController;

Route::group(["controller" => CourseController::class, "prefix" => "course", "as" => "course."], function () {
    Route::get('/', 'index')->name('index');
    Route::get('/show/{id}', 'show')->name('show');
    Route::get('/preview_lesson/{id}', 'preview_lesson')->name('preview_lesson');
    Route::post("/show_trailer", "show_trailer")->name('show_trailer');
    Route::get('/search', 'search')->name('search');
});

Route::group(["controller" => OfflineCourseController::class, "prefix" => "offline_course", "as" => "offline_course."], function () {
    Route::get('/', 'index')->name('index');
    Route::get('/show/{id}', 'show')->name('show');
    Route::get('/preview_lesson/{id}', 'preview_lesson')->name('preview_lesson');

    Route::post("/show_trailer", "show_trailer")->name('show_trailer');

    Route::get('/search', 'search')->name('search');
});

Route::middleware('role:member')->group(function () {
    Route::group(["controller" => CourseController::class, "prefix" => "course", "as" => "course."], function () {
        Route::post("/store_favorite", "store_favorite")->name('store_favorite');
        Route::post('/store_product_to_cart', [CartController::class, 'store_product_to_cart'])->name('store_product_to_cart');
    });

    Route::group(["controller" => ProfileController::class, "prefix" => "profile", "as" => "profile."], function () {
        Route::get('/edit', 'edit')->name('edit');
        Route::post("/update", "update")->name('update');
    });

    Route::group(["prefix" => "member", "as" => "member."], function () {
        Route::get("/", [DashboardController::class, "index"])->name('dashboard.index');

        Route::group(["controller" => CartController::class, "prefix" => "cart", "as" => "cart."], function () {
            Route::get('/', 'index')->name('index');
            Route::post("/store_product_to_cart", "store_product_to_cart")->name('store_product_to_cart');
        });
        Route::group(["controller" => ECommerceController::class, "prefix" => "e_commerce", "as" => "e_commerce."], function () {
            Route::get('/', 'index')->name('index');
            Route::post("/store_product_to_cart", "store_product_to_cart")->name('store_product_to_cart');
        });
        Route::group(["controller" => TransactionController::class, "prefix" => "transaction", "as" => "transaction."], function () {
            Route::get('/', 'index')->name('index');
            Route::get('/detail/{id}', 'detail')->name('detail');
        });

        Route::group(["controller" => CourseMemberController::class, "prefix" => "course_member", "as" => "course_member."], function () {
            Route::get('/', 'index')->name('index');
            Route::get('/show/{id}', 'show')->name('show');
            Route::post('/finish_lesson/{id}', 'finish_lesson')->name('finish_lesson');
            Route::post('/store_review/{id}', 'store_review')->name('store_review');

            Route::get('/show_lesson/{id}', 'show_lesson')->name('show_lesson');
            Route::get('/show_score/{id}', 'lesson_score')->name('lesson_score');
            Route::post('/end_lesson/{id}', 'end_lesson')->name('end_lesson');
        });

        Route::group(["controller" => FavoriteController::class, "prefix" => "favorite", "as" => "favorite."], function () {
            Route::get('/', 'index')->name('index');
        });

        Route::group(["controller" => DiscussionController::class, "prefix" => "discussion", "as" => "discussion."], function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create/{id}', 'create')->name('create');
            Route::post('/store/{id}', 'store')->name('store');
            Route::get("/show/{id}", "show")->name('show');
            Route::get("/edit/{id}", "edit")->name('edit');
            Route::post("/update/{id}", "update")->name('update');
            Route::post("/delete/{id}", "destroy")->name('delete');

            Route::post("/store_answer/{id}", "store_answer")->name('store_answer');

            Route::get("/search_lesson/{id}", "search_lesson")->name('search_lesson');
        });

        Route::group(["controller" => QrScanController::class, "prefix" => "qr_scan", "as" => "qr_scan."], function () {
            Route::get('/', 'index')->name('index');
            Route::get('/show/{id}', 'show')->name('show');
        });
    });
});
