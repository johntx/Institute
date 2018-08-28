@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::model($exam) !!}
<div class="form-group">
	{!! Form::label('Nombre*') !!}
	{!! Form::label($exam->nombre,null,['class'=>'form-control']) !!}
</div>
{!! Form::close() !!}
<div class="col-md-10"></div>
<div class="col-md-1">
	{!! Form::open(['route' => ['admin.exam.destroy',$exam->id],'method'=>'delete']) !!}
	{!! Form::submit('Borrar',['class'=>'btn btn-danger']) !!}
	{!! Form::close() !!}
</div>
@endsection