<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="/dashboardAssets/assets/css/lib/bootstrap.min.css" rel="stylesheet">
    <title>{{$student->names}} Report</title>
</head>
<style>
    .container {
        border: 1px solid gray;
        padding: 2rem 0;
        margin-top: 2rem;
    }

    .logo {
        border-radius: 50%;
        width:40%;
    }
    .header-span {
        font-size: 20px;
        font-weight: 700;
    }
    .table-row {
        margin-top: 2rem;
    }
</style>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <div class="row">
                    <div class="col-md-2">
                        <img src="{{url('/Logo.jpeg')}}" class="logo" alt="Image"/>
                    </div>
                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-md-3">
                                <span class="header-span">
                                    Term: {{$trimester}}
                                </span>
                            </div>
                            <div class="col-md-3">
                                <span class="header-span">
                                    Class: {{$classRoom->room_code}}
                                </span>
                            </div>
                            <div class="col-md-3">
                                <span class="header-span">
                                    Position: .......
                                </span>
                            </div>
                            <div class="col-md-3">
                                <span class="header-span">
                                    Out of: {{$numberOfStudents}} Students
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row table-row" >
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
                <br>
                <div class="row">
                    <div class="col-md-12">
                        Conduct: ...............
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        Class Teacher's comment and Sign: ...............
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        Head Teacher's comment and sign: ...............
                    </div>
                </div>
                <br>
            </div>
        </div>
    </div>
</body>
<script src="/dashboardAssets/assets/js/lib/bootstrap.min.js"></script>
<script src="/dashboardAssets/assets/js/scripts.js"></script>
</html>