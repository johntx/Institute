@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::model($item) !!}
<div class="form-group">
	{!! Form::label('Nombre*') !!}
	{!! Form::label($item->nombre,null,['class'=>'form-control']) !!}
</div>
<div class="form-group">
	{!! Form::label('Detalles*') !!}
	{!! Form::label($item->detalle,null,['class'=>'form-control']) !!}
</div>
<div class="form-group">
	{!! Form::label('Hojas*') !!}
	{!! Form::label($item->hojas,null,['class'=>'form-control']) !!}
</div>
<div class="form-group">
	{!! Form::label('Precio*') !!}
	{!! Form::label($item->precio,null,['class'=>'form-control']) !!}
</div>
<div class="form-group">
	{!! Form::label('Stock*') !!}
	{!! Form::label($item->stock,null,['class'=>'form-control']) !!}
</div>
{!! Form::close() !!}
<div class="col-md-10"></div>
<div class="col-md-1">
	{!! Form::open(['route' => ['admin.item.destroy',$item->id],'method'=>'delete']) !!}
	{!! Form::submit('Borrar',['class'=>'btn btn-danger']) !!}
	{!! Form::close() !!}
	</div>
@endsection