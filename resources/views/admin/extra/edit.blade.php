@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::model($extra,['route' => ['admin.extra.update',$extra->id],'method'=>'put']) !!}
@include('admin.extra.forms.form')
<div class="col-md-1">
	{!! Form::submit('Guardar',['class'=>'btn btn-primary']) !!}
	{!! Form::close() !!}
</div>
@endsection