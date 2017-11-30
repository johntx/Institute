@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::open(['route' => 'admin.startclass.store','method'=>'post']) !!}
@include('admin.startclass.forms.form')
<div class="col-md-12 ">
{!! Form::submit('Registar',['class'=>'btn btn-primary']) !!}
</div>
{!! Form::close() !!}
@endsection