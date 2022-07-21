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
                    <li class="breadcrumb-item"><a href="{{route("getAllUsers")}}">Users</a></li>
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
                <h4>Create New User</h4>
                
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
                    <form action="{{route('saveNewUser')}}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Names</label>
                                    <input type="text" class="form-control" name="names" value="{{old('names')}}" placeholder="user names..." required>
                                </div>
                                <div class="form-group">
                                    <label>Username</label>
                                    <input type="text" class="form-control" name="username" value="{{old('username')}}" placeholder="username..." required>
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input id="example-email" class="form-control" name="password" type="password" placeholder="password..." required>
                                </div>
                                <div class="form-group">
                                    <label>Role</label>
                                    <select class="form-control" required name="role">
                                        <option selected disabled>Choose Role</option>
										@foreach (\App\Models\Role::get() as $item)
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
									</select>
                                </div>
                                <button type="submit" class="btn btn-primary">Create User</button>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection