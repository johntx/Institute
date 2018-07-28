@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::model($interested,['route' => ['admin.interested.update',$interested->id],'method'=>'put']) !!}
@include('admin.interested.forms.edit')
<div class="col-md-1">
	{!! Form::submit('Guardar',['class'=>'btn btn-primary']) !!}
	{!! Form::close() !!}
</div>
@endsection