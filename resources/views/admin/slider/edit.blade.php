@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::model($slider,['route' => ['admin.slider.update',$slider->id],'method'=>'put','files'=>true]) !!}
@include('admin.slider.forms.sld')
<div class="col-md-1">
	{!! Form::submit('Guardar',['class'=>'btn btn-primary']) !!}
	{!! Form::close() !!}
</div>
@endsection