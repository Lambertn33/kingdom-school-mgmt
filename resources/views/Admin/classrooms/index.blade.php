@extends('layouts.layouts')

@section('content')
<div class="row">
    <div class="col-lg-8 p-r-0 title-margin-right">
        <div class="page-header">
            <div class="page-title">
                <h1>Hello, <span>Welcome Here</span></h1>
            </div>
        </div>
    </div>
    <!-- /# column -->
    <div class="col-lg-4 p-l-0 title-margin-left">
        <div class="page-header">
            <div class="page-title">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route("getDashboardOverview")}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Class Rooms</li>
                </ol>
            </div>
        </div>
    </div>
    <!-- /# column -->
</div>
<!-- /# row -->
<div class="row">
    @if (Auth::user()->role->name == \App\Models\Role::ADMINISTRATOR)
    <div class="col-md-12">
        <a href="{{route('createNewClassRoom')}}" style="float: right" class="btn btn-primary">Add New Class Room</a>
    </div>
    @endif
</div>
<section id="main-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="bootstrap-data-table-panel">
                    <div class="table-responsive">
                        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                                @if(Session::has($msg))
                                <div class="alert alert-{{ $msg }} alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    {{ Session::get($msg) }}
                                </div>
                                @endif
                            @endforeach
                        <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Room Code</th>
                                    <th>Status</th>
                                    <th>Number of Students</th>
                                    <th>Number of Courses</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $counter = 1; ?>
                                @foreach ($allClasses as $item)
                                <tr>
                                        <th>{{$counter}}</th>
                                        <?php $counter ++ ?>
                                       <td> {{$item->room_code}}</td>
                                       <td>
                                        @if ($item->status === \App\Models\ClassRoom::OPEN)
                                            <span class="badge badge-success">Open</span>
                                        @else
                                            <span class="badge badge-danger">Closed</span>
                                        @endif
                                       </td>
                                       <td> {{$item->students()->count()}}</td>
                                       <td> {{$item->courses()->count()}}</td>
                                       <td> 
                                           <a href="{{route('viewStudents',$item->id)}}" class="btn btn-primary btn-sm">Students</a>
                                           <a href="{{route('viewCourses',$item->id)}}" class="btn btn-success btn-sm">Courses</a>
                                           @if ($item->courses()->count() > 0 && $item->students()->count())
                                           <a href="" data-toggle="modal" data-target="#{{$item->id}}-attendances" class="btn btn-warning btn-sm">Attendances</a>
                                           @else
                                           <button href=""  class="btn btn-danger btn-sm" disabled>No Attendance</button>
                                           @endif

                                                   <!--Attendance Modal-->
                                            <div class="modal fade" id="{{$item->id}}-attendances" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Check Attendances in {{$item->room_code}}</h5>
                                                    </div>
                                                    <form action="{{route('searchAttendance',$item->id)}}" method="POST">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label>Select Course</label>
                                                                        <select class="form-control" required name="course">
                                                                            <option selected disabled>Choose Course</option>
                                                                            @foreach ($item->courses()->get() as $course)
                                                                                <option value="{{$course->id}}">{{$course->name}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <br>
                                                                    <div class="form-group">
                                                                        <label>Select Date</label>
                                                                        <input type="date" max="<?php echo date('Y-m-d') ?>" name="date" class="form-control">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary">Proceed</button>
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </form>
                                                </div>
                                                </div>
                                            </div>

                                            <!--End Attendance-->
                                       </td>
                                    </tr>
                                    @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /# card -->
        </div>
        <!-- /# column -->
    </div>
</section>
@endsection