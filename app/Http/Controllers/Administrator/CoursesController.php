<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Course;

class CoursesController extends Controller
{
    public function __construct()
    {
        $this->middleware(function($request , $next){
            if(Auth::check() && ( Auth::user()->role->name == \App\Models\Role::ADMINISTRATOR ||  Auth::user()->role->name == \App\Models\Role::DIRECTOR_OF_STUDIES)){
                return $next($request);
            }else{
                return back();
            }
        });
    }

    public function getAllCourses()
    {
        $allCourses = Course::with('teachers')->with('classes')->orderBy('name','asc')->get();
        return view('Admin/Courses/index',compact('allCourses'));
    }

    public function createNewCourse()
    {
       if (Auth::user()->role->name == \App\Models\Role::ADMINISTRATOR) {
        return view('Admin/Courses/create');
       }else {
        return back();
       }
    }

    public function saveNewCourse(Request $request)
    {
        try {
            DB::beginTransaction();
            $checkCourseName = Course::where('name','LIKE',"%{$request->name}%");
            if($checkCourseName->exists()){
                return back()->withInput()->with('danger','course with such name exists');
            }
            $checkCourseCode = Course::where('code','LIKE',"%{$request->code}%");
            if($checkCourseCode->exists()){
                return back()->withInput()->with('danger','course with such code exists');
            }
            $newCourse = [
                'id' =>Str::uuid()->toString(),
                'name'=>$request->name,
                'code'=>$request->code,
                'total_quizzes'=>$request->total_quizzes,
                'total_exams'=>$request->total_exams,
                'created_at'=>now(),
                'updated_at'=>now()
            ];
            Course::insert($newCourse);
            DB::commit();
            return redirect()->route('getAllCourses')->with('success','new course created successfully');

        } catch (\Throwable $th) {
            DB::rollback();
            return back()->withInput()->with('danger','an error occured..please try again');
        }
    }
}
