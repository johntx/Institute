@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::open(['route' => 'admin.role.store','method'=>'post']) !!}
@include('admin.role.forms.form')
<div class="col-md-12">
	{!! Form::submit('Registrar',['class'=>'btn btn-primary']) !!}
</div>

{!! Form::close() !!}
@endsection