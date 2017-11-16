@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::model($craft,['route' => ['admin.craft.update',$craft->id],'method'=>'put','files'=>true]) !!}
@include('admin.craft.forms.form')
<div class="col-md-1">
	{!! Form::submit('Guardar',['class'=>'btn btn-primary']) !!}
	{!! Form::close() !!}
</div>
@endsection