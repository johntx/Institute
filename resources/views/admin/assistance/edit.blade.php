@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::model($student,['route' => ['admin.student.update',$student->id],'method'=>'put']) !!}
@include('admin.student.forms.edit')

	{!! Form::submit('Guardar',['class'=>'btn btn-primary']) !!}
	{!! Form::close() !!}

@endsection