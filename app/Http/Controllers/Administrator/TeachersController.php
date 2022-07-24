<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Teacher;

class TeachersController extends Controller
{
    public function __construct()
    {
        $this->middleware(function($request , $next){
            if(Auth::check() && Auth::user()->role->name == \App\Models\Role::ADMINISTRATOR || Auth::check() && Auth::user()->role->name == \App\Models\Role::DIRECTOR_OF_STUDIES){
                return $next($request);
            }else{
                return back();
            }
        });
    }

    public function getAllTeachers()
    {
        $allTeachers =  Teacher::with('courses')->with('user')->get();
        return view('Admin/teachers/index',compact('allTeachers'));
    }

}
