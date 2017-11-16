@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::model($system) !!}
<div class="form-group">
	{!! Form::label('Code*') !!}
	{!! Form::label($system->code,null,['class'=>'form-control']) !!}
</div>
<div class="form-group">
	{!! Form::label('Name*') !!}
	{!! Form::label($system->name,null,['class'=>'form-control']) !!}
</div>
{!! Form::close() !!}
<div class="col-md-10"></div>
<div class="col-md-1">
	{!! Form::open(['route' => ['admin.system.destroy',$system->id],'method'=>'delete']) !!}
	{!! Form::submit('Borrar',['class'=>'btn btn-danger']) !!}
	{!! Form::close() !!}
</div>
@endsection