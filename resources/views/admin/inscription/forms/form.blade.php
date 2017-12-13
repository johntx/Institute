<br>
<div class="panel panel-default col-xs-6" style="padding: 0;">
	<div class="panel-heading">Estudiante</div>
	<div class="panel-body">
		<div class="form-group required">
			{!! Form::label('(CI) - Estudiante') !!}
			<select name="user_id" class="form-control selectpicker" required data-live-search="true">
				<option>Seleccione un estudiante</option>
				@foreach ($students as $student)
				<option 
				value="{{$student->id}}">
				({{$student->ci}}) - {{$student->nombrecompleto()}}
			</option>
			@endforeach
		</select>
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
					duracion='{{$startclass->career->mes}}'
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
					{!! Form::label('',null,['class'=>'form-control total']) !!}
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