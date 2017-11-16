@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::model($role,['route' => ['admin.role.update',$role->id],'method'=>'put']) !!}
@include('admin.role.forms.form')
<div class="col-md-1">
	{!! Form::submit('Guardar',['class'=>'btn btn-primary']) !!}
	{!! Form::close() !!}
</div>
@endsection