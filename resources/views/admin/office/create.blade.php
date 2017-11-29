@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::open(['route' => 'admin.office.store','method'=>'post']) !!}
@include('admin.office.forms.form')
{!! Form::submit('Registar',['class'=>'btn btn-primary']) !!}
{!! Form::close() !!}
@endsection