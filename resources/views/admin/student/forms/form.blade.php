<br>
<div class="panel panel-default col-xs-6" style="padding: 0;">
	<div class="panel-heading">Kardex del Estudiante</div>
	<div class="panel-body">
		<div class="form-group required">
			{!! Form::label('CI*') !!}
			{!! Form::text('ci',null,['class'=>'form-control','placeholder'=>'Insert CI','required', 'maxlength'=>20]) !!}
		</div>
		<div class="form-group required">
			{!! Form::label('Nombres*') !!}
			{!! Form::text('nombre',null,['class'=>'form-control','placeholder'=>'Insert Nombre','required', 'maxlength'=>50]) !!}
		</div>
		<div class="form-group required">
			{!! Form::label('Apellido Paterno*') !!}
			{!! Form::text('paterno',null,['class'=>'form-control','placeholder'=>'Insert Apellido','required', 'maxlength'=>50]) !!}
		</div>
		<div class="form-group required">
			{!! Form::label('Apellido Materno*') !!}
			{!! Form::text('materno',null,['class'=>'form-control','placeholder'=>'Insert Apellido','required', 'maxlength'=>50]) !!}
		</div>
		<div class="form-group">
			{!! Form::label('Fecha de Ingreso') !!}
			{!! Form::text('fecha_ingreso',Carbon\Carbon::now()->format('Y-m-d'),['class'=>'form-control datepicker','placeholder'=>'yyyy-mm-dd']) !!}
		</div>
		<div class="form-group">
			{!! Form::label('Fecha de Nacimiento') !!}
			{!! Form::text('fecha_nacimiento',null,['class'=>'form-control datepicker','placeholder'=>'yyyy-mm-dd']) !!}
		</div>
		<div class="form-group">
			{!! Form::label('Telefonos') !!}
			{!! Form::text('telefono',null,['class'=>'form-control','placeholder'=>'Insert Telefono', 'maxlength'=>100]) !!}
		</div>

	</div>
</div>
<div class="panel panel-default col-xs-6" style="padding: 0;">
	<div class="panel-heading">Seleccion de Carrera y Grupo</div>
	<div class="panel-body">
		<div class="form-group">
			{!! Form::label('Carrera') !!}
			<select name="career_id" id="career_select" class="form-control selectpicker" data-style="btn-info">
				@foreach ($careers as $career)
				<option value="{{$career->id}}">{{$career->nombre}} - [{{$career->}}] - ()</option>
				@endforeach
			</select>
			<br><br>
			<select id="group_id" name="group_id" class="form-control selectpicker">
				<option>Debe escoger una Carrera Primero</option>
			</select>
		</div>
	</div>
</div>