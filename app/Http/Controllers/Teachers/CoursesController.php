<?php

namespace App\Http\Controllers\Teachers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Course;
use App\Models\ClassRoom;
use App\Models\MarkType;
use App\Models\Mark;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CoursesController extends Controller
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

    public function viewStudents($courseId , $classRoomId)
    {
        $course = Course::find($courseId);
        $classRoom =  ClassRoom::find($classRoomId);
        $students = Student::where('classroom_id',$classRoomId)->get();
        return view('Teachers/Courses/courseStudents',compact('students','course','classRoom'));
    }

    public function addMark($courseId , $studentId)
    {
        $course = Course::find($courseId);
        $student = Student::find($studentId);
        $classRoom = ClassRoom::find($student->classroom_id);
        $markTypes = MarkType::get();
        return view('Teachers/Marks/create',compact('student','course','markTypes','classRoom'));
    }
    public function editMark($courseId , $studentId, Request $request)
    {
        $course = Course::find($courseId);
        $student = Student::find($studentId);
        $classRoom = ClassRoom::find($student->classroom_id);
        $trimester = $request->get('trimester');
        if(!$trimester) {
            return back()->withInput()->with('danger','please try again and select the trimester');            
        }
        $record = Mark::where('student_id',$studentId)->where('course_id',$courseId)->where('trimester',$trimester)->first();
        if(!$record) {
            return back()->withInput()->with('danger','there is no marks for '. $trimester .' for this student and for this course ');
        }
        return view('Teachers/Marks/edit',compact('student','course','record','classRoom'));
    }

    public function updateMark (Request $request , $courseId , $studentId)
    {
        $course = Course::find($courseId);
        $student = Student::find($studentId);
        $classRoom = ClassRoom::find($student->classroom_id);
        $quizzes = $request->total_quizzes;
        $exams = $request->total_exams;
        $maxQuizzes = $course->total_quizzes;
        $maxExam = $course->total_exams;
        $record = Mark::find($request->recordId);
        if($quizzes > $maxQuizzes) {
            return back()->withInput()->with('danger','the maximum quizzes marks for ' . $course->name . ' is '. $maxQuizzes .' ');
        }
        if($exams > $maxExam) {
            return back()->withInput()->with('danger','the maximum exam marks for ' . $course->name . ' is '. $maxQuizzes .' ');
        }
        try {
            DB::beginTransaction();
            $record->update([
                'total_quizzes' => $quizzes,
                'total_exams' =>$exams,
            ]);
            DB::commit();
            return redirect()->route('teacherViewStudents',[$courseId , $classRoom->id])->with('success','marks updated successfully');
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->withInput()->with('danger','an error occured..please try again');
        }
    }
    public function saveMark($courseId , $studentId , Request $request)
    {
        $course = Course::find($courseId);
        $student = Student::find($studentId);
        $classRoom = ClassRoom::find($student->classroom_id);
        $quizzes = $request->total_quizzes;
        $exams = $request->total_exams;
        $trimester = $request->trimester;
        $maxQuizzes = $course->total_quizzes;
        $maxExam = $course->total_exams;
        if($quizzes > $maxQuizzes) {
            return back()->withInput()->with('danger','the maximum quizzes marks for ' . $course->name . ' is '. $maxQuizzes .' ');
        }
        if(!$trimester) {
            return back()->withInput()->with('danger','please select the trimester');
        }
        if($exams > $maxExam) {
            return back()->withInput()->with('danger','the maximum exam marks for ' . $course->name . ' is '. $maxQuizzes .' ');
        }
        $checkTrimesterMark = Mark::where('course_id',$course->id)->where('student_id',$student->id)->where('trimester',$trimester);
        if($checkTrimesterMark->exists()) {
            return back()->withInput()->with('danger','there is marks for this student in this trimester..please choose other trimester or update
            existing marks');
        }
        try {
            DB::beginTransaction();
            $newMark = [
                'id' =>Str::uuid()->toString(),
                'student_id' => $studentId,
                'total_quizzes' => $quizzes,
                'total_exams' =>$exams,
                'course_id' =>$courseId,
                'trimester' => $trimester,
                'created_at' =>now(),
                'updated_at' =>now(),
            ];
            Mark::insert($newMark);
            DB::commit();
            return redirect()->route('teacherViewStudents',[$courseId , $classRoom->id])->with('success','marks added successfully');
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->withInput()->with('danger','an error occured..please try again');
        }
    }
}
