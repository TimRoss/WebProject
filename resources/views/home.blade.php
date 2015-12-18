@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Home</div>

				<div class="panel-body">
					You are logged in!
				</div>
				<a href="pages/studentInfo/{{auth()->user()->id}}" class="btn btn-info" role="button">Student Info</a>
				<a href="admin/teamInfo" class="btn btn-info" role="button">Team Info</a>
			</div>
		</div>
	</div>
</div>
@endsection