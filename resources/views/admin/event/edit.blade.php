@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::model($event,['route' => ['admin.event.update',$event->id],'method'=>'put','files'=>true]) !!}
@include('admin.event.forms.form')
<div class="col-md-1">
	{!! Form::submit('Guardar',['class'=>'btn btn-primary']) !!}
	{!! Form::close() !!}
</div>
@endsection