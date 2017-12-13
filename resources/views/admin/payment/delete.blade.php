@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::model($payment) !!}
<div class="form-group">
	{!! Form::label('Cliente*') !!}
	{!! Form::label($payment->inscription->people->nombrecompleto(),null,['class'=>'form-control']) !!}
</div>
<div class="form-group">
	{!! Form::label('Fecha Pagar') !!}
	{!! Form::label($payment->fecha_pagar,null,['class'=>'form-control']) !!}
</div>
<div class="form-group">
	{!! Form::label('Pagó') !!}
	{!! Form::label($payment->fecha_pago,null,['class'=>'form-control']) !!}
</div>
<div class="form-group">
	{!! Form::label('Abono') !!}
	{!! Form::label($payment->abono,null,['class'=>'form-control']) !!}
</div>
<div class="form-group">
	{!! Form::label('Saldo') !!}
	{!! Form::label($payment->saldo,null,['class'=>'form-control']) !!}
</div>
<div class="form-group">
	{!! Form::label('Observacion') !!}
	{!! Form::label($payment->observacion,null,['class'=>'form-control']) !!}
</div>
<div class="form-group">
	{!! Form::label('Usuario') !!}
	{!! Form::label($payment->user_id,null,['class'=>'form-control']) !!}
</div>
{!! Form::close() !!}
<div class="col-md-10"></div>
<div class="col-md-1">
	{!! Form::open(['route' => ['admin.payment.destroy',$payment->id],'method'=>'delete']) !!}
	{!! Form::submit('Borrar',['class'=>'btn btn-danger']) !!}
	{!! Form::close() !!}
</div>
@endsection