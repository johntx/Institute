@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::model($startclass) !!}
<div class="form-group">
	{!! Form::label('Fecha de Inicio') !!}
	{!! Form::label($startclass->fecha_inicio,null,['class'=>'form-control']) !!}
</div>
<div class="form-group">
	{!! Form::label('Carrera') !!}
	{!! Form::label($startclass->career->nombre,null,['class'=>'form-control']) !!}
</div>
<div class="form-group">
	{!! Form::label('Estado') !!}
	{!! Form::label($startclass->estado,null,['class'=>'form-control']) !!}
</div>
{!! Form::close() !!}
<div class="col-md-10"></div>
<div class="col-md-1">
	{!! Form::open(['route' => ['admin.startclass.destroy',$startclass->id],'method'=>'delete']) !!}
	{!! Form::submit('Borrar',['class'=>'btn btn-danger']) !!}
	{!! Form::close() !!}
</div>
@endsection