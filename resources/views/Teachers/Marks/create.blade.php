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
                    <li class="breadcrumb-item"><a href="{{route('teacherViewStudents',[$course->id,$classRoom->id])}}"> {{$course->name}} course in {{$classRoom->room_code}}</a></li>
                    <li class="breadcrumb-item active"> {{$student->names}} marks</li>
                </ol>
            </div>
        </div>
    </div>
    <!-- /# column -->
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-title">
                <h4>Add Marks to {{$student->names}}</h4>
                
            </div>
            <div class="card-body">
                <div class="basic-elements">
                    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                                @if(Session::has($msg))
                                <div class="alert alert-{{ $msg }} alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    {{ Session::get($msg) }}
                                </div>
                                @endif
                            @endforeach
                    <form action="{{route('saveMark',[$course->id,$student->id])}}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Course Name</label>
                                    <input type="text" readonly class="form-control" value="{{$course->name}}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Class</label>
                                    <input type="text" class="form-control" readonly value="{{$classRoom->room_code}}">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Trimester</label>
                                    <select class="form-control" required name="trimester">
                                        <option selected disabled>Choose Trimester</option>
										@foreach (\App\Models\Mark::Trimester as $item)
                                            <option value="{{$item}}">{{$item}}</option>
                                        @endforeach
									</select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Total Quizzes Marks</label>
                                    <input type="number" placeholder="quizzes marks.. /{{$course->total_quizzes}}" value="{{old('total_quizzes')}}" class="form-control" name="total_quizzes">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Total Exam Marks</label>
                                    <input type="number" placeholder="total marks.. /{{$course->total_exams}}" value="{{old('total_exams')}}" class="form-control" name="total_exams">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Marks</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection