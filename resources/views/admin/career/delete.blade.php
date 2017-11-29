@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::model($career) !!}
<div class="form-group">
	{!! Form::label('Nombre*') !!}
	{!! Form::label($career->nombre,null,['class'=>'form-control']) !!}
</div>
<div class="form-group">
	{!! Form::label('Duracion*') !!}
	{!! Form::label($career->duracion,null,['class'=>'form-control']) !!}
</div>
<div class="form-group">
	{!! Form::label('Sucursal*') !!}
	{!! Form::select('office_id', $offices, null, ['class'=>'form-control','disabled']) !!}
</div>
{!! Form::close() !!}
<div class="col-md-10"></div>
<div class="col-md-1">
	{!! Form::open(['route' => ['admin.career.destroy',$career->id],'method'=>'delete']) !!}
	{!! Form::submit('Borrar',['class'=>'btn btn-danger']) !!}
	{!! Form::close() !!}
</div>
@endsection