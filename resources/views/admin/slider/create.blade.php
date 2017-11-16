@extends('layouts.admin')
@section('content')
	@include('alerts.request')
	{!! Form::open(['route' => 'admin.slider.store','method'=>'post','files'=>true]) !!}
		@include('admin.slider.forms.sld')
		{!! Form::submit('Registrar',['class'=>'btn btn-primary']) !!}
	{!! Form::close() !!}
@endsection