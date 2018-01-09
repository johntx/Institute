@extends('layouts.admin')
@section('content')
@include('alerts.alertclient')
{!! Form::open(['route' => 'admin.payment.store','method'=>'post','files'=>true, 'id'=>'paymentForm']) !!}
@include('admin.payment.forms.form')
{!! Form::close() !!}
@endsection