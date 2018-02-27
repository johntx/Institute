<br>
<div class="col-xs-6" style="padding-left: 0;">
	<div class="panel panel-default">
		<div class="panel-heading">Kardex del Estudiante</div>
		<div class="panel-body">
			<input type="hidden" name="_token" id="token" value="{{csrf_token()}}">
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
				{!! Form::label('Telefonos Padres') !!}
				{!! Form::text('telefono2',null,['class'=>'form-control','placeholder'=>'Inserte Telefono', 'maxlength'=>200]) !!}
			</div>
			<div class="form-group">
				{!! Form::label('Carrera') !!}
				{!! Form::text('carrera',null,['class'=>'form-control','placeholder'=>'Inserte Carrera a la que postula', 'maxlength'=>50,'style'=>'text-transform: uppercase;']) !!}
			</div>
			@if (Auth::user()->role->code == 'ADM' || Auth::user()->role->code == 'REG')
			<div class="form-group">
				{!! Form::label('Fecha de Ingreso') !!}
				{!! Form::text('fecha_ingreso',\Carbon\Carbon::now()->format('Y-m-d'),['class'=>'form-control datepicker','placeholder'=>'yyyy-mm-dd']) !!}
			</div>
			@else
			<div class="form-group">
				{!! Form::hidden('fecha_ingreso',\Carbon\Carbon::now()->format('Y-m-d'),['class'=>'form-control datepicker','placeholder'=>'yyyy-mm-dd']) !!}
			</div>
			@endif
		</div>
	</div>
</div>
<div class="col-xs-6" style="padding-right: 0;">
	<div class="panel panel-default">
		<div class="panel-heading">Seleccion de Carrera y Grupo</div>
		<div class="panel-body">
			<div class="form-group">
				{!! Form::label('Carrera (Convocatorias)') !!}
				<select name="startclass_id" id="career_select" class="form-control selectpicker" data-style="btn-info" required>
					<option selected disabled>Seleccionar Carrera</option>
					@foreach ($startclasses as $startclass)
					<option value="{{$startclass->id}}" 
						costo='{{$startclass->costo}}' 
						duracion='{{$startclass->duracion}}' carrera='{{$startclass->career->nombre}}'
						>{{$startclass->career->nombre}} {{$startclass->descripcion}} - [{{Jenssegers\Date\Date::parse($startclass->fecha_inicio)->format('j M Y')}}] ({{$startclass->estado}})
					</option>
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
			<br><br>
			<br><br>
			<!--div class="form-group">
				{!! Form::checkbox('combo',null,null,['class'=>'combo']) !!}
				{!! Form::label('COMBO') !!}
			</div-->
			<div id="div_extra" style="display: none;">
				@foreach($extras as $extra)
				<div class="form-group">
					{!! Form::checkbox('extras[]',$extra->id,null,[ 'class'=>'extra','id'=>$extra->nombre, 'precio'=>$extra->precio]) !!}
					{!! Form::label($extra->nombre,$extra->nombre.' ($'.$extra->precio.')') !!}
				</div>
				@endforeach
			</div>
			<div class="form-group">
				{!! Form::label('Pago Inicial') !!}
				{!! Form::text('abono',null,['class'=>'form-control abono','placeholder'=>'Insert Pago','onkeypress'=>"return justNumbers(event);", 'required']) !!}
			</div>
		</div>
	</div>
</div>