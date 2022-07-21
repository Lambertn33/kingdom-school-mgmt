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
                    <li class="breadcrumb-item"><a href="{{route('getDashboardOverview')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active"> {{$course->name}} course in {{$classRoom->room_code}}</li>
                </ol>
            </div>
        </div>
    </div>
    <!-- /# column -->
</div>
<!-- /# row -->
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
                                    <th>Student Names</th>
                                    <th>Student Gender</th>
                                    <th>Sudent No</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $counter = 1; ?>
                                @foreach ($students as $item)
                                <tr>
                                        <th>{{$counter}}</th>
                                        <?php $counter ++ ?>
                                       <td> {{$item->names}}</td>
                                       <td> {{$item->gender}}</td>
                                       <td> {{$item->student_no}}</td>
                                       <td> 
                                           @if ($item->checkStudentMark($course->id))
                                                @php
                                                    $firstTermQuizzesMark = \App\Models\Mark::where('course_id',$course->id)->where('student_id',$item->id)
                                                    ->where('trimester',\App\Models\Mark::firstTerm)->value('total_quizzes');
                                                    $secondTermQuizzesMark = \App\Models\Mark::where('course_id',$course->id)->where('student_id',$item->id)
                                                    ->where('trimester',\App\Models\Mark::secondTerm)->value('total_quizzes');
                                                    $thirdTermQuizzesMark = \App\Models\Mark::where('course_id',$course->id)->where('student_id',$item->id)
                                                    ->where('trimester',\App\Models\Mark::thirdTerm)->value('total_quizzes');
                                                    $firstTermExamMark = \App\Models\Mark::where('course_id',$course->id)->where('student_id',$item->id)
                                                    ->where('trimester',\App\Models\Mark::firstTerm)->value('total_exams');
                                                    $secondTermExamMark = \App\Models\Mark::where('course_id',$course->id)->where('student_id',$item->id)
                                                    ->where('trimester',\App\Models\Mark::secondTerm)->value('total_exams');
                                                    $thirdTermExamMark = \App\Models\Mark::where('course_id',$course->id)->where('student_id',$item->id)
                                                    ->where('trimester',\App\Models\Mark::thirdTerm)->value('total_exams');
                                                    if(!$firstTermQuizzesMark) {
                                                        $firstTermQuizzesMark = 0;
                                                    }
                                                    if(!$secondTermQuizzesMark) {
                                                        $secondTermQuizzesMark = 0;
                                                    }
                                                    if(!$thirdTermQuizzesMark) {
                                                        $thirdTermQuizzesMark = 0;
                                                    }
                                                    if(!$firstTermExamMark) {
                                                        $firstTermExamMark = 0;
                                                    }
                                                    if(!$secondTermExamMark) {
                                                        $secondTermExamMark = 0;
                                                    }
                                                    if(!$thirdTermExamMark) {
                                                        $thirdTermExamMark = 0;
                                                    }
                                                    $totalMarks = $course->total_quizzes + $course->total_exams;
                                                    $totalStudentFirstTermMarks = $firstTermQuizzesMark + $firstTermExamMark;
                                                    $totalStudentSecondTermMarks = $secondTermQuizzesMark + $secondTermExamMark;
                                                    $totalStudentThirdTermMarks = $thirdTermQuizzesMark + $thirdTermExamMark;
                                                @endphp
                                               <button  data-toggle="modal" data-target="#{{$item->id}}" class="btn btn-info btn-sm">Check Marks</button>
                                               <button  data-toggle="modal" data-target="#{{$item->id}}-edit" class="btn btn-warning btn-sm">Edit Marks</button>
                                               <a href="{{route('addMark',[$course->id,$item->id])}}" class="btn btn-success btn-sm">Add Marks</a>
                                               <a href="#" onclick="document.getElementById('attendanceForm').submit();" class="btn btn-primary btn-sm">Add Attendance</a>
                                               <form id="attendanceForm" action="{{route('addAttendance',[$course->id,$classRoom->id])}}" style="display: none" method="POST">
                                                @csrf
                                                <input type="hidden" name="studentId" value="{{$item->id}}">
                                               </form>
                                               <!-- Edit Modal -->
                                               <div class="modal fade" id="{{$item->id}}-edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                   <div class="modal-dialog" role="document">
                                                   <div class="modal-content">
                                                       <div class="modal-header">
                                                           <h5 class="modal-title" id="exampleModalLabel">Edit Marks for {{$item->names}}</h5>
                                                       </div>
                                                       <form action="{{route('editMark',[$course->id,$item->id])}}" method="GET">
                                                       <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label>Select Trimester Marks to Edit</label>
                                                                    <select class="form-control" required name="trimester">
                                                                        <option selected disabled>Choose Trimester</option>
                                                                        @foreach (\App\Models\Mark::Trimester as $trimester)
                                                                            <option value="{{$trimester}}">{{$trimester}}</option>
                                                                        @endforeach
                                                                    </select>
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
                                               <!-- View Modal -->
                                               <div class="modal fade" id="{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                   <div class="modal-dialog" role="document">
                                                   <div class="modal-content">
                                                       <div class="modal-header">
                                                           <h5 class="modal-title" id="exampleModalLabel">{{$course->name}} Marks for {{$item->names}}</h5>
                                                       </div>
                                                       <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <h4>1st Term</h4>
                                                                <p><b>Total Quizzes: {{$firstTermQuizzesMark}} / {{$course->total_quizzes}}</b></p>
                                                                <p><b>Total Exams: {{$firstTermExamMark}} / {{$course->total_exams}}</b></p>
                                                                <h6>Grand Total: {{$totalStudentFirstTermMarks}} / {{$totalMarks}}</h6>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <h4>2nd Term</h4>
                                                                <p><b>Total Quizzes: {{$secondTermQuizzesMark}} / {{$course->total_quizzes}}</b></p>
                                                                <p><b>Total Exams: {{$secondTermExamMark}} / {{$course->total_exams}}</b></p>
                                                                <h6>Grand Total: {{$totalStudentSecondTermMarks}} / {{$totalMarks}}</h6>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <h4>3rd Term</h4>
                                                                <p><b>Total Quizzes: {{$thirdTermQuizzesMark}} / {{$course->total_quizzes}}</b></p>
                                                                <p><b>Total Exams: {{$thirdTermExamMark}} / {{$course->total_exams}}</b></p>
                                                                <h6>Grand Total: {{$totalStudentThirdTermMarks}} / {{$totalMarks}}</h6>
                                                            </div>
                                                        </div>
                                                       </div>
                                                       <div class="modal-footer">
                                                           <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                       </div>
                                                   </div>
                                                   </div>
                                               </div>
                                            @else
                                               <button disabled class="btn btn-info btn-sm">No Marks</button>
                                               <a href="{{route('addMark',[$course->id,$item->id])}}" class="btn btn-success btn-sm">Add Marks</a>
                                               <a href="" class="btn btn-primary btn-sm">Add Attendance</a>
                                            @endif
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