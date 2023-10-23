<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Master\MenuController;
use App\Http\Controllers\User\AttendanceController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Middleware\Authenticated;
use App\Http\Middleware\Unauthenticated;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware([Unauthenticated::class])->group(function () {
    Route::get('/', HomeController::class)->name('home');
    Route::name('user.')->group(function () {
        Route::get('/user/attendance', [AttendanceController::class, 'index'])->name('attendance');
        Route::post('/user/attendance', [AttendanceController::class, 'store'])->name('attendance.process');
        Route::get('/user/calendar', [AttendanceController::class, 'all'])->name('attendance.calendar');
        Route::get('/user/profile', [ProfileController::class, 'index'])->name('profile');
        Route::put('/user/profile/update', [ProfileController::class, 'update'])->name('profile.update');
        Route::get('/user/profile/change-password', [ProfileController::class, 'change_password'])->name('profile.change-password');
        Route::post('/user/profile/{id}/last-change-password', [ProfileController::class, 'last_change_password'])->name('profile.last-change-password');
        Route::post('/user/profile/changing-password', [ProfileController::class, 'changing_password'])->name('profile.changing-password');
        Route::get('/user/profile/{id}/accept-changed-password', [ProfileController::class, 'accept_changed_password'])->name('profile.accept-changed-password');
    });
    Route::name('master.')->group(function () {
        Route::get('/master/menus', [MenuController::class, 'index'])->name('menus');
        Route::get('/master/menus/all', [MenuController::class, 'all'])->name('menus.all');
        Route::post('/master/menus/sort', [MenuController::class, 'sort'])->name('menus.sort');
        Route::post('/master/menus/store', [MenuController::class, 'store'])->name('menus.store');
        Route::get('/master/menus/show/{id}', [MenuController::class, 'show'])->name('menus.show');
        Route::put('/master/menus/update/{id}', [MenuController::class, 'update'])->name('menus.update');
        Route::delete('/master/menus/delete/{id}', [MenuController::class, 'destroy'])->name('menus.delete');
    });
});
Route::middleware([Authenticated::class])->group(function () {
    Route::get('/auth/login', [LoginController::class, 'index'])->name('authentication.index');
    Route::post('/auth/login', [LoginController::class, 'login'])->name('authentication.login');
    Route::get('/auth/registration', [RegisterController::class, 'index'])->name('register.index');
    Route::post('/auth/registration', [RegisterController::class, 'registration'])->name('register.registration');
});
