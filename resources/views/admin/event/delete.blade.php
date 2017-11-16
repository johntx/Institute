@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::model($event) !!}
<div class="form-group">
	{!! Form::label('Title*') !!}
	{!! Form::label($event->title,null,['class'=>'form-control']) !!}
</div>
<div class="form-group">
	{!! Form::label('Text') !!}
	{!! Form::label($event->text,null,['class'=>'form-control']) !!}
</div>
<div class="form-group">
	{!! Form::label('Init Date*') !!}
	{!! Form::label($event->date,null,['class'=>'form-control datepicker']) !!}
</div>
<div class="form-group">
	{!! Form::label('End Date*') !!}
	{!! Form::label($event->enddate,null,['class'=>'form-control datepicker']) !!}
</div>
<div class="form-group">
	{!! Form::label('Place') !!}
	{!! Form::label($event->place,null,['class'=>'form-control']) !!}
</div>
<div class="form-group">
	{!! Form::label('Photos: ') !!}
	@foreach($event->images as $image)
	<img src="{!!URL::to($image->photo)!!}" alt="" height="50px">
	@endforeach
</div>
<div class="form-group">
	{!! Form::label('Link') !!}
	{!! Form::label($event->link,null,['class'=>'form-control']) !!}
</div>
{!! Form::close() !!}
<div class="col-md-10"></div>
<div class="col-md-1">
	{!! Form::open(['route' => ['admin.event.destroy',$event->id],'method'=>'delete']) !!}
	{!! Form::submit('Borrar',['class'=>'btn btn-danger']) !!}
	{!! Form::close() !!}
</div>
@endsection