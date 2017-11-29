@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::model($subject) !!}
<div class="form-group">
	{!! Form::label('Nombre*') !!}
	{!! Form::label($subject->nombre,null,['class'=>'form-control']) !!}
</div>
{!! Form::close() !!}
<div class="col-md-10"></div>
<div class="col-md-1">
	{!! Form::open(['route' => ['admin.subject.destroy',$subject->id],'method'=>'delete']) !!}
	{!! Form::submit('Borrar',['class'=>'btn btn-danger']) !!}
	{!! Form::close() !!}
</div>
@endsection