@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::model($teacher,['route' => ['admin.teacher.update',$teacher->id],'method'=>'put']) !!}
@include('admin.teacher.forms.form')
<div class="col-md-1">
	{!! Form::submit('Guardar',['class'=>'btn btn-primary']) !!}
	{!! Form::close() !!}
</div>
@endsection