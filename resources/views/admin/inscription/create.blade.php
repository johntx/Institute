@extends('layouts.admin')
@section('content')
@include('alerts.alertclient')
{!! Form::open(['route' => 'admin.inscription.store','method'=>'post', 'id'=>'reinscribir']) !!}
@include('admin.inscription.forms.form')
{!! Form::submit('Registrar',['class'=>'btn btn-primary']) !!}

{!! Form::close() !!}
@endsection