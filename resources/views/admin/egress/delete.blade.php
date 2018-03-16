@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::model($egress) !!}
<div class="form-group">
	{!! Form::label('fecha*') !!}
	{!! Form::label($egress->fecha,$egress->fecha,['class'=>'form-control']) !!}
</div>
<div class="form-group">
	{!! Form::label('monto*') !!}
	{!! Form::label($egress->monto,$egress->monto,['class'=>'form-control']) !!}
</div>
<div class="form-group">
	{!! Form::label('glosa*') !!}
	{!! Form::label($egress->glosa,$egress->glosa,['class'=>'form-control']) !!}
</div>
<div class="form-group">
	{!! Form::label('tipo*') !!}
	{!! Form::label($egress->tipo,$egress->tipo,['class'=>'form-control']) !!}
</div>
{!! Form::close() !!}
<div class="col-md-10"></div>
<div class="col-md-1">
	{!! Form::open(['route' => ['admin.egress.destroy',$egress->id],'method'=>'delete']) !!}
	{!! Form::submit('Borrar',['class'=>'btn btn-danger']) !!}
	{!! Form::close() !!}
</div>
@endsection