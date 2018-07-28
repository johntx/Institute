@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::model($test) !!}
<div class="form-group">
	{!! Form::label('Nombre*') !!}
	{!! Form::label($test->nombre,null,['class'=>'form-control']) !!}
</div>
{!! Form::close() !!}
<div class="col-md-10"></div>
<div class="col-md-1">
	{!! Form::open(['route' => ['admin.test.destroy',$test->id],'method'=>'delete']) !!}
	{!! Form::submit('Borrar',['class'=>'btn btn-danger']) !!}
	{!! Form::close() !!}
</div>
@endsection