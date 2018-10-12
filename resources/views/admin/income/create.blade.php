@extends('layouts.admin')
@section('content')
@include('alerts.pdf')
<br>
@foreach ($careers as $car)
<a href="{{url('admin/income/create/career/'.$car->nombre)}}" class="btn" style="background-color: {{$car->color}}; color: {{$car->texto}}; @if ($career->nombre==$car->nombre) font-weight:bold; border: 2px solid black !important; -webkit-box-shadow: 1px 2px 14px -2px rgba(0,0,0,0.75);-moz-box-shadow: 1px 2px 14px -2px rgba(0,0,0,0.75);box-shadow: 1px 2px 14px -2px rgba(0,0,0,0.75); @endif">{{$car->nombre}}</a>
@endforeach
<br>
{!! Form::open(['route' => 'admin.income.store','method'=>'post']) !!}
@include('admin.income.forms.form')
{!! Form::submit('Registrar',['class'=>'btn btn-primary']) !!}
{!! Form::close() !!}
@endsection
@section('adminjs')
{!!Html::script('js/ventas.js')!!}
@endsection