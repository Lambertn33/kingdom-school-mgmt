<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\ClassRoom;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Response;

class UsersController extends Controller
{
    public function getAllTeachers()
    {
        $allTeachers = Teacher::with('user')->get();
        $data = [];
        foreach ($allTeachers as $teacher) {
            $data[] = [
                'names' => $teacher->user->names,
                'username' => $teacher->user->username
            ];
        }
        return Response::json([
            'status'  => '200',
            'data' => $data
        ], 200);
    }

    public function createNewTeacher(Request $request)
    {
        if(!$request->names) {
            return Response::json([
                'status'  => '400',
                'message' => 'names are missing',
            ], 400);
        }
        if(!$request->username) {
            return Response::json([
                'status'  => '400',
                'message' => 'username is missing',
            ], 400);
        }
        if(!$request->password) {
            return Response::json([
                'status'  => '400',
                'message' => 'password is missing',
            ], 400);
        }
        $checkUsername = User::where('username','LIKE',"%{$request->username}%");
        if($checkUsername->exists()){
            return Response::json([
                'status'  => '400',
                'message' => 'username already exists',
            ], 400);
        }
        $teacherId = Role::where('name','TEACHER')->value('id');
        try {
            DB::beginTransaction();
            $checkUsername = User::where('username','LIKE',"%{$request->username}%");
            if($checkUsername->exists()){
                return Response::json([
                    'status'  => '400',
                    'message' => 'user with such username exists',
                ], 400);
            }
            $teacherId = Role::where('name','TEACHER')->value('id');
            $newUser = [
                'id' =>Str::uuid()->toString(),
                'role_id'=>$teacherId,
                'names'=>$request->names,
                'username'=>$request->username,
                'password'=>Hash::make($request->password),
                'created_at'=>now(),
                'updated_at'=>now()
            ];
            $newTeacher = [
                'id' => Str::uuid()->toString(),
                'user_id' => $newUser['id'],
                'created_at'=>now(),
                'updated_at'=>now()
            ];
            User::insert($newUser);
            Teacher::insert($newTeacher);
            DB::commit();
            return Response::json([
                'status'  => '200',
                'message' => 'teacher added successfully',
            ], 200);

        } catch (\Throwable $th) {
            DB::rollback();
            return Response::json([
                'status'  => '500',
                'message' => $th,
            ], 500);
        }
    }
}
