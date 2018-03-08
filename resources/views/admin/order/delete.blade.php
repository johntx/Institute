@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::model($order) !!}

<div class="form-group">
	{!! Form::label('Cliente') !!}
	{!! Form::label('nombre',$order->nombre,['class'=>'form-control','placeholder'=>'Insert NIT', 'maxlength'=>30]) !!}
</div>
<div class="form-group">
	{!! Form::label('Subtotal') !!}
	{!! Form::label('subtotal',$order->subtotal,['class'=>'form-control','placeholder'=>'Insert Total', 'maxlength'=>30]) !!}
</div>
<div class="form-group">
	{!! Form::label('Total') !!}
	{!! Form::label('total',$order->total,['class'=>'form-control','placeholder'=>'Insert Total', 'maxlength'=>30]) !!}
</div>
<div class="form-group">
	{!! Form::label('Fecha compra') !!}
	{!! Form::label('fecha_compra',Jenssegers\Date\Date::parse($order->fecha_compra)->format('j M Y'),['class'=>'form-control','placeholder'=>'Fecha', 'maxlength'=>30]) !!}
</div>
{!! Form::close() !!}
<div class="col-md-10"></div>
<div class="col-md-1">
	{!! Form::open(['route' => ['admin.order.destroy',$order->id],'method'=>'delete']) !!}
	{!! Form::submit('Eliminar',['class'=>'btn btn-danger']) !!}
	{!! Form::close() !!}
</div>
@endsection