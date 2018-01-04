@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::open(['route' => 'admin.student.store','method'=>'post', 'id'=>'inscribir']) !!}
@include('admin.student.forms.form')
{!! Form::submit('Registrar',['class'=>'btn btn-primary']) !!}

{!! Form::close() !!}
@endsection