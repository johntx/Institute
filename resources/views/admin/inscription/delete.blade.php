@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::model($student) !!}
<div class="form-group">
	{!! Form::label('CI') !!}
	{!! Form::label($student->ci,null,['class'=>'form-control']) !!}
</div>
<div class="form-group">
	{!! Form::label('CIEN') !!}
	{!! Form::label($student->user->user,null,['class'=>'form-control']) !!}
</div>
<div class="form-group">
	{!! Form::label('Nombre*') !!}
	{!! Form::label($student->nombrecompleto(),null,['class'=>'form-control']) !!}
</div>
<div class="form-group">
	{!! Form::label('Sucursal*') !!}
	{!! Form::label($student->office->nombre,null,['class'=>'form-control']) !!}
</div>
{!! Form::close() !!}
<div class="col-md-10"></div>
<div class="col-md-1">
	{!! Form::open(['route' => ['admin.student.destroy',$student->id],'method'=>'delete']) !!}
	{!! Form::submit('Borrar',['class'=>'btn btn-danger']) !!}
	{!! Form::close() !!}
</div>
@endsection