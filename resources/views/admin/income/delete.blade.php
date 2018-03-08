@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::model($income) !!}

<div class="form-group">
	{!! Form::label('Usuario') !!}
	{!! Form::label('nombre',$income->user->user,['class'=>'form-control','placeholder'=>'Insert NIT', 'maxlength'=>30]) !!}
</div>
<div class="form-group">
	{!! Form::label('Fecha compra') !!}
	{!! Form::label('fecha_compra',Jenssegers\Date\Date::parse($income->fecha_compra)->format('j M Y'),['class'=>'form-control','placeholder'=>'Fecha', 'maxlength'=>30]) !!}
</div>
{!! Form::close() !!}
<div class="col-md-10"></div>
<div class="col-md-1">
	{!! Form::open(['route' => ['admin.income.destroy',$income->id],'method'=>'delete']) !!}
	{!! Form::submit('Eliminar',['class'=>'btn btn-danger']) !!}
	{!! Form::close() !!}
</div>
@endsection