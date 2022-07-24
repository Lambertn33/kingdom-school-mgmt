<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\ClassRoom;
use App\Models\Attendance;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Course;
use App\Models\Mark;
use App\Imports\StudentsImport;
use Illuminate\Support\Facades\Response;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class ClassRoomsController extends Controller
{
    public function __construct()
    {
        $this->middleware(function($request , $next){
            if(Auth::check() &&( Auth::user()->role->name == \App\Models\Role::ADMINISTRATOR ||  Auth::user()->role->name == \App\Models\Role::DIRECTOR_OF_STUDIES)){
                return $next($request);
            }else{
                return back();
            }
        });
    }


    public function getAllClasses()
    {
        $allClasses = ClassRoom::with('students')->with('courses')->orderBy('room_code','asc')->get();
        return view('Admin/classrooms/index',compact('allClasses'));
    }

    public function createNewClassRoom()
    {
        if (Auth::user()->role->name == \App\Models\Role::ADMINISTRATOR) {
         return view('Admin/classrooms/create');
        }else {
         return back();
        }
    }     

    public function saveNewClassRoom(Request $request)
    {
       try {
            DB::beginTransaction();
            $classRoomCode = strtoupper($request->room_code);
            $checkRoomCode = ClassRoom::where('room_code','LIKE',"%{$classRoomCode}%");
            if($checkRoomCode->exists()){
                return back()->withInput()->with('danger','class room with such code exists');
            }
            $newClassRoom = [
                'id' =>Str::uuid()->toString(),
                'room_code'=>$classRoomCode,
                'created_at'=>now(),
                'updated_at'=>now()
            ];
            ClassRoom::insert($newClassRoom);
            DB::commit();
            return redirect()->route('getAllClasses')->with('success','new class room created successfully');
       } catch (\Throwable $th) {
            DB::rollback();
            return back()->withInput()->with('danger','an error occured..please try again');
       }
    }

    public function viewStudents($id)
    {
        $classRoom = ClassRoom::find($id);
        $students = $classRoom->students()->orderBy('names','asc')->get();
        return view('Admin/classrooms/students/index',compact('students','classRoom'));
    }

    public function viewMarks($id , $studentId , Request $request)
    {
        $trimester = $request->get('trimester');
        if(!$trimester) {
            return back()->with('danger', 'please select the trimester');
        }
        $studentMarks = Mark::with('course')->where('student_id',$studentId)->where('trimester',$trimester)->get();
        $totalStudentQuizzes = Mark::with('course')->where('student_id',$studentId)->where('trimester',$trimester)->sum('total_quizzes');
        $totalStudentExams = Mark::with('course')->where('student_id',$studentId)->where('trimester',$trimester)->sum('total_exams');
        $student = Student::find($studentId);
        $classRoom = ClassRoom::find($student->classroom_id);
        $allClassCourses = $classRoom->courses()->get();
        if($request->session()->has('studentMarks')) {
            $request->session()->forget('studentMarks');
        }
        if($request->session()->has('totalStudentQuizzes')) {
            $request->session()->forget('totalStudentQuizzes');
        }
        if($request->session()->has('totalStudentExams')) {
            $request->session()->forget('totalStudentExams');
        }
        if($request->session()->has('student')) {
            $request->session()->forget('student');
        }
        if($request->session()->has('classRoom')) {
            $request->session()->forget('classRoom');
        }
        if($request->session()->has('allClassCourses')) {
            $request->session()->forget('allClassCourses');
        }
        if($request->session()->has('trimester')) {
            $request->session()->forget('trimester');
        }

        $request->session()->put('studentMarks',$studentMarks);
        $request->session()->put('totalStudentQuizzes',$totalStudentQuizzes);
        $request->session()->put('totalStudentExams',$totalStudentExams);
        $request->session()->put('student',$student);
        $request->session()->put('classRoom',$classRoom);
        $request->session()->put('allClassCourses',$allClassCourses);
        $request->session()->put('trimester',$trimester);

        if(count($studentMarks) > 0) {
            return view('Admin/classrooms/students/marks/index',compact('student','classRoom','allClassCourses','studentMarks' ,'trimester','totalStudentQuizzes','totalStudentExams'));
        } else {
            return back()->with('danger', 'No marks available for '. $student->names .' for the selected semester');
        }

    }
    public function printMarks($id , $studentId , Request $request)
    {
        $studentMarks = $request->session()->get('studentMarks');
        $totalStudentQuizzes = $request->session()->get('totalStudentQuizzes');
        $totalStudentExams = $request->session()->get('totalStudentExams');
        $student = Student::find($studentId);
        $classRoom = ClassRoom::find($student->classroom_id);
        $trimester = $request->session()->get('trimester');
        $allClassCourses = $classRoom->courses()->get();
        $numberOfStudents = Student::where('classroom_id',$classRoom->id)->count();
        return view('Admin/classrooms/students/marks/report',compact('student','numberOfStudents','classRoom','trimester','allClassCourses','studentMarks' ,'totalStudentQuizzes','totalStudentExams'));
    }

    public function getExcelSample() {
        $filePath = public_path("students_sample.xlsx");
        return Response::download($filePath);
    }

    public function importStudents ($id, Request $request)
    {
        try {
            $fileToImport = $request->file('students-file');
            Excel::import(new StudentsImport($id) ,$fileToImport);
            return back()->with('success','students imported successfully');
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->withInput()->with('danger','an error occured..please check the excel file and upload again');
        }
    }
    public function addStudent($id)
    {
        if (Auth::user()->role->name == \App\Models\Role::ADMINISTRATOR) {
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
            return view('Admin/classrooms/students/create',compact('classRoom','formattedStudentNo'));
        }else{
            return back();
        }
    }

    public function saveStudent(Request $request , $id)
    {
        try {
            DB::beginTransaction();
            $classRoom = ClassRoom::find($id);
            $newStudent = [
                'id' => Str::uuid()->toString(),
                'names' => $request->names,
                'gender' => $request->gender,
                'student_no' => $request->student_no,
                'classroom_id' => $classRoom->id,
                'created_at' => now(),
                'updated_at' => now()
            ];
            Student::insert($newStudent);
            DB::commit();
            return redirect()->route('viewStudents',$classRoom->id)->with('success','new student saved successfully');
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->withInput()->with('danger','an error occured,,please try again');
        }
    }
    public function viewCourses($id)
    {
        $classRoom = ClassRoom::find($id);
        $courses = $classRoom->courses()->orderBy('name','asc')->get();
        return view('Admin/classrooms/courses/index',compact('courses','classRoom'));
    }

    public function addCourse($id)
    {
        $classRoom = ClassRoom::find($id);
        $courses = Course::get();
        $teachers = Teacher::get();
        return view('Admin/classrooms/courses/create',compact('classRoom','courses','teachers'));
    }

    public function saveCourse(Request $request , $id)
    {
        try {
            DB::beginTransaction();
            $data = $request->all();
            $courses = $data['courses'];
            $teachers = $data['teachers'];
            $days = $data['days'];
            $from = $data['from'];
            $to = $data['to'];
            $classRoom = ClassRoom::find($id);
    
            for($i = 0; $i < count($courses); $i++) {
                $course = Course::find($courses[$i]);
                $classRoom->courses()->attach(
                    $course,
                    array(
                        'id' => Str::uuid()->toString(),
                        'course_id'=>$courses[$i],
                        'day'=>$days[$i],
                        'from'=>$from[$i],
                        'to' =>$to[$i],
                        'teacher_id' => $teachers[$i],
                        'created_at' => now(),
                        'updated_at' => now(),
                    )
                );
            }
            DB::commit();
            return redirect()->route('viewCourses',$classRoom->id)->with('success','new course saved successfully');
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->withInput()->with('danger','an error occured,,please try again');
        }
    }

    //Attendances

    public function searchAttendance(Request $request , $id)
    {
        $date = $request->date;
        $absentStudents = [];
        $course = $request->course;
        $checkAttendance = Attendance::where('course_id',$course)->where('class_id',$id)->where('date',$date)->first();
        if(!is_null($checkAttendance)) {
            $decodedIds = json_decode($checkAttendance->students_ids);
            if (!is_null($decodedIds)) {
                foreach ($decodedIds as $value) {
                    $absentStudents[] = Student::where('id',$value)->first();
                }
            }
            if($request->session()->has('absentStudents')) {
                $request->session()->forget('absentStudents');
            }
            if($request->session()->has('course')) {
                $request->session()->forget('course');
            }
            if($request->session()->has('date')) {
                $request->session()->forget('date');
            }
    
            $request->session()->put('absentStudents',$absentStudents);
            $request->session()->put('date',$date);
            $request->session()->put('course',$course);
            return redirect()->route('viewAttendance',$id);
        } else {
            return back()->with('danger','no data available for the selected date and course');
        }
    }
    
    public function viewAttendance(Request $request, $id)
    {
        $absentStudents = $request->session()->get('absentStudents');
        $attendanceDate = $request->session()->get('date');
        $attendanceCourse = Course::find($request->session()->get('course'));
        $classRoom = ClassRoom::find($id);
        return view('Admin/classrooms/attendances/index',compact('classRoom','absentStudents','attendanceDate','attendanceCourse'));
    }
}
