@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::model($functionality,['route' => ['admin.functionality.update',$functionality->id],'method'=>'put']) !!}
@include('admin.functionality.forms.form')
<div class="col-md-1">
	{!! Form::submit('Guardar',['class'=>'btn btn-primary']) !!}
	{!! Form::close() !!}
</div>
@endsection