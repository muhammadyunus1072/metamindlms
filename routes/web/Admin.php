<?php

use App\Http\Controllers\Admin\CategoryCourseController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GroupCategoryCourseController;
use App\Http\Controllers\Admin\LevelController;
use App\Http\Controllers\Admin\OfflineCourseController;
use App\Http\Controllers\Admin\OfflineCourseAttendanceController;
use App\Http\Controllers\Admin\OfflineCourseRegistrarController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ReportOfflineCourseController;
use App\Http\Controllers\Admin\AccountUserController;
use App\Http\Controllers\Admin\AccountMemberController;
use Illuminate\Support\Facades\Route;


Route::middleware('role:admin')->group(function () {
    Route::group(["prefix" => "admin", "as" => "admin."], function () {

        Route::get("/", [DashboardController::class, "index"])->name('dashboard.index');
        Route::post("/update_dashboard", [DashboardController::class, "update_dashboard"])->name('dashboard.update');

        Route::group(["prefix" => "master_data"], function () {
            // Master Data Kategori Kursus
            Route::group(["controller" => GroupCategoryCourseController::class, "prefix" => "group_category_course", "as" => "group_category_course."], function () {
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
            Route::group(["controller" => CategoryCourseController::class, "prefix" => "category_course", "as" => "category_course."], function () {
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
            Route::group(["controller" => LevelController::class, "prefix" => "level", "as" => "level."], function () {
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
            Route::group(["controller" => CourseController::class, "prefix" => "course", "as" => "course."], function () {
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

                Route::get("/member_course/{id}", "member_course")->name('member_course');
                Route::get("/json_member_course/{id}", "json_member_course")->name('json_member_course');
                Route::post("/store_member_course/{id}", "store_member_course")->name('store_member_course');
                Route::post("/delete_member_course/{id}", "delete_member_course")->name('delete_member_course');

                Route::get("/search_level", "search_level")->name('search_level');
                Route::get("/search_category", "search_category")->name('search_category');
                Route::get("/search_member", "search_member")->name('search_member');
            });

            // Master Data Kursus Offline
            Route::group(["controller" => OfflineCourseController::class, "prefix" => "offline_course", "as" => "offline_course."], function () {
                Route::get("/", "index")->name('index');
                Route::get("create", "create")->name('create');
                Route::get("edit/{id}", "edit")->name('edit');
                Route::get("show/{id}", "show")->name('show');
                Route::get("show/qr/{id}", "showQr")->name('show.qr');
                Route::delete("destroy/{id}", "edit")->name('destroy');
                Route::get("select2/category", "select2Category")->name('select2.category');
            });

            // Master Data Kursus Offline Pendaftaran
            Route::group(["controller" => OfflineCourseAttendanceController::class, "prefix" => "offline_course_attendance", "as" => "offline_course_attendance."], function () {
                Route::delete("destroy/{id}", "destroy")->name('destroy');
            });

            // Master Data Kursus Offline Kehadiran
            Route::group(["controller" => OfflineCourseRegistrarController::class, "prefix" => "offline_course_registrar", "as" => "offline_course_registrar."], function () {
                Route::delete("destroy/{id}", "destroy")->name('destroy');
                Route::get("select2", "select2")->name('select2');
            });

            // Master Data Kursus Offline Kehadiran
            Route::group(["controller" => UserController::class, "prefix" => "user", "as" => "user."], function () {
                Route::get("select2", "select2")->name('select2');
            });
        });

        // Report Data
        Route::group(["prefix" => "report", "as" => "report."], function () {

            Route::group(["controller" => ReportController::class], function () {
                Route::get("/", "index")->name('index');

                Route::group(["prefix" => "course_member", "as" => "course_member."], function () {
                    Route::get("/", "course_member")->name('index');
                    Route::get("/json", "json_course_member")->name('json');
                    Route::get("/export", "export_course_member")->name('export');
                });

                Route::group(["prefix" => "recap_course", "as" => "recap_course."], function () {
                    Route::get("/", "recap_course")->name('index');
                    Route::get("/json", "json_recap_course")->name('json');
                    Route::get("/export", "export_recap_course")->name('export');
                });


                Route::get("/search_member", "search_member")->name('search_member');
                Route::get("/search_course", "search_course")->name('search_course');
            });


            Route::group(["controller" => ReportOfflineCourseController::class], function () {
                Route::get('/offline_course', 'offline_course')->name('offline_course');
                Route::get('/registrar_offline_course', 'registrar_offline_course')->name('registrar_offline_course');
            });
            Route::get('offline_course/get', [OfflineCourseController::class, 'search'])->name('get.offline_course');
            Route::get('user/get', [UserController::class, 'search'])->name('get.user');
        });

        // Account
        Route::group(["prefix" => "account"], function () {
            // Master Data Account User
            Route::group(["controller" => GroupCategoryCourseController::class, "prefix" => "account_admin", "as" => "account_admin."], function () {
                Route::get("/", "index")->name('index');
                Route::get("/create", "index")->name('create');
                Route::get("/edit/{id}", "index")->name('edit');
            });

            // Master Data Account Member
            Route::group(["controller" => CategoryCourseController::class, "prefix" => "account_member", "as" => "account_member."], function () {
                Route::get("/", "index")->name('index');
                Route::get("/create", "index")->name('create');
                Route::get("/edit/{id}", "index")->name('edit');
            });
        });
    });
});
