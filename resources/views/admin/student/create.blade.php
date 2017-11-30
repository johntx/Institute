@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::open(['route' => 'admin.student.store','method'=>'post']) !!}
@include('admin.student.forms.form')
<div class="col-md-12 ">
{!! Form::submit('Registrar',['class'=>'btn btn-primary']) !!}
</div>
{!! Form::close() !!}
@endsection