@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::open(['route' => 'admin.order.store','method'=>'post','id'=>'pedido']) !!}
@include('admin.order.forms.form')
{!! Form::submit('Registrar',['class'=>'btn btn-primary']) !!}
{!! Form::close() !!}
@endsection
@section('adminjs')
{!!Html::script('js/ventas.js')!!}
@endsection