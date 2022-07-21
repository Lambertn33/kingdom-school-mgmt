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
                    <li class="breadcrumb-item"><a href="{{route("getAllClasses")}}">Classes</a></li>
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
                <h4>Create New ClassRoom</h4>
                
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
                    <form action="{{route('saveNewClassRoom')}}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Room Code</label>
                                    <input type="text" class="form-control" name="room_code" value="{{old('room_code')}}" placeholder="room code..." required>
                                </div>
                                <button type="submit" class="btn btn-primary">Create ClassRoom</button>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection