@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::model($schedule,['route' => ['admin.schedule.update',$schedule->id],'method'=>'put']) !!}
@include('admin.schedule.forms.edit')
<div class="col-md-1">
	{!! Form::submit('Guardar',['class'=>'btn btn-success']) !!}
	{!! Form::close() !!}
</div>
@endsection
@section('adminjs')
    {!!Html::script('js/horario.js')!!}
@endsection