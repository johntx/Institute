@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::model($test,['route' => ['admin.test.update',$career->id],'method'=>'put']) !!}
@include('admin.test.forms.form')
<div class="col-md-1">
	{!! Form::submit('Guardar',['class'=>'btn btn-primary']) !!}
</div>
{!! Form::close() !!}
@endsection