@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::model($employee) !!}
<div class="form-group">
	{!! Form::label('CI') !!}
	{!! Form::label($employee->ci,null,['class'=>'form-control']) !!}
</div>
<div class="form-group">
	{!! Form::label('CIEN') !!}
	{!! Form::label($employee->user->user,null,['class'=>'form-control']) !!}
</div>
<div class="form-group">
	{!! Form::label('Nombre*') !!}
	{!! Form::label($employee->nombrecompleto(),null,['class'=>'form-control']) !!}
</div>
<div class="form-group">
	{!! Form::label('Sucursal*') !!}
	{!! Form::label($employee->office->nombre,null,['class'=>'form-control']) !!}
</div>
{!! Form::close() !!}
<div class="col-md-10"></div>
<div class="col-md-1">
	{!! Form::open(['route' => ['admin.employee.destroy',$employee->id],'method'=>'delete']) !!}
	{!! Form::submit('Borrar',['class'=>'btn btn-danger']) !!}
	{!! Form::close() !!}
</div>
@endsection