@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::model($schedule,['route' => ['admin.schedule.update',$schedule->id],'method'=>'put']) !!}
@include('admin.schedule.forms.edit2')
{!! Form::close() !!}
@endsection
@section('adminjs')
{!!Html::script('js/horario.js')!!}
{!!Html::script('js/touch.js')!!}
@endsection