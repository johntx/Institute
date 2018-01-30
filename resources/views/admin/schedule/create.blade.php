@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::open(['route' => 'admin.schedule.store','method'=>'post']) !!}
@include('admin.schedule.forms.form')
<div class="col-md-1">
	{!! Form::submit('Registar',['class'=>'btn btn-success']) !!}
	{!! Form::close() !!}
</div>
@endsection
@section('adminjs')
{!!Html::script('js/horario.js')!!}
@endsection