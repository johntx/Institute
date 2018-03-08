@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::model($category) !!}
<div class="form-group">
	{!! Form::label('Code*') !!}
	{!! Form::label($category->code,null,['class'=>'form-control']) !!}
</div>
<div class="form-group">
	{!! Form::label('Nombre*') !!}
	{!! Form::label($category->nombre,null,['class'=>'form-control']) !!}
</div>
{!! Form::close() !!}
<div class="col-md-10"></div>
<div class="col-md-1">
	{!! Form::open(['route' => ['admin.category.destroy',$category->id],'method'=>'delete']) !!}
	{!! Form::submit('Borrar',['class'=>'btn btn-danger']) !!}
	{!! Form::close() !!}
</div>
@endsection