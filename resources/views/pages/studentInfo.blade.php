@extends('app')

@section('content')
    <div class="container">
        <div class="jumbotron">
            <h1>Student Info Page</h1>
            <ul>
                <li>Student Name</li>
                <li>Current Team</li>
                <li><img href=""></li>
            </ul>
        </div>
        <div class="row">
        <div id="classesBox" class="col-lg-4">
            <h2 class="text-center">Classes</h2>
            <br>
            <ul id="classesList"></ul>
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
                        <td>C++ strength</td>
                    </tr>
                    <tr>
                        <td>Java</td>
                        <td>Java strength</td>
                    </tr>
                    <tr>
                        <td>Python</td>
                        <td>Python Strength</td>
                    </tr>
                </table>
            </div>
        </div>
        <div id="membersBox" class="col-lg-4">
            <h2 class="text-center">Requested Team Members</h2>
            <br>
            <ul id="membersList"></ul>
        </div>
            </div>
        <div id="otherBox" class="col-lg-12">
            <span>Style: </span>
        </div>
        <br>
        <hr>
        <a href="pages/editInfo/{id}" class="btn btn-info" role="button">Edit Profile</a>
    </div>

@stop
