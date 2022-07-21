<?php

namespace App\Http\Controllers\Teachers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Attendance;
use App\Models\Course;
use App\Models\ClassRoom;

class AttendanceController extends Controller
{
    public function __construct()
    {
        $this->middleware(function($request , $next){
            if(Auth::check() && Auth::user()->role->name == \App\Models\Role::TEACHER){
                return $next($request);
            }else{
                return back();
            }
        });
    }

    public function makeAttendance($courseId,$classId)
    {
        $course = Course::find($courseId);
        $classRoom = ClassRoom::find($classId);
        $students = $classRoom->students()->orderBy('names','asc')->get();
        $date = new \DateTime();
        $todayDate = $date->format('Y-m-d');
        return view('Teachers/Attendances/create',compact('course','students','classRoom','todayDate'));

    }
    public function saveAttendance(Request $request,$courseId,$classId)
    {
        $date = new \DateTime();
        $date->setTimezone(new \DateTimeZone('+0200'));
        $course = Course::find($courseId);
        $classRoom = ClassRoom::find($classId);
        $todayTime = $date->format('H:i');
        $todayDate = $date->format('Y-m-d');
        $absentStudents = $request->absentStudents;
        return $absentStudents;
    }
}
