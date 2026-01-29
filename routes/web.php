<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Database\DatabaseController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Master\GroupController;
use App\Http\Controllers\Master\MenuController;
use App\Http\Controllers\Master\UserController;
use App\Http\Controllers\Mentor\TaskController;
use App\Http\Controllers\Report\DailyReportController;
use App\Http\Controllers\User\AttendanceController;
use App\Http\Controllers\User\Materi;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\StudentGroupController;
use App\Http\Controllers\User\TaskController as userTask;
use App\Http\Middleware\Authenticated;
use App\Http\Middleware\CompletedProfile;
use App\Http\Middleware\isMentor;
use App\Http\Middleware\Unauthenticated;
use Illuminate\Support\Facades\Route;

// testing feature
// Route::prefix('{locale}')
//     ->where(['locale' => 'en|es|fr'])
Route::middleware([Unauthenticated::class])->group(function () {
    Route::get('/', HomeController::class)->name('home.index')->middleware([CompletedProfile::class]);
    Route::get('/logout', [AuthController::class, 'logout'])->name('authentication.logout');
    Route::name('data.')->prefix('data')->group(function () {
        Route::name('tasks.')->prefix('tasks')->group(function () {
            Route::get('/all', [DatabaseController::class, 'tasks_all'])->name('all');
            Route::get('/role/{role?}/cluster/{id?}', [DatabaseController::class, 'all_student_task'])->name('user');
            Route::get('/{id?}/progress', [DatabaseController::class, 'show_task_progress'])->name('progress');
        });
        Route::name('users.')->prefix('users')->group(function () {
            Route::get('/all', [DatabaseController::class, 'users_all'])->name('all');
            Route::get('/{id?}', [DatabaseController::class, 'detail_user'])->name('detail');
        });
    });
    Route::name('users.')->prefix('users')->group(function () {
        Route::name('learning-materials.')->prefix('learning-materials')->group(function () {
            Route::get('/learning-materials', [Materi::class, 'index'])->name('index')->middleware([CompletedProfile::class]);
            Route::get('/learning-materials/{id}', [Materi::class, 'download'])->name('download')->middleware([CompletedProfile::class]);
        });
        Route::name('attendance.')->prefix('attendance')->group(function () {
            Route::get('/', [AttendanceController::class, 'index'])->name('index')->middleware([CompletedProfile::class]);
            Route::post('/', [AttendanceController::class, 'store'])->name('process');
            Route::get('/calendar', [AttendanceController::class, 'all'])->name('calendar');
            Route::get('/map', [AttendanceController::class, 'map'])->name('map');
        });
        Route::name('profile.')->prefix('profile')->group(function () {
            Route::get('/', [ProfileController::class, 'index'])->name('index')->middleware([CompletedProfile::class]);
            Route::put('/update', [ProfileController::class, 'update'])->name('update');
            Route::post('/update-profile-picture', [ProfileController::class, 'update_profile_picture'])->name('update-profile-picture');
            Route::get('/change-password', [ProfileController::class, 'change_password'])->name('change-password');
            Route::post('/online/{id}', [ProfileController::class, 'online'])->name('status.online');
            Route::post('/{id}/last-change-password', [ProfileController::class, 'last_change_password'])->name('last-change-password');
            Route::post('/changing-password', [ProfileController::class, 'changing_password'])->name('changing-password');
            Route::get('/{id}/accept-changed-password', [ProfileController::class, 'accept_changed_password'])->name('accept-changed-password');
        });
        Route::name('group.')->prefix('group')->group(function () {
            Route::get('/', [StudentGroupController::class, 'index'])->name('index')->middleware([CompletedProfile::class]);
            Route::post('/store', [StudentGroupController::class, 'store'])->name('store');
        });
        Route::name('task.')->prefix('task')->group(function () {
            Route::get('/', [userTask::class, 'index'])->name('index')->middleware([CompletedProfile::class]);
            Route::get('/{id?}', [userTask::class, 'show'])->name('show');
            Route::post('/store', [userTask::class, 'store'])->name('store');
            Route::post('/start', [userTask::class, 'start'])->name('start');
            Route::post('/activity-update', [userTask::class, 'activity_update'])->name('activity-update');
            Route::get('/download/{id?}', [userTask::class, 'download'])->name('download');
        });
    });
    Route::name('report.')->prefix('report')->group(function () {
        Route::get('/report/daily-progress', [DailyReportController::class, 'index'])->name('daily-progress');
    });
    Route::middleware([isMentor::class])->name('mentor.')->prefix('mentor')->group(function () {
        Route::get('/task', [TaskController::class, 'index'])->name('task.index')->middleware([CompletedProfile::class]);
        Route::post('/task/store', [TaskController::class, 'store'])->name('task.store');
        Route::get('/task/show/{id?}', [TaskController::class, 'show'])->name('task.show');
        Route::post('/task/update/{id?}', [TaskController::class, 'update'])->name('task.update');
        Route::delete('/task/delete/{id?}', [TaskController::class, 'delete'])->name('task.delete');
        Route::get('/students', [UserController::class, 'index'])->name('students.index')->middleware([CompletedProfile::class]);
    });
    Route::middleware([isMentor::class])->name('master.')->prefix('master')->group(function () {
        Route::name('menus')->prefix('menus.')->group(function () {
            Route::get('/', [MenuController::class, 'index'])->name('menus.index')->middleware([CompletedProfile::class]);
            Route::get('/all', [MenuController::class, 'all'])->name('menus.all');
            Route::post('/sort', [MenuController::class, 'sort'])->name('menus.sort');
            Route::post('/store', [MenuController::class, 'store'])->name('menus.store');
            Route::get('/show/{id}', [MenuController::class, 'show'])->name('menus.show');
            Route::put('/update/{id}', [MenuController::class, 'update'])->name('menus.update');
            Route::delete('/delete/{id}', [MenuController::class, 'destroy'])->name('menus.delete');
        });
        Route::name('clusters')->prefix('clusters.')->group(function () {
            Route::get('/', [GroupController::class, 'index'])->name('cluster.index')->middleware([CompletedProfile::class]);
            Route::post('/store', [GroupController::class, 'store'])->name('cluster.store');
            Route::get('/show/{id?}', [GroupController::class, 'show'])->name('cluster.show');
            Route::put('/update/{id?}', [GroupController::class, 'update'])->name('cluster.update');
            Route::delete('/delete/{id?}', [GroupController::class, 'destroy'])->name('cluster.delete');
        });
    });
});
Route::middleware([Authenticated::class])->group(function () {
    Route::get('/auth/login', [AuthController::class, 'index'])->name('authentication.index');
    Route::post('/auth/login', [AuthController::class, 'login'])->name('authentication.login');
    Route::get('/auth/registration', [AuthController::class, 'registration'])->name('authentication.registration');
    Route::post('/auth/registration', [AuthController::class, 'registing'])->name('authentication.registing');
});
