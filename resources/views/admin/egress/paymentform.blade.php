@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::open(['url' => ['admin/egress/savepayment'],'method'=>'post']) !!}
<div class="form-group">
	{!! Form::label('Empleado/a') !!}
	{!! Form::label('monto',$employee->nombrecompleto(),['class'=>'form-control']) !!}
	{!! Form::hidden('people_id',$employee->id,['class'=>'form-control']) !!}
</div>
<div class="form-group">
	{!! Form::label('monto en bs.') !!}
	{!! Form::text('monto',null,['class'=>'form-control','placeholder'=>'Inserte Monto','onkeypress'=>"return justNumbers(event);"]) !!}
</div>
<div class="form-group">
	{!! Form::label('Tipo') !!}
	{!! Form::select('tipo',['Pago de Salario' => 'Pago de Salario','Adelanto' => 'Adelanto'],null,['class'=>'form-control','maxlength'=>30]) !!}
</div>
<div class="form-group">
	{!! Form::label('Glosa') !!}
	{!! Form::text('glosa','Pago de salario a empleado '.$employee->nombrecompleto(),['class'=>'form-control','placeholder'=>'Inserte Glosa', 'maxlength'=>200]) !!}
</div>
{!! Form::submit('Registar',['class'=>'btn btn-primary']) !!}
{!! Form::close() !!}
@endsection
@section('adminjs')
{!!Html::script('js/ventas.js')!!}
@endsection