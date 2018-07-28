@extends('layouts.admin')
@section('content')
@include('alerts.pdf')
{!! Form::open(['route' => 'admin.income.store','method'=>'post']) !!}
@include('admin.income.forms.form')
{!! Form::submit('Registrar',['class'=>'btn btn-primary']) !!}
{!! Form::close() !!}
@endsection
@section('adminjs')
{!!Html::script('js/ventas.js')!!}
@endsection