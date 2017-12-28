<br>
<div class="panel panel-default col-xs-6" style="padding: 0;">
	<div class="panel-heading">Kardex del Estudiante</div>
	<div class="panel-body">
		<div class="form-group required">
			{!! Form::label('Nombres*') !!}
			{!! Form::text('nombre',null,['class'=>'form-control','placeholder'=>'Insert Nombre','required', 'maxlength'=>50,'style'=>'text-transform: uppercase;']) !!}
		</div>
		<div class="form-group required">
			{!! Form::label('Apellidos*') !!}
			{!! Form::text('paterno',null,['class'=>'form-control','placeholder'=>'Insert Apellido','required', 'maxlength'=>100,'style'=>'text-transform: uppercase;']) !!}
		</div>
		<div class="form-group">
			{!! Form::label('CI') !!}
			{!! Form::text('ci',null,['class'=>'form-control','placeholder'=>'Insert CI', 'maxlength'=>20,'onkeypress'=>"return justNumbers(event);"]) !!}
		</div>
		<div class="form-group">
			{!! Form::label('Fecha de Nacimiento') !!}
			{!! Form::text('fecha_nacimiento',null,['class'=>'form-control datepicker','placeholder'=>'yyyy-mm-dd']) !!}
		</div>
		<div class="form-group">
			{!! Form::label('Telefonos') !!}
			{!! Form::text('telefono',null,['class'=>'form-control','placeholder'=>'Insert Telefono', 'maxlength'=>100]) !!}
		</div>
		<div class="form-group">
			{!! Form::label('Fecha de Ingreso') !!}
			{!! Form::text('fecha_ingreso',\Carbon\Carbon::now()->format('Y-m-d'),['class'=>'form-control datepicker','placeholder'=>'yyyy-mm-dd']) !!}
		</div>
	</div>
</div>
<div class="panel panel-default col-xs-6" style="padding: 0;">
	<div class="panel-heading">Seleccion de Carrera y Grupo</div>
	<div class="panel-body">
		<div class="form-group">
			{!! Form::label('Carrera (Convocatorias)') !!}
			<select name="startclass_id" id="career_select" class="form-control selectpicker" data-style="btn-info" required>
				<option selected disabled>Seleccionar Carrera</option>
				@foreach ($startclasses as $startclass)
				<option value="{{$startclass->id}}" 
					costo='{{$startclass->career->costo}}' 
					duracion='
					@if ($startclass->career->tipo == 'Semana')
						1
					@else
						{{$startclass->career->duracion}}
					@endif
					'
					>{{$startclass->career->nombre}} - [{{date_format(date_create($startclass->fecha_inicio),'d-m-Y')}}] ({{$startclass->estado}}) [{{$startclass->career->costo}}bs]</option>
					@endforeach
				</select>
			</div>
			<div class="form-group">
				{!! Form::label('Grupos') !!}
				<select id="group_id" name="group_id" class="form-control" required>
					<option>Debe escoger una Carrera Primero</option>
				</select>
			</div>
			<div class="form-group">
				<div class=" col-xs-6" style="padding: 0;">
					{!! Form::label('Costo Mensual') !!}
					{!! Form::text('monto',null,['class'=>'form-control', 'id'=>'monto','placeholder'=>'Insert Monto', 'duracion'=>'','onkeypress'=>"return justNumbers(event);",'required']) !!}
				</div>
				<div class="col-xs-2" style="padding-right: 0;">
					{!! Form::label('Meses') !!}
					{!! Form::label('',null,['class'=>'form-control', 'id'=>'meses']) !!}
				</div>
				<div class="col-xs-4" style="padding-right: 0;">
					{!! Form::label('Costo Total') !!}
					{!! Form::text('total',null,['class'=>'form-control total','placeholder'=>'Insert Total', 'onkeypress'=>"return justNumbers(event);"]) !!}
				</div>
			</div>
			<br><br><br>
			<br><br><br>
			<div class="form-group">
				{!! Form::label('Pago Inicial') !!}
				{!! Form::text('abono',null,['class'=>'form-control abono','placeholder'=>'Insert Pago','onkeypress'=>"return justNumbers(event);", 'required']) !!}
			</div>
		</div>
	</div>