@extends('layout.master')

@section('content')
<ul>
    <li>{{$user->name}}</li>
    <li>Current Team</li>
    <li><img href=""></li>
</ul>
<hr>
<div id="classesBox">
    <h2>Classes</h2>
    <br>
    <ul id="classesList"></ul>
</div>
<div id="languagesBox">
    <h2>Language Strength</h2>
    <br>
    <table>
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
<div id="membersBox">
    <h2>Requested Team Members</h2>
    <br>
    <ul id="membersList">
        <li>{{$student->requestedTeamMember1}}</li>
        <li>{{$student->requestedTeamMember2}}</li>
    </ul>
</div>
<div id="otherBox">
    <span>Style: {{$student->teamStyle}}</span>
    <button href="pages/editInfo/{id}">Edit Profile</button>
</div>
@stop
