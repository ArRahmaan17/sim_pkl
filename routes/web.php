<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Database\DatabaseController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Master\ClusterController;
use App\Http\Controllers\Master\MenuController;
use App\Http\Controllers\Mentor\TaskController;
use App\Http\Controllers\User\TaskController as userTask;
use App\Http\Controllers\User\AttendanceController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\StudentClusterController;
use App\Http\Middleware\Authenticated;
use App\Http\Middleware\CompletedProfile;
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
    Route::get('/', HomeController::class)->name('home.index')->middleware([CompletedProfile::class]);
    Route::get('/logout', [LoginController::class, 'logout'])->name('authentication.logout');
    Route::name('database.')->group(function () {
        Route::get('/database/task/all', [DatabaseController::class, 'tasks_all'])->name('task.all');
        Route::get('/database/task/user/{id?}', [DatabaseController::class, 'all_student_task'])->name('task.user');
    });
    Route::name('user.')->group(function () {
        Route::get('/user/attendance', [AttendanceController::class, 'index'])->name('attendance.index')->middleware([CompletedProfile::class]);
        Route::post('/user/attendance', [AttendanceController::class, 'store'])->name('attendance.process');
        Route::get('/user/calendar', [AttendanceController::class, 'all'])->name('attendance.calendar');
        Route::get('/user/profile', [ProfileController::class, 'index'])->name('profile.index')->middleware([CompletedProfile::class]);
        Route::put('/user/profile/update', [ProfileController::class, 'update'])->name('profile.update');
        Route::get('/user/profile/change-password', [ProfileController::class, 'change_password'])->name('profile.change-password');
        Route::post('/user/profile/{id}/last-change-password', [ProfileController::class, 'last_change_password'])->name('profile.last-change-password');
        Route::post('/user/profile/changing-password', [ProfileController::class, 'changing_password'])->name('profile.changing-password');
        Route::get('/user/profile/{id}/accept-changed-password', [ProfileController::class, 'accept_changed_password'])->name('profile.accept-changed-password');
        Route::get('/user/group/', [StudentClusterController::class, 'index'])->name('group.index')->middleware([CompletedProfile::class]);
        Route::post('/user/group/store', [StudentClusterController::class, 'store'])->name('group.store');
        Route::get('/user/todo/', [userTask::class, 'index'])->name('todo.index')->middleware([CompletedProfile::class]);
        Route::get('/user/todo/{id?}', [userTask::class, 'show'])->name('todo.show');
    });
    Route::name('mentor.')->group(function () {
        Route::get('/mentor/task', [TaskController::class, 'index'])->name('task.index')->middleware([CompletedProfile::class]);
        Route::post('/mentor/task/store', [TaskController::class, 'store'])->name('task.store');
        Route::get('/mentor/task/show/{id?}', [TaskController::class, 'show'])->name('task.show');
        Route::post('/mentor/task/update/{id?}', [TaskController::class, 'update'])->name('task.update');
        Route::delete('/mentor/task/delete/{id?}', [TaskController::class, 'delete'])->name('task.delete');
    });
    Route::name('master.')->group(function () {
        Route::get('/master/menus', [MenuController::class, 'index'])->name('menus.index')->middleware([CompletedProfile::class]);
        Route::get('/master/menus/all', [MenuController::class, 'all'])->name('menus.all');
        Route::post('/master/menus/sort', [MenuController::class, 'sort'])->name('menus.sort');
        Route::post('/master/menus/store', [MenuController::class, 'store'])->name('menus.store');
        Route::get('/master/menus/show/{id}', [MenuController::class, 'show'])->name('menus.show');
        Route::put('/master/menus/update/{id}', [MenuController::class, 'update'])->name('menus.update');
        Route::delete('/master/menus/delete/{id}', [MenuController::class, 'destroy'])->name('menus.delete');
        Route::get('/master/clusters', [ClusterController::class, 'index'])->name('cluster.index')->middleware([CompletedProfile::class]);
        Route::post('/master/clusters/store', [ClusterController::class, 'store'])->name('cluster.store');
        Route::get('/master/clusters/show/{id?}', [ClusterController::class, 'show'])->name('cluster.show');
        Route::put('/master/clusters/update/{id?}', [ClusterController::class, 'update'])->name('cluster.update');
        Route::delete('/master/clusters/delete/{id?}', [ClusterController::class, 'destroy'])->name('cluster.delete');
    });
});
Route::middleware([Authenticated::class])->group(function () {
    Route::get('/auth/login', [LoginController::class, 'index'])->name('authentication.index');
    Route::post('/auth/login', [LoginController::class, 'login'])->name('authentication.login');
    Route::get('/auth/registration', [RegisterController::class, 'index'])->name('register.index');
    Route::post('/auth/registration', [RegisterController::class, 'registration'])->name('register.registration');
});
