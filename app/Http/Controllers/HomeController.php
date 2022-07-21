<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Course;
use App\Models\ClassRoom;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getDashboardOverview()
    {
        if(Auth::user()->role->name == \App\Models\Role::ADMINISTRATOR || Auth::user()->role->name == \App\Models\Role::DIRECTOR_OF_STUDIES){
            $totalStudents = Student::count();
            $totalTeachers = Teacher::count();
            $totalCourses = Course::count();
            $totalClasses = ClassRoom::count();
            $totalMaleStudents = Student::where('gender',\App\Models\Student::Male)->count();
            $totalFemaleStudents = Student::where('gender',\App\Models\Student::Female)->count();
            $latestStudents = Student::with('classRoom')->latest()->limit(5)->get();
            $latestTeachers = Teacher::with('user')->latest()->limit(5)->get();
            $classRooms = ClassRoom::orderBy('room_code','asc')->get();
            return view('home',compact(
                'totalStudents',
                'totalTeachers',
                'totalCourses',
                'totalClasses',
                'totalMaleStudents',
                'totalFemaleStudents',
                'latestStudents',
                'latestTeachers',
                'classRooms'
            ));
        }else{
            $myCourses = [];
            $data = [];
            $authenticatedUser = Auth::user();
            $authenticatedTeacher = $authenticatedUser->teacher()->first();
            $allCourses = DB::table('class__courses')->where('teacher_id',$authenticatedTeacher->id)->get();
            foreach ($allCourses as $course) {
              $classRoomName = ClassRoom::where('id',$course->classroom_id)->first();
              $courseName = Course::where('id',$course->course_id)->first();
              $myCourses[] = [
                 'id' => $course->id,
                 'class' => $classRoomName->room_code,
                 'class_id' =>$course->classroom_id,
                 'course' => $courseName->name,
                 'course_id' => $courseName->id,
                 'day' => $course->day,
                 'from' => $course->from,
                 'to' => $course->to
              ];
            }
            return view('home',compact(
             'myCourses',
         ));
        }
    }
    public function searchStudent(Request $request)
    {
        $names = $request->names;   
        $code = $request->number;
        $classRoom = $request->classRoom;
        $searchResults = [];

        if($names && !$code && !$classRoom) {
           $searchResults = Student::where('names','LIKE','%' . $names . '%')->get();
        }
        else if (!$names && $code && !$classRoom) {
            $searchResults = Student::where('student_no','LIKE','%' . $code . '%')->get();
        }
        else if (!$names && !$code && $classRoom) {
            $searchResults = Student::where('classroom_id','LIKE','%' . $classRoom . '%')->get();
        }
        else if ($names && $code && !$classRoom) {
            $searchResults = Student::where('names','LIKE','%' . $names . '%')
            ->where('student_no','LIKE','%' . $code . '%')
            ->get();
        }
        else if ($names && !$code && $classRoom) {
            $searchResults = Student::where('names','LIKE','%' . $names . '%')
            ->where('classroom_id','LIKE','%' . $classRoom . '%')
            ->get();
        }
        else if (!$names && $code && $classRoom) {
            $searchResults = Student::where('student_no','LIKE','%' . $code . '%')
            ->where('classroom_id','LIKE','%' . $classRoom . '%')
            ->get();
        }
        else if ($names && $code && $classRoom) {
            $searchResults = Student::where('student_no','LIKE','%' . $code . '%')
            ->where('classroom_id','LIKE','%' . $classRoom . '%')
            ->where('names','LIKE','%' . $names . '%')
            ->get();
        }
        $request->session()->put('searchResults', $searchResults);
        if(!is_null($code)){
            $request->session()->put('student_no', $code);
        }
        if(!is_null($classRoom)){
            $request->session()->put('classRoom', $classRoom);
        }
        if(!is_null($names)){
            $request->session()->put('names', $names);
        }
        return redirect()->route('viewSearchResults');
    }

    public function viewSearchResults(Request $request)
    {
       $searchResults =  $request->session()->get('searchResults');
       return view('searchResults',compact('searchResults'));
    }
}
