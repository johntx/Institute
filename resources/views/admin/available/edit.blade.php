@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::model($available,['route' => ['admin.available.update',$available->id],'method'=>'put']) !!}
@include('admin.available.forms.form')
<div class="col-md-1">
	{!! Form::submit('Guardar',['class'=>'btn btn-primary']) !!}
	{!! Form::close() !!}
</div>
@endsection