@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::open(['route' => 'admin.employee.store','method'=>'post']) !!}
@include('admin.employee.forms.form')
{!! Form::submit('Registrar',['class'=>'btn btn-primary']) !!}
{!! Form::close() !!}
@endsection