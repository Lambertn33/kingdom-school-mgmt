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
                    <li class="breadcrumb-item"><a href="{{route("viewStudents",$classRoom->id)}}">{{$classRoom->room_code}} Courses</a></li>
                    <li class="breadcrumb-item active">Create</li>
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
                <h4>Create New Courses in {{$classRoom->room_code}}</h4>
                
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
                    <form action="{{route('saveCourse',$classRoom->id)}}" method="POST">
                        @csrf
                        <div class="row course-form">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Course</label>
                                    <select name="courses[]" class="form-control" required>
                                        <option value="">Select Course..</option>
                                        @foreach ($courses as $course)
                                            <option value="{{$course->id}}">{{$course->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Teacher</label>
                                    <select name="teachers[]" class="form-control" required>
                                        <option value="">Select Teacher..</option>
                                        @foreach ($teachers as $teacher)
                                            <option value="{{$teacher->id}}">{{$teacher->user->names}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Day</label>
                                            <select name="days[]" class="form-control" required>
                                                <option value="">Select Day..</option>
                                                @foreach (\App\Models\Class_Course::Days as $day)
                                                    <option value="{{$day}}">{{$day}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>From</label>
                                            <input type="time" class="form-control" name="from[]">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>To</label>
                                            <input type="time" class="form-control" name="to[]">
                                        </div>
                                    </div>
                                </div>
                                <button type="button" id="course-addition" class="btn btn-success">Add more</button>
                            </div>
                            
                        </div>
                        <br>
                        <hr>
                        <button type="submit" class="btn btn-primary">Create Course</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
    $(document).ready(function(){
      $('#course-addition').on('click',function(){
          $('.course-form').append(`
            <div class="col-lg-6">
                <div class="form-group">
                    <label>Course</label>
                    <select name="courses[]" class="form-control" required>
                        <option value="">Select Course..</option>
                        @foreach ($courses as $course)
                            <option value="{{$course->id}}">{{$course->name}}</option>
                         @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Teacher</label>
                    <select name="teachers[]" class="form-control" required>
                        <option value="">Select Teacher..</option>
                        @foreach ($teachers as $teacher)
                            <option value="{{$teacher->id}}">{{$teacher->user->names}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Day</label>
                                            <select name="days[]" class="form-control" required>
                                                <option value="">Select Day..</option>
                                                @foreach (\App\Models\Class_Course::Days as $day)
                                                    <option value="{{$day}}">{{$day}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>From</label>
                                            <input type="time" class="form-control" name="from[]">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>To</label>
                                            <input type="time" class="form-control" name="to[]">
                                        </div>
                                    </div>
                                </div>
                <button type="button" class="btn btn-danger course-removal">Remove</button>
            </div>
          `)
      }) 
    });
    $(document).on('click','.course-removal',function(){
        $(this).parent().remove()
    })
</script>