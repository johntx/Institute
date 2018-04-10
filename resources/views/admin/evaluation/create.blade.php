@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::open(['route' => 'admin.evaluation.store','method'=>'post']) !!}
@include('admin.evaluation.forms.form')
{!! Form::submit('Registar',['class'=>'btn btn-primary']) !!}
{!! Form::close() !!}
@endsection
@section('adminjs')
{!!Html::script('js/ventas.js')!!}
@endsection