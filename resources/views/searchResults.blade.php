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
                                    <th>Classroom</th>
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
                                       <td> {{$item->classroom->room_code}}</td>
                                       <td> 
                                        <button  data-toggle="modal" data-target="#{{$item->id}}" class="btn btn-success btn-sm">View Marks</button>
                                       </td>
                                    </tr>
                                    <div class="modal fade" id="{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">ViewMarks for {{$item->names}}</h5>
                                            </div>
                                            <form action="{{route('viewMarks',[$item->classroom->id,$item->id])}}" method="GET">
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