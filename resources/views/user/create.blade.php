@extends('layouts.admin')
@section('content')
	@include('alerts.request')
	{!! Form::open(['route' => 'user.store','method'=>'post']) !!}
		@include('user.forms.usr')
		{!! Form::submit('Register',['class'=>'btn btn-primary']) !!}
	{!! Form::close() !!}
@endsection