@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::open(['route' => 'admin.startclass.store','method'=>'post']) !!}
<div class="col-md-12" style="padding: 0;">
@include('admin.startclass.forms.form')
</div>
{!! Form::submit('Registar',['class'=>'btn btn-primary']) !!}
{!! Form::close() !!}
@endsection