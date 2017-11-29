@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::model($teacher) !!}
<div class="form-group">
	{!! Form::label('CI') !!}
	{!! Form::label($teacher->ci,null,['class'=>'form-control']) !!}
</div>
<div class="form-group">
	{!! Form::label('CIEN') !!}
	{!! Form::label($teacher->user->user,null,['class'=>'form-control']) !!}
</div>
<div class="form-group">
	{!! Form::label('Nombre*') !!}
	{!! Form::label($teacher->nombrecompleto(),null,['class'=>'form-control']) !!}
</div>
<div class="form-group">
	{!! Form::label('Sucursal*') !!}
	{!! Form::label($teacher->office->nombre,null,['class'=>'form-control']) !!}
</div>
{!! Form::close() !!}
<div class="col-md-10"></div>
<div class="col-md-1">
	{!! Form::open(['route' => ['admin.teacher.destroy',$teacher->id],'method'=>'delete']) !!}
	{!! Form::submit('Borrar',['class'=>'btn btn-danger']) !!}
	{!! Form::close() !!}
</div>
@endsection