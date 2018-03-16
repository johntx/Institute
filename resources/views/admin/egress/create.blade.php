@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::open(['route' => 'admin.egress.store','method'=>'post']) !!}
@include('admin.egress.forms.form')
{!! Form::submit('Registar',['class'=>'btn btn-primary']) !!}
{!! Form::close() !!}
@endsection
@section('adminjs')
{!!Html::script('js/ventas.js')!!}
@endsection