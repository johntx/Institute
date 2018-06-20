@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::model($classroom) !!}
<div class="form-group">
	{!! Form::label('Area*') !!}
	{!! Form::label($classroom->area,null,['class'=>'form-control']) !!}
</div>
	{!! Form::label('Piso*') !!}
	{!! Form::label($classroom->piso,null,['class'=>'form-control']) !!}
</div>
	{!! Form::label('Aula*') !!}
	{!! Form::label($classroom->aula,null,['class'=>'form-control']) !!}
</div>
	{!! Form::label('Sucursal*') !!}
	{!! Form::label($classroom->office->nombre,null,['class'=>'form-control']) !!}
</div>
{!! Form::close() !!}
<div class="col-md-10"></div>
<div class="col-md-1">
	{!! Form::open(['route' => ['admin.classroom.destroy',$classroom->id],'method'=>'delete']) !!}
	{!! Form::submit('Borrar',['class'=>'btn btn-danger']) !!}
	{!! Form::close() !!}
</div>
@endsection