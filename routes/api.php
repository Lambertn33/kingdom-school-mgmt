<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ClassRoomController;
use App\Http\Controllers\Api\UsersController;

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

Route::controller(ClassRoomController::class)->group(function() {
    Route::prefix('classrooms')->group(function() {
        Route::get('/','getAllClassRooms');
        Route::prefix('/{id}')->group(function() {
            Route::get('/students','getClassRoomStudents');
            Route::post('/students/create','createNewStudent');
        });
    });
});
Route::controller(UsersController::class)->group(function() {
    Route::prefix('teachers')->group(function() {
        Route::get('/','getAllTeachers');
        Route::post('/create','createNewTeacher');
    });
});
