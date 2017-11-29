@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::open(['route' => 'admin.career.store','method'=>'post']) !!}
@include('admin.career.forms.form')
{!! Form::submit('Registar',['class'=>'btn btn-primary']) !!}
{!! Form::close() !!}
@endsection