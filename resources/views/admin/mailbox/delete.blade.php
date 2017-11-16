@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::model($mailbox) !!}
<div class="form-group">
	{!! Form::label('Name*') !!}
	{!! Form::label($mailbox->name,null,['class'=>'form-control']) !!}
</div>
<div class="form-group">
	{!! Form::label('Email*') !!}
	{!! Form::label($mailbox->email,null,['class'=>'form-control']) !!}
</div>
<div class="form-group">
	{!! Form::label('Phone*') !!}
	{!! Form::label($mailbox->phone,null,['class'=>'form-control']) !!}
</div>
<div class="form-group">
	{!! Form::label('Text*') !!}
	{!! Form::label($mailbox->text,null,['class'=>'form-control']) !!}
</div>
<div class="form-group">
	{!! Form::label('Client*') !!}
	<select name="client_id" id="client_id" class="form-control" disabled>
		@foreach($clients as $client)
		<option value="{{$client->user_id}}">{{$client->firstname}} {{$client->lastname}}</option>
		@endforeach
	</select>	
</div>

{!! Form::close() !!}
<div class="col-md-10"></div>
<div class="col-md-1">
	{!! Form::open(['route' => ['admin.mailbox.destroy',$mailbox->id],'method'=>'delete']) !!}
	{!! Form::submit('Borrar',['class'=>'btn btn-danger']) !!}
	{!! Form::close() !!}
</div>
@endsection