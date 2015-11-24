@extends('layout.master')

@section('content')
<ul>
    <li>Student Name</li>
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
<div id="membersBox">
    <h2>Requested Team Members</h2>
    <br>
    <ul id="membersList"></ul>
</div>
<div id="otherBox">
    <span>Style: </span>
    <button href="pages/editInfo/{id}">Edit Profile</button>
</div>
@stop
