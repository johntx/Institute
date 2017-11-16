<div class="form-group">
	{!! Form::label('Name*') !!}
	{!! Form::text('name',null,['class'=>'form-control','placeholder'=>'Insert Name','required', 'maxlength'=>150]) !!}
</div>
<div class="form-group">
	{!! Form::label('Email*') !!}
	{!! Form::email('email',null,['class'=>'form-control','placeholder'=>'Insert Email','required', 'maxlength'=>100]) !!}
</div>
<div class="form-group">
	{!! Form::label('Phone*') !!}
	{!! Form::text('phone',null,['class'=>'form-control','placeholder'=>'Insert Phone','required', 'maxlength'=>30]) !!}
</div>
<div class="form-group">
	{!! Form::label('Text*') !!}
	{!! Form::text('text',null,['class'=>'form-control','placeholder'=>'Insert Text','required', 'maxlength'=>255]) !!}
</div>
<div class="form-group">
	{!! Form::label('Client*') !!}
	<select name="client_id" id="client_id" class="form-control">
		@foreach($clients as $client)
		<option value="none">--None--</option>
		<option value="{{$client->id}}">{{$client->people->firstname}} {{$client->people->lastname}}</option>
		@endforeach
	</select>	
</div>
