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
	</div>
</div>
<div class="panel panel-default col-xs-6" style="padding: 0;">
	<div class="panel-heading">Seleccion de Carrera y Grupo</div>
	<div class="panel-body">
		<div class="form-group">
			{!! Form::label('Carrera (Convocatorias)') !!}

			<select name="startclass_id" id="career_select" class="form-control " data-style="btn-info">
				@foreach ($startclasses as $startclass)
				<option value="{{$startclass->id}}" 
					@if ($student->inscriptions[0]->group->startclass->id == $startclass->id)
					selected 
					@endif
					>{{$startclass->career->nombre}} - [{{date_format(date_create($startclass->fecha_inicio),'d-m-Y')}}] ({{$startclass->estado}}) [{{$startclass->career->costo}}bs]</option>
					@endforeach
				</select>
				<br>
				{!! Form::label('Grupos') !!}
				<br>
				<select id="group_id" name="group_id" class="form-control">
					@foreach ($groups as $group)
					<option value="{{$group->id}}" 
						@if ($student->inscriptions[0]->group->id == $group->id)
						selected 
						@endif
						>{{$group->startclass->career->nombre}} {{$group->turno}} ({{$group->inscritos}} inscritos)</option>
						@endforeach
					</select>
				</div>
				<div class="form-group">
					{!! Form::label('Estado') !!}
					{!! Form::select('estado',['Inscrito' => 'Inscrito','Culminado' => 'Culminado','Retirado' => 'Retirado'],$student->inscriptions[0]->estado,['class'=>'form-control','maxlength'=>20]) !!}
				</div>
				<div class="form-group">
					{!! Form::label('Fecha de Ingreso') !!}
					{!! Form::text('fecha_ingreso',null,['class'=>'form-control datepicker','placeholder'=>'yyyy-mm-dd']) !!}
				</div>
			</div>
		</div>