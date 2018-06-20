@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::model($classroom,['route' => ['admin.classroom.update',$classroom->id],'method'=>'put']) !!}
@include('admin.classroom.forms.form')
<div class="col-md-1">
	{!! Form::submit('Guardar',['class'=>'btn btn-primary']) !!}
	{!! Form::close() !!}
</div>
@endsection