@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::model($craft) !!}
<div class="form-group">
	{!! Form::label('Name*') !!}
	{!! Form::label($craft->name,null,['class'=>'form-control']) !!}
</div>
<div class="form-group">
	{!! Form::label('Description') !!}
	{!! Form::label($craft->description,null,['class'=>'form-control']) !!}
</div>
<div class="form-group">
	{!! Form::label('Link') !!}
	{!! Form::label($craft->link,null,['class'=>'form-control']) !!}
</div>
<div class="form-group">
	{!! Form::label('Photo: ') !!}
	<img src="{!!URL::to($craft->photo)!!}" alt="" height="50px">
</div>
{!! Form::close() !!}
<div class="col-md-10"></div>
<div class="col-md-1">
	{!! Form::open(['route' => ['admin.craft.destroy',$craft->id],'method'=>'delete']) !!}
	{!! Form::submit('Borrar',['class'=>'btn btn-danger']) !!}
	{!! Form::close() !!}
</div>
@endsection