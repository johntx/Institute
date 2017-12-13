@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::open(['route' => 'admin.inscription.store','method'=>'post']) !!}
@include('admin.inscription.forms.form')
{!! Form::submit('Registrar',['class'=>'btn btn-primary']) !!}

{!! Form::close() !!}
@endsection