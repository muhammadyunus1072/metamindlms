<?php

use App\Http\Controllers\AuthController;
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

Route::get('/', [AuthController::class, 'login']);
Route::get("/login", [AuthController::class, "login"])->name("login.index");
Route::post("/auth/login", [AuthController::class, "do_login"])->name('login.do_login');
Route::get("/logout", [AuthController::class, "logout"])->name('logout');
Route::get("/register", [AuthController::class, "register"])->name("register.index");
Route::post("/register", [AuthController::class, "do_register"])->name("register.do_register");

Route::group([], __DIR__ . '/web/Member.php');
Route::group([], __DIR__ . '/web/Admin.php');
