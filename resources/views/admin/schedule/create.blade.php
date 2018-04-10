@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::open(['route' => 'admin.schedule.store','method'=>'post']) !!}
@include('admin.schedule.forms.form')
{!! Form::close() !!}
@endsection
@section('adminjs')
{!!Html::script('js/horario.js')!!}
{!!Html::script('js/touch.js')!!}
@endsection