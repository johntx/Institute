@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::open(['route' => 'admin.payment.store','method'=>'post','files'=>true]) !!}
@include('admin.payment.forms.form')
{!! Form::close() !!}
@endsection