@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::model($office,['route' => ['admin.office.update',$office->id],'method'=>'put']) !!}
@include('admin.office.forms.form')
<div class="col-md-1">
	{!! Form::submit('Guardar',['class'=>'btn btn-primary']) !!}
	{!! Form::close() !!}
</div>
@endsection