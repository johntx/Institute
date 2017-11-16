@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::model($testimonial,['route' => ['admin.testimonial.update',$testimonial->id],'method'=>'put']) !!}
@include('admin.testimonial.forms.form')
<div class="col-md-1">
	{!! Form::submit('Guardar',['class'=>'btn btn-primary']) !!}
	{!! Form::close() !!}
</div>
@endsection