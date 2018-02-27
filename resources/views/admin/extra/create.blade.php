@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::open(['route' => 'admin.extra.store','method'=>'post']) !!}
@include('admin.extra.forms.form')
{!! Form::submit('Registar',['class'=>'btn btn-primary']) !!}
{!! Form::close() !!}
@endsection