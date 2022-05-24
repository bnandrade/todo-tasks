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
    Route::post('/register', [JWTController::class, 'register'])->name('register');
    Route::post('/login', [JWTController::class, 'login'])->name('login');
    Route::post('/logout', [JWTController::class, 'logout'])->name('logout');
    Route::post('/refresh', [JWTController::class, 'refresh'])->name('refresh');
    Route::post('/profile', [JWTController::class, 'profile'])->name('profile');

    Route::post('/tasks', [TaskController::class, 'tasks'])->name('tasks');
    Route::post('/tasksStatus/{status?}', [TaskController::class, 'tasksStatus'])->name('tasks.status');
    Route::put('/taskStatus/{id}', [TaskController::class, 'updateStatus'])->name('task.update.status');
    Route::put('/taskDescription/{id}', [TaskController::class, 'updateDescription'])->name('task.update.description');
    Route::post('/task', [TaskController::class, 'create'])->name('task.create');
    Route::delete('/taskDelete/{id}', [TaskController::class, 'taskDelete'])->name('task.delete');


});
