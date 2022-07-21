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
                    <li class="breadcrumb-item active"> Search Results</li>
                </ol>
            </div>
        </div>
    </div>
    <!-- /# column -->
</div>  
<section id="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="bootstrap-data-table-panel">
                    <div class="table-responsive">
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
                                @foreach ($searchResults as $item)
                                <tr>
                                        <th>{{$counter}}</th>
                                        <?php $counter ++ ?>
                                       <td> {{$item->names}}</td>
                                       <td> {{$item->gender}}</td>
                                       <td> {{$item->student_no}}</td>
                                       <td> 
                                           <a href="" class="btn btn-success btn-sm">View Marks</a>
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
    </div>s
</section>
@endsection