@include('alerts.errors')
@include('alerts.request')

{!!Form::open(['route'=>'admin.client.store', 'method'=>'POST', 'class'=>'form'])!!}
	<div class="form-group">
		{!!Form::text('first_name',null,['class'=>'form-control', 'placeholder'=>'Insert your First Name*','required', 'maxlength'=>250])!!}
	</div>
	<div class="form-group">
		{!!Form::text('last_name',null,['class'=>'form-control', 'placeholder'=>'Insert your Last Name*','required', 'maxlength'=>250])!!}
	</div>
	<div class="form-group">
		{!!Form::email('email',null,['class'=>'form-control', 'placeholder'=>'Insert your Email*','required', 'maxlength'=>250])!!}
	</div>
	<div class="form-group">
		{!!Form::password('password',['class'=>'form-control', 'placeholder'=>'Insert your Password*','required', 'maxlength'=>250])!!}
	</div>
	<div class="form-group">
		{!!Form::text('phone',null,['class'=>'form-control', 'placeholder'=>'Insert your Phone', 'maxlength'=>25])!!}
	</div>
	<div class="form-group">
		{!!Form::text('address',null,['class'=>'form-control', 'placeholder'=>'Insert your Address', 'maxlength'=>250])!!}
	</div>
		{!!Form::text('client','client',['class'=>'form-control', 'placeholder'=>'Insert your Address','hidden'])!!}
	{!!Form::submit('Register',['class'=>'btn btn-primary'])!!}
{!!Form::close()!!}