<?php

use App\Http\Controllers\JWTController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'api'], function($router) {
    Route::post('/register', [JWTController::class, 'register'])->name('api.register');
    Route::post('/login', [JWTController::class, 'login'])->name('api.login');
    Route::post('/logout', [JWTController::class, 'logout'])->name('api.logout');
    Route::post('/refresh', [JWTController::class, 'refresh'])->name('api.refresh');
    Route::post('/profile', [JWTController::class, 'profile'])->name('api.profile');

    Route::post('/tasks', [TaskController::class, 'tasks'])->name('api.tasks');
    Route::post('/tasksStatus/{status?}', [TaskController::class, 'tasksStatus'])->name('api.tasks.status');
    Route::put('/taskStatus/{id}', [TaskController::class, 'updateStatus'])->name('api.task.update.status');
    Route::put('/taskDescription/{id}', [TaskController::class, 'updateDescription'])->name('api.task.update.description');
    Route::post('/task', [TaskController::class, 'create'])->name('api.task.create');
    Route::delete('/taskDelete/{id}', [TaskController::class, 'taskDelete'])->name('api.task.delete');

});
