@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::model($system,['route' => ['admin.system.update',$system->id],'method'=>'put']) !!}
@include('admin.system.forms.form')
<div class="col-md-1">
	{!! Form::submit('Guardar',['class'=>'btn btn-primary']) !!}
	{!! Form::close() !!}
</div>
@endsection