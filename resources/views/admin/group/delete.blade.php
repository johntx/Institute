@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::model($group) !!}
<div class="form-group">
	{!! Form::label('turno') !!}
	{!! Form::label($group->turno,null,['class'=>'form-control']) !!}
</div>
<div class="form-group">
	{!! Form::label('Estado') !!}
	{!! Form::label($group->estado,null,['class'=>'form-control']) !!}
</div>
<div class="form-group">
	{!! Form::label('Fecha de Inicio') !!}
	{!! Form::label($group->startclass->fecha_inicio,null,['class'=>'form-control']) !!}
</div>
{!! Form::close() !!}
<div class="col-md-10"></div>
<div class="col-md-1">
	{!! Form::open(['route' => ['admin.group.destroy',$group->id],'method'=>'delete']) !!}
	{!! Form::submit('Borrar',['class'=>'btn btn-danger']) !!}
	{!! Form::close() !!}
</div>
@endsection