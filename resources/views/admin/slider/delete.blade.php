@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::model($slider) !!}
<div class="form-group">
	{!! Form::label('Title*') !!}
	{!! Form::label($slider->title,null,['class'=>'form-control']) !!}
</div>
<div class="form-group">
	{!! Form::label('Text') !!}
	{!! Form::label($slider->text,null,['class'=>'form-control']) !!}
</div>
<div class="form-group">
	{!! Form::label('Image: ') !!}
	<img src="{!!URL::to($slider->photo)!!}" alt="" height="50px">
</div>
{!! Form::close() !!}
<div class="col-md-10"></div>
<div class="col-md-1">
	{!! Form::open(['route' => ['admin.slider.destroy',$slider->id],'method'=>'delete']) !!}
	{!! Form::submit('Borrar',['class'=>'btn btn-danger']) !!}
	{!! Form::close() !!}
</div>
@endsection