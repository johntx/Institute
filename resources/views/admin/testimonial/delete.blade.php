@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::model($testimonial) !!}
<div class="form-group">
	{!! Form::label('Name*') !!}
	{!! Form::label($testimonial->name,null,['class'=>'form-control']) !!}
</div>
<div class="form-group">
	{!! Form::label('Business*') !!}
	{!! Form::label($testimonial->business,null,['class'=>'form-control']) !!}
</div>
<div class="form-group">
	{!! Form::label('Text*') !!}
	{!! Form::label($testimonial->text,null,['class'=>'form-control']) !!}
</div>
{!! Form::close() !!}
<div class="col-md-10"></div>
<div class="col-md-1">
	{!! Form::open(['route' => ['admin.testimonial.destroy',$testimonial->id],'method'=>'delete']) !!}
	{!! Form::submit('Borrar',['class'=>'btn btn-danger']) !!}
	{!! Form::close() !!}
</div>
@endsection