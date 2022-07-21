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
                    <li class="breadcrumb-item"><a href="{{route('viewStudents',$classRoom->id)}}">{{$classRoom->room_code}} Students</a></li>
                    <li class="breadcrumb-item active"> {{$student->names}} Marks</li>

                </ol>
            </div>
        </div>
    </div>
    <!-- /# column -->
</div>

<section id="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h4>{{$student->names}} marks for {{$trimester}}</h4>
                <a href="{{route('printMarks',[$classRoom->id,$student->id])}}" target="_blank" style="float: right" class="btn btn-primary">Generate Report</a>
            </div>
        </div>
    </div>
    <div class="row" id="row">
        <div class="col-md-12">
           <div class="card">
              <div class="bootstrap-data-table-panel">
                <div class="table-responsive">
                    <table id="bootstrap-data-table-exporte" class="table table-striped table-bordered">
                        <thead> 
                            <th>Subject</th>
                            <th>Total Quizzes</th>
                            <th>Total Exams</th>
                            <th>Grand Total</th>
                            <th>Student Total Quizzes</th>
                            <th>Student Total Exams</th>
                            <th>Student Grand Total</th>
                        </thead>
                        <tbody>
                            @foreach ($allClassCourses as $course)
                            <tr>
                               <td><b style="float: left">{{$course->name}}</b></td>            
                               <td><b style="float: left">{{$course->total_quizzes}}</b></td>            
                               <td><b style="float: left">{{$course->total_exams}}</b></td>            
                               <td style=""><b style="float: left">{{$course->total_quizzes + $course->total_exams}}</b></td> 
                                @foreach ($studentMarks as $mark)
                                    @if ($course->id == $mark->course_id)
                                        <td>{{$mark->total_quizzes}}</td>
                                        <td>{{$mark->total_exams}}</td>
                                        <td>{{$mark->total_quizzes + $mark->total_exams}}</td>
                                    @endif
                                @endforeach           
                            </tr>
                            @endforeach
                            <tr>
                                <td>Total</td>
                                <td><b>{{$allClassCourses->sum('total_quizzes')}}</b></td>
                                <td><b>{{$allClassCourses->sum('total_exams')}}</b></td>
                                <td><b>{{$allClassCourses->sum('total_quizzes') + $allClassCourses->sum('total_exams')}}</b></td>
                                <td>{{$totalStudentQuizzes}}</td>
                                <td>{{$totalStudentExams}}</td>
                                <td>{{$totalStudentExams + $totalStudentQuizzes }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
              </div>
            </div>  
        </div>
    </div>
</section>
@endsection