<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\ClassRoom;
use App\Models\Student;
use Illuminate\Support\Facades\Response;

class ClassRoomController extends Controller
{
    public function getAllClassRooms()
    {
        return Response::json([
            'status'  => '200',
            'data' => ClassRoom::get(),
        ], 200);
    }
    
    public function getClassRoomStudents($id)
    {
        $classRoom = ClassRoom::find($id);
        if(!$classRoom) {
            return Response::json([
                'status'  => '404',
                'message' => 'Classroom not found',
            ], 404);
        } else {
            return Response::json([
                'status'  => '200',
                'data' => $classRoom->students()->get(),
            ], 200);
        }
    }

    public function createNewStudent(Request $request, $id)
    {
        $classRoom = ClassRoom::find($id);
        $studentCode = 1;
        $students = Student::get();
        $formattedYear =  substr(date('Y') ,-2);
        if(count($students) > 0){
            $lastStudent = Student::orderBy('student_no','desc')->limit(1)->first();
            $lastStudent =  intval(substr($lastStudent->student_no, 3));
            $formattedNumber =  substr(str_repeat(0, 4). $lastStudent + 1, - 4);
            $formattedStudentNo = ''.$formattedYear.$formattedNumber.'';
        }else{
            $formattedNumber =  substr(str_repeat(0, 4). $studentCode, - 4);
            $formattedStudentNo = ''.$formattedYear.$formattedNumber.'';
        }
        if(!$request->names) {
            return Response::json([
                'status'  => '400',
                'message' => 'names are missing',
            ], 400);
        }
        if(!$request->gender) {
            return Response::json([
                'status'  => '400',
                'message' => 'gender is missing',
            ], 400);
        }

        try {
            DB::beginTransaction();
            $classRoom = ClassRoom::find($id);
            $newStudent = [
                'id' => Str::uuid()->toString(),
                'names' => $request->names,
                'gender' => $request->gender,
                'student_no' => $formattedStudentNo,
                'classroom_id' => $classRoom->id,
                'created_at' => now(),
                'updated_at' => now()
            ];
            Student::insert($newStudent);
            DB::commit();
            return Response::json([
                'status'  => '200',
                'message' => 'student added successfully',
            ], 200);
        } catch (\Throwable $th) {
            DB::rollback();
            return Response::json([
                'status'  => '500',
                'message' => 'an error occured..please try again',
            ], 500);
        }

    }
}
