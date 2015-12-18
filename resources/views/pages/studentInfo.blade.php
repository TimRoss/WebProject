@extends('app')

@section('content')
    <div class="container">
        <div class="jumbotron">
            <h1>Student Info Page</h1>
            <ul>
                <li>{{$user->name}}</li>
                @if(!$team == NULL)
                <li>{{$team[0]->name}}</li>
                @else
                <li>No team assigned!</li>
                @endif
            </ul>
        </div>
        <div class="row">
            <div id="classesBox" class="col-lg-4">
                <h2 class="text-center">Classes</h2>
                <br>
                <ul id="classesList">
                    <li>200's: {{$student->twoHundreds}}</li>
                    <li>300's: {{$student->threeHundreds}}</li>
                    <li>400's: {{$student->fourHundreds}}</li>
                </ul>
            </div>
            <div id="languagesBox" class="col-lg-4">
                <h2 class="text-center">Language Strength</h2>
                <br>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Language</th>
                            <th>Strength</th>
                        </tr>
                        </thead>
                        <tr>
                            <td>C++</td>
                            <td>{{$student->c}}</td>
                        </tr>
                        <tr>
                            <td>Java</td>
                            <td>{{$student->java}}</td>
                        </tr>
                        <tr>
                            <td>Python</td>
                            <td>{{$student->python}}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div id="otherBox" class="col-lg-12">
                <span><b>Style:</b> {{ $student->teamStyle }}</span>
            </div>
            <br>

            <div class="col-lg-12">
                <hr>
                <a href="pages/editInfo/{{$student->id}}" class="btn btn-info" role="button">Edit Profile</a>
            </div>
        </div>
    </div>

@stop
