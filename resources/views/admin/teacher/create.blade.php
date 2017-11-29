@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::open(['route' => 'admin.teacher.store','method'=>'post']) !!}
@include('admin.teacher.forms.form')
{!! Form::submit('Registrar',['class'=>'btn btn-primary']) !!}
{!! Form::close() !!}
@endsection