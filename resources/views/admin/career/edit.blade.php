@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::model($career,['route' => ['admin.career.update',$career->id],'method'=>'put']) !!}
@include('admin.career.forms.form')
<div class="col-md-1">
	{!! Form::submit('Guardar',['class'=>'btn btn-primary']) !!}
	{!! Form::close() !!}
</div>
@endsection