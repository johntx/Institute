@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::open(['route' => 'admin.income.store','method'=>'post','id'=>'ingresos']) !!}
@include('admin.income.forms.form')
{!! Form::submit('Registrar',['class'=>'btn btn-primary']) !!}
{!! Form::close() !!}
@endsection
@section('adminjs')
{!!Html::script('js/ventas.js')!!}
@endsection