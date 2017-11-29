@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::model($student,['route' => ['admin.student.update',$student->id],'method'=>'put']) !!}
@include('admin.student.forms.form')
<div class="col-md-1">
	{!! Form::submit('Guardar',['class'=>'btn btn-primary']) !!}
	{!! Form::close() !!}
</div>
@endsection