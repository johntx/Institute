@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::model($evaluation) !!}
<div class="form-group">
	{!! Form::label('fecha*') !!}
	{!! Form::label($evaluation->fecha,$evaluation->fecha,['class'=>'form-control']) !!}
</div>
<div class="form-group">
	{!! Form::label('monto*') !!}
	{!! Form::label($evaluation->monto,$evaluation->monto,['class'=>'form-control']) !!}
</div>
<div class="form-group">
	{!! Form::label('glosa*') !!}
	{!! Form::label($evaluation->glosa,$evaluation->glosa,['class'=>'form-control']) !!}
</div>
<div class="form-group">
	{!! Form::label('tipo*') !!}
	{!! Form::label($evaluation->tipo,$evaluation->tipo,['class'=>'form-control']) !!}
</div>
{!! Form::close() !!}
<div class="col-md-10"></div>
<div class="col-md-1">
	{!! Form::open(['route' => ['admin.evaluation.destroy',$evaluation->id],'method'=>'delete']) !!}
	{!! Form::submit('Borrar',['class'=>'btn btn-danger']) !!}
	{!! Form::close() !!}
</div>
@endsection