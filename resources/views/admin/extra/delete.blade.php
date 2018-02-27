@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::model($extra) !!}
<div class="form-group">
	{!! Form::label('Nombre*') !!}
	{!! Form::label($extra->nombre,null,['class'=>'form-control']) !!}
</div>
{!! Form::close() !!}
<div class="col-md-10"></div>
<div class="col-md-1">
	{!! Form::open(['route' => ['admin.extra.destroy',$extra->id],'method'=>'delete']) !!}
	{!! Form::submit('Borrar',['class'=>'btn btn-danger']) !!}
	{!! Form::close() !!}
</div>
@endsection