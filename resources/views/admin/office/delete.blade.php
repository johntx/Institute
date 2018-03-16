@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::model($office) !!}
<div class="form-group">
	{!! Form::label('nombre*') !!}
	{!! Form::label($office->nombre,$office->nombre,['class'=>'form-control']) !!}
</div>
<div class="form-group">
	{!! Form::label('direccion*') !!}
	{!! Form::label($office->direccion,$office->direccion,['class'=>'form-control']) !!}
</div>
{!! Form::close() !!}
<div class="col-md-10"></div>
<div class="col-md-1">
	{!! Form::open(['route' => ['admin.office.destroy',$office->id],'method'=>'delete']) !!}
	{!! Form::submit('Borrar',['class'=>'btn btn-danger']) !!}
	{!! Form::close() !!}
</div>
@endsection