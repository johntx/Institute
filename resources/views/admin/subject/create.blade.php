@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::open(['route' => 'admin.subject.store','method'=>'post']) !!}
@include('admin.subject.forms.form')
{!! Form::submit('Registar',['class'=>'btn btn-primary']) !!}
{!! Form::close() !!}
@endsection