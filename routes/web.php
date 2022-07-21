<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Administrator\UsersController;
use App\Http\Controllers\Administrator\CoursesController as AdminCoursesController;
use App\Http\Controllers\Teachers\CoursesController as TeacherCoursesController;
use App\Http\Controllers\Teachers\AttendanceController;
use App\Http\Controllers\Administrator\ClassRoomsController;
use App\Http\Controllers\Administrator\TeachersController;

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

Route::get('/', function () {
    return view('auth.login');
});


//Authentication

Route::post('/',[LoginController::class,'authenticate'])->name('authenticate');
Route::post('/logout',function(){
    Auth::logout();
    return redirect('/');
})->name('logout');

Route::prefix('home')->group(function(){
    Route::controller(HomeController::class)->group(function(){
        Route::get('/','getDashboardOverview')->name('getDashboardOverview');
        Route::post('/searchStudent','searchStudent')->name('searchStudent');
        Route::get('/searchStudent/viewSearchResults','viewSearchResults')->name('viewSearchResults');
    });
    //Administration

    Route::prefix('administration')->group(function(){
         Route::prefix('users')->group(function(){
            Route::controller(UsersController::class)->group(function(){
               Route::get('/','getAllUsers')->name('getAllUsers');
               Route::prefix('create')->group(function(){
                    Route::get('/','createNewUser')->name('createNewUser');
                    Route::post('/','saveNewUser')->name('saveNewUser');
               });
               Route::prefix('/{id}')->group(function(){
                   Route::put('editUserAccount','editUserAccount')->name('editUserAccount');
                   Route::prefix('editUser')->group(function(){
                    Route::get('/','editUser')->name('editUser');
                    Route::put('/','updateUser')->name('updateUser');
                   });
               });
            });
        });

         Route::prefix('courses')->group(function(){
            Route::controller(AdminCoursesController::class)->group(function(){
                Route::get('/','getAllCourses')->name('getAllCourses');
                Route::prefix('create')->group(function(){
                    Route::get('/','createNewCourse')->name('createNewCourse');
                    Route::post('/','saveNewCourse')->name('saveNewCourse');
               });
            });
         });

         Route::prefix('classrooms')->group(function(){
             Route::controller(ClassRoomsController::class)->group(function(){
                Route::get('/','getAllClasses')->name('getAllClasses');
                Route::prefix('create')->group(function(){
                    Route::get('/','createNewClassRoom')->name('createNewClassRoom');
                    Route::post('/','saveNewClassRoom')->name('saveNewClassRoom');
               });
                Route::prefix('/{id}')->group(function(){
                   Route::prefix('students')->group(function(){
                      Route::get('/','viewStudents')->name('viewStudents');
                      Route::get('/create','addStudent')->name('addStudent');
                      Route::get('/create/import','getExcelSample')->name('getExcelSample');
                      Route::post('/create/import','importStudents')->name('importStudents');
                      Route::post('/create','saveStudent')->name('saveStudent');
                      Route::prefix('/{student}')->group(function(){
                        Route::get('/viewMarks','viewMarks')->name('viewMarks');
                        Route::get('/printMarks','printMarks')->name('printMarks');
                      });
                   });
                   Route::prefix('courses')->group(function(){
                      Route::get('/','viewCourses')->name('viewCourses');
                      Route::get('/create','addCourse')->name('addCourse');
                      Route::post('/create','saveCourse')->name('saveCourse');
                   });
                });
             });
         });

         Route::prefix('teachers')->group(function(){
             Route::controller(TeachersController::class)->group(function(){
                Route::get('/','getAllTeachers')->name('getAllTeachers');
             });
         });

    });

    //Teachers
    Route::prefix('teachers')->group(function() {
        Route::prefix('courses')->group(function(){
            Route::controller(TeacherCoursesController::class)->group(function(){
                Route::get('/{courseId}/{classId}','viewStudents')->name('teacherViewStudents');
                Route::get('/{courseId}/{student_id}/addMark','addMark')->name('addMark');
                Route::get('/{courseId}/{student_id}/editMark','editMark')->name('editMark');
                Route::post('/{courseId}/{student_id}/addMark','saveMark')->name('saveMark');
                Route::put('/{courseId}/{student_id}/updateMark','updateMark')->name('updateMark');
            });
        });
        Route::controller(AttendanceController::class)->group(function(){
            Route::prefix('attendance')->group(function(){
                Route::get('/{courseId}/{classId}','makeAttendance')->name('makeAttendance');
                Route::post('/{courseId}/{classId}','saveAttendance')->name('saveAttendance');
            });
        });
    });
});

