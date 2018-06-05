@extends('layouts.admin')
@section('content')
<div class="panel panel-info">
	<div class="panel-heading">Datos Personales</div>
	<div class="panel-body">

		<div class="form-group col-xs-6" style="padding: 0;">
			{!! Form::label('[Código CIEN] - (CI) - Estudiante') !!}
			<select name="user_id" class="form-control selectpicker" required data-live-search="true" id="inscriptions_estudiante">
				<option selected disabled>Seleccione un estudiante</option>
				@foreach ($peoples as $people)
				<option value="{{$people->id}}">
					[{{$people->user->user}}] - 
					({{$people->ci}}) - {{$people->nombrecompleto()}}
				</option>
				@endforeach
			</select>
		</div>
		<div class="form-group col-xs-6" style="padding-right: 0;">
			{!! Form::label('CI') !!}
			{!! Form::label('',null,['class'=>'form-control', 'id'=>'inscriptions_ci']) !!}
		</div>
		<div class="form-group col-xs-4" style="padding: 0;">
			{!! Form::label('Nombres') !!}
			{!! Form::label('',null,['class'=>'form-control', 'id'=>'inscriptions_nombre']) !!}
		</div>
		<div class="form-group col-xs-4" style="padding-right: 0;">
			{!! Form::label('Apellido Paterno') !!}
			{!! Form::label('',null,['class'=>'form-control', 'id'=>'inscriptions_paterno']) !!}
		</div>
		<div class="form-group col-xs-4" style="padding-right: 0;">
			{!! Form::label('Apellido Materno') !!}
			{!! Form::label('',null,['class'=>'form-control', 'id'=>'inscriptions_materno']) !!}
		</div>
		<div class="form-group col-xs-6" style="padding: 0;">
			{!! Form::label('Fecha de Nacimiento') !!}
			{!! Form::label('',null,['class'=>'form-control', 'id'=>'inscriptions_fecha_nacimiento']) !!}
		</div>
		<div class="form-group col-xs-6" style="padding-right: 0;">
			{!! Form::label('Teléfonos') !!}
			{!! Form::label('',null,['class'=>'form-control', 'id'=>'inscriptions_telefono']) !!}
		</div>
	</div>
</div>

<div class="panel panel-primary">
	<div class="panel-heading" class="inscriptions_title_career">Datos de Carreras e Inscripciones</div>
	<div class="panel-body">
		<div class="form-group col-xs-6" style="padding: 0;">
			{!! Form::label('Carrera') !!}
			{!! Form::label('',null,['class'=>'form-control', 'id'=>'inscriptions_career']) !!}
		</div>
		<div class="form-group col-xs-6" style="padding-right: 0;">
			{!! Form::label('Grupo') !!}
			{!! Form::label('',null,['class'=>'form-control', 'id'=>'inscriptions_group']) !!}
		</div>

		<div class="form-group col-xs-4" style="padding: 0;">
			{!! Form::label('Mensualidad') !!}
			{!! Form::label('',null,['class'=>'form-control', 'id'=>'inscriptions_mensualidad']) !!}
		</div>
		<div class="form-group col-xs-4" style="padding-right: 0;">
			{!! Form::label('Cantidad de Meses') !!}
			{!! Form::label('',null,['class'=>'form-control', 'id'=>'inscriptions_mes']) !!}
		</div>
		<div class="form-group col-xs-4" style="padding-right: 0;">
			{!! Form::label('Costo Total') !!}
			{!! Form::label('',null,['class'=>'form-control', 'id'=>'inscriptions_total']) !!}
		</div>
		<table class="table table-hover">
			<thead>
				<th>Fecha a Pagar</th>
				<th>Pagó</th>
				<th>Abono</th>
				<th>Saldo</th>
				<th>Estado</th>
				<th>Observaciones</th>
			</thead>
			<tbody class="inscriptions_pagos">
			</tbody>
		</table>
	</div>
</div>
@endsection