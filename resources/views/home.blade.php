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
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item active">Home</li>
                </ol>
            </div>
        </div>
    </div>
    <!-- /# column -->
</div>
<!-- /# row -->
@if (Auth::user()->role->name == \App\Models\Role::ADMINISTRATOR || Auth::user()->role->name == \App\Models\Role::DIRECTOR_OF_STUDIES)
<!--Administrator-->
<section id="main-content">
    <div class="row">
        <div class="col-lg-3">
            <div class="card">
                <div class="stat-widget-one">
                    <div class="stat-icon dib"><i class="ti-money color-success border-success"></i>
                    </div>
                    <div class="stat-content dib">
                        <div class="stat-text">Total Students</div>
                        <div class="stat-digit">{{$totalStudents}}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card">
                <div class="stat-widget-one">
                    <div class="stat-icon dib"><i class="ti-user color-primary border-primary"></i>
                    </div>
                    <div class="stat-content dib">
                        <div class="stat-text">Total Courses</div>
                        <div class="stat-digit">{{$totalCourses}}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card">
                <div class="stat-widget-one">
                    <div class="stat-icon dib"><i class="ti-layout-grid2 color-pink border-pink"></i>
                    </div>
                    <div class="stat-content dib">
                        <div class="stat-text">Total Teachers</div>
                        <div class="stat-digit">{{$totalTeachers}}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card">
                <div class="stat-widget-one">
                    <div class="stat-icon dib"><i class="ti-link color-danger border-danger"></i></div>
                    <div class="stat-content dib">
                        <div class="stat-text">Total Classes</div>
                        <div class="stat-digit">{{$totalClasses}}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="stat-widget-one">
                    <div class="stat-icon dib"><i class="ti-link color-danger border-danger"></i></div>
                    <div class="stat-content dib">
                        <div class="stat-text">Total Male Students</div>
                        <div class="stat-digit">{{$totalMaleStudents}}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="stat-widget-one">
                    <div class="stat-icon dib"><i class="ti-link color-danger border-danger"></i></div>
                    <div class="stat-content dib">
                        <div class="stat-text">Total Female Students</div>
                        <div class="stat-digit">{{$totalFemaleStudents}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- /# column -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-title pr">
                    <h4>Latest Students Added</h4>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table student-data-table m-t-20">
                            <thead>
                                <tr>
                                    <th>Names</th>
                                    <th>Class</th>
                                    <th>Gender</th>
                                    <th>Student No</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($latestStudents as $item)
                                <tr>
                                    <td>{{$item->names}}</td>
                                    <td>{{$item->classRoom->room_code}}</td>
                                    <td>
                                       {{$item->gender}}
                                    </td>
                                    <td>
                                        {{$item->student_no}}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /# column -->
        <!-- /# column -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-title pr">
                    <h4>Latest Teachers Added</h4>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table student-data-table m-t-20">
                            <thead>
                                <tr>
                                    <th>Names</th>
                                    {{-- <th>Number of Courses</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($latestTeachers as $item)
                                <tr>
                                    <td>{{$item->user->names}}</td>
                                    {{-- <td>{{$item->courses()->count()}}</td> --}}
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /# column -->
        
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-title">
                    <h4>Search Student</h4>                                    
                </div>
                <div class="card-body">
                    <div class="horizontal-form">
                        <form class="form" action="{{route('searchStudent')}}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Student Names</label>
                                        <input type="text" name="names" class="form-control" placeholder="Student Names">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Student Code</label>
                                        <input type="text" name="number" class="form-control" placeholder="Student Code">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Student Class</label>
                                        <select class="form-control" name="classRoom">
                                            <option selected disabled>select class...</option>
                                            @foreach ($classRooms as $item)
                                                <option value="{{$item->id}}">{{$item->room_code}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-primary">Search Student</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@elseif(Auth::user()->role->name == \App\Models\Role::TEACHER)
 <section id="content">
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center">My Courses</h1>
        </div>
    </div>
    <div class="row">
        @forelse ($myCourses as $item)
        <div class="col-md-3">
            <div class="card" style="width: 18rem;">
                <img class="card-img-top" src="{{url('/dashboardAssets/assets/images/teaching.jpg')}}" alt="Card image cap">
                <div class="card-body">
                    <br>
                    <h5>{{$item['course']}}</h5>
                  <p class="card-text">class: <b>{{$item['class']}}</b></p>
                  <p class="card-text">Day: <b>{{$item['day']}}</b></p>
                  <p class="card-text">From: <b>{{$item['from']}}</b></p>
                  <p class="card-text">To: <b>{{$item['to']}}</b></p>
                  <a href="{{route('teacherViewStudents',[$item['course_id'],$item['class_id']])}}" class="btn btn-primary btn-block">More</a>
                </div>
              </div>
        </div>
        @empty
        <div class="col-md-8 offset-md-2">
            <div class="alert alert-danger">
                <h6 class="text-center"> dear {{auth()->user()->names }} You have no courses assigned to you now</h6>
            </div>
        </div>

        @endforelse
    </div>
 </section>
@endif
@endsection