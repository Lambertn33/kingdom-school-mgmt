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
                    <li class="breadcrumb-item active">Users</li>
                </ol>
            </div>
        </div>
    </div>
    <!-- /# column -->
</div>
<!-- /# row -->
<div class="row">
    <div class="col-md-12">
        <a href="{{route('createNewUser')}}" style="float: right" class="btn btn-primary">Add New User</a>
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
                                    <th>Names</th>
                                    <th>Username</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $counter = 1; ?>
                                @foreach ($allUsers as $item)
                                <tr>
                                        <th>{{$counter}}</th>
                                        <?php $counter ++ ?>
                                       <td> {{$item->names}}</td>
                                       <td> {{$item->username}}</td>
                                       <td> {{$item->role->name}}</td>
                                       <td>
                                           @if ($item->is_active)
                                                <span class="badge badge-success">Active</span>
                                           @else
                                              <span class="badge badge-danger">Closed</span>
                                           @endif
                                       </td>
                                       <td>
                                           @if ($item->role->name != \App\Models\Role::ADMINISTRATOR)
                                           <a class="btn btn-info" href="{{route('editUser',$item->id)}}"><span style="color: #fff">Recover Password</span></a>
                                                @if ($item->is_active)
                                                  <a class="btn btn-danger" onclick="document.getElementById('form-update-account').submit();" href="#"><span style="color: #fff">Close Account</span></a>
                                                @else
                                                  <a class="btn btn-success" onclick="document.getElementById('form-update-account').submit();" href="#"><span style="color: #fff">Activate Account</span></a>
                                                @endif
                                                <form action="{{route('editUserAccount',$item->id)}}" id="form-update-account" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="_method" value="PUT">
                                                </form>
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