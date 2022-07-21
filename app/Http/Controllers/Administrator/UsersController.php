<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware(function($request , $next){
            if(Auth::check() && Auth::user()->role->name == \App\Models\Role::ADMINISTRATOR){
                return $next($request);
            }else{
                return back();
            }
        });
    }

    public function getAllUsers()
    {
        $allUsers = User::get();
        return view('Admin/Users/index',compact('allUsers'));
    }

    public function createNewUser()
    {
        return view('Admin/Users/create');
    }
    public function saveNewUser(Request $request)
    {
        try {
            DB::beginTransaction();
            $checkUsername = User::where('username','LIKE',"%{$request->username}%");
            if($checkUsername->exists()){
                return back()->withInput()->with('danger','user with such username exists');
            }
            $teacherId = Role::where('name','TEACHER')->value('id');
            if($request->role === $teacherId){
                $newUser = [
                    'id' =>Str::uuid()->toString(),
                    'role_id'=>$request->role,
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
            }else{
                $newUser = [
                    'id' =>Str::uuid()->toString(),
                    'role_id'=>$request->role,
                    'names'=>$request->names,
                    'username'=>$request->username,
                    'password'=>Hash::make($request->password),
                    'created_at'=>now(),
                    'updated_at'=>now()
                ];
                User::insert($newUser);
            }
            DB::commit();
            return redirect()->route('getAllUsers')->with('success','new user created successfully');

        } catch (\Throwable $th) {
            DB::rollback();
            return back()->withInput()->with('danger','an error occured..please try again');
        }
    }

    public function editUser($id)
    {
        $userToEdit = User::find($id);
        return view('Admin/Users/edit',compact('userToEdit'));
    }

    public function updateUser(Request $request , $id)
    {
        $userToEdit = User::find($id);
       try {
           DB::beginTransaction();
           $userToEdit->update([
               'password'=>Hash::make($request->password)
           ]);
           DB::commit();
           return redirect()->route('getAllUsers')->with('success','user password changed successfully');
       } catch (\Throwable $th) {
        DB::rollback();
        return back()->withInput()->with('danger','an error occured..please try again');
       }
    }

    public function editUserAccount(Request $request ,$id)
    {
        $userToEdit = User::find($id);
        $userStatus = $userToEdit->is_active;
       try {
           DB::beginTransaction();
           if($userStatus){
                $userToEdit->update([
                    'is_active'=>false
                ]);
                DB::commit();
                return back()->withInput()->with('success','user account closed successfully');
            }else{
                $userToEdit->update([
                    'is_active'=>true
                ]);
                DB::commit();
                return back()->withInput()->with('success','user account activated successfully');
            
        }
       } catch (\Throwable $th) {
        DB::rollback();
        return back()->withInput()->with('danger','an error occured..please try again');
       }
    }
}
