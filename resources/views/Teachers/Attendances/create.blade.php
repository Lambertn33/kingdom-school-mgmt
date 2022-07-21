@extends('layouts.layouts')

@section('content')

<div class="row">
    <div class="col-lg-6 p-r-0 title-margin-right">
        <div class="page-header">
            <div class="page-title">
                <h1>Hello, <span>Welcome Here</span></h1>
            </div>
        </div>
    </div>
    <!-- /# column -->
    <div class="col-lg-6 p-l-0 title-margin-left">
        <div class="page-header">
            <div class="page-title">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('teacherViewStudents',[$course->id,$classRoom->id])}}">Students</a></li>
                    <li class="breadcrumb-item active"> Attendance for <b>{{$course->name}}</b> course in <b>{{$classRoom->room_code}}</b> on <b>{{$todayDate}}</b></li>
                </ol>
            </div>
        </div>
    </div>
    <!-- /# column -->
</div>

<section id="content">
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="card">
                <div class="card-title">
                    Make Today's Attendance
                    <span class="text-danger" style="font-size: 1rem;">(<b>Please tick all absent students</b>)</span>
                </div>
                <br>
                <div class="card-body">
                    <form action="" method="post">
                        @csrf
                        <ul class="list-group">
                            @foreach ($students as $item)
                            <li class="list-group-item">
                                <div class="form-check">
                                    <input type="checkbox" value="{{$item->id}}" name="absentStudents[]" class="form-check-input" id="{{$item->id}}">
                                    <label class="form-check-label" for="{{$item->id}}">{{$item->names}}</label>
                                  </div>
                            </li>
                            @endforeach
                        </ul>
                        <br>
                        <button type="submit" class="btn btn-success btn-sm">Submit Attendance</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection