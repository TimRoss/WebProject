@extends('app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Register</div>
                    <div class="panel-body">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif



                        <!--<form class="form-horizontal" role="form" method="POST" action="{{ url('/pages/editInfo/{id}') }}">



                            <div class="form-group">
                                <label class="col-md-4 control-label">C++</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="c" value="{{$student->c}}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Java</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="java" value="{{$student->java}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Python</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="python" value="{{$student->python}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Team Type</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="teamType" value="{{$student->teamStyle}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Requested Team Member 1</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="requestedTeamMember1" value="{{$student->requestedTeamMember1}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Requested Team Member 2</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="requestedTeamMember2" value="{{$student->requestedTeamMember2}}">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Register
                                    </button>
                                </div>
                            </div>
                        </form>-->
                            {!! Form::model($student, ['method' => 'PATCH', 'action' => ['studentController@update', $user->id] ]) !!}
                                <div class="form-group">
                                    {!! Form::label('c', 'C++:') !!}
                                    {!! Form::text('c', null, ['class' => 'form-control']) !!}
                                </div>
                            <div class="form-group">
                                {!! Form::label('java', 'Java:') !!}
                                {!! Form::text('java', null, ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('python', 'Python:') !!}
                                {!! Form::text('python', null, ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('teamStyle', 'Team Style:') !!}
                                {!! Form::select('teamStyle', array('competitive' => 'Competitive', 'social' => 'Social', 'dk' => "Don't Care"), ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('twoHundreds', 'Number of 200 level classes taken:') !!}
                                {!! Form::text('twoHundreds', null, ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('threeHundreds', 'Number of 300 level classes taken:') !!}
                                {!! Form::text('threeHundreds', null, ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('fourHundreds', 'Number of 400 level classes taken:') !!}
                                {!! Form::text('fourHundreds', null, ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::submit('Apply', ['class' => 'btn btn-primary form-control']) !!}
                            </div>
                            {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop