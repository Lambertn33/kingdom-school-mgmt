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
                    <li class="breadcrumb-item"><a href="{{route("getAllClasses")}}">Class Rooms</a></li>
                    <li class="breadcrumb-item active"> {{$classRoom->room_code}} Courses</li>
                </ol>
            </div>
        </div>
    </div>
    <!-- /# column -->
</div>
<!-- /# row -->
<div class="row">
    <div class="col-md-12">
        <a href="{{route('addCourse',$classRoom->id)}}" style="float: right" class="btn btn-primary">Add New Course in  {{$classRoom->room_code}}</a>
    </div>
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
                                    <th>Course Name</th>
                                    <th>Course Code</th>
                                    <th>Course Teacher</th>
                                    <th>Day</th>
                                    <th>From</th>
                                    <th>To</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $counter = 1; ?>
                                @foreach ($courses as $item)
                                <tr>
                                        <th>{{$counter}}</th>
                                        <?php $counter ++ ?>
                                       <td> {{$item->name}}</td>
                                       <td> {{$item->code}}</td>
                                       <td> {{$item->teacherName()}}</td>
                                       <td> {{$item->pivot->day}}</td>
                                       <td> {{$item->pivot->from}}</td>
                                       <td> {{$item->pivot->to}}</td>
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