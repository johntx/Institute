@include('alerts.errors')
@include('alerts.request')

{!!Form::open(['route'=>'log.store', 'method'=>'POST', 'class'=>'form'])!!}
	<div class="form-group">
		{!!Form::text('user',null,['class'=>'form-control', 'placeholder'=>'User', 'required', 'maxlength'=>100])!!}
	</div>
	<div class="form-group">
		{!!Form::password('password',['class'=>'form-control', 'placeholder'=>'Password', 'required', 'maxlength'=>60])!!}
	</div>
	{!!Form::submit('LogIn',['class'=>'btn btn-primary'])!!}
{!!Form::close()!!}