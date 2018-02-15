@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::model($schedule) !!}
<div class="form-group">
	{!! Form::label('Id') !!}
	{!! Form::label($schedule->id,null,['class'=>'form-control']) !!}
</div>
<div class="form-group">
	{!! Form::label('Descripción') !!}
	{!! Form::label($schedule->descripcion,null,['class'=>'form-control']) !!}
</div>
<div class="form-group">
	{!! Form::label('Vigente') !!}
	{!! Form::label($schedule->vigente,null,['class'=>'form-control']) !!}
</div>

{!! Form::close() !!}
<div class="col-md-10"></div>
<div class="col-md-1">
	{!! Form::open(['route' => ['admin.schedule.destroy',$schedule->id],'method'=>'delete']) !!}
	{!! Form::submit('Borrar',['class'=>'btn btn-danger']) !!}
	{!! Form::close() !!}
</div>
@endsection