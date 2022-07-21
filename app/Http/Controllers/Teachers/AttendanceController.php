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

    public function addAttendance(Request $request,$courseId, $classRoomId)
    {
        $studentId = $request->studentId;
        $date = new \DateTime();
        $date->setTimezone(new \DateTimeZone('+0200'));
        $classRoom = ClassRoom::find($classRoomId);
        $todayTime = $date->format('H:i');
        $todayDate = $date->format('Y-m-d');
        $uuid = Str::uuid()->toString();
        try {
            DB::beginTransaction();
            $newAttendance = [
                'id'=> $uuid,
                'date' => $todayDate,
                'time' => $todayTime,
                'created_at' => now(),
                'updated_at' => now()
            ];
            Attendance::insert($newAttendance);
            $classRoom->attendances()->attach($uuid, array(
                        'id' => Str::uuid()->toString(),
                        'student_id'=>$studentId,
                        'by' => Auth::user()->id,
                        'course_id' => $courseId,
                        'created_at' => now(),
                        'updated_at' => now(),
            ));
            DB::commit();
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
