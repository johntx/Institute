<div class="panel panel-default">
	<div class="panel-heading">Registrar Pagos</div>
	<div class="panel-body">
		<div class=" col-xs-5" style="padding: 0;">
			{!! Form::label('(CI) - Estudiante') !!}
			<select name="user_id" class="form-control selectpicker" required data-live-search="true" id="payments_estudiante">
				<option>Seleccione un estudiante</option>
				@foreach ($students as $student)
				<option value="{{$student->id}}">
					({{$student->ci}}) - {{$student->nombrecompleto()}}
				</option>
				@endforeach
			</select>
		</div>
		<div class="col-xs-7" style="padding-right: 0;">
			{!! Form::label('Carrera') !!}
			<select id="payments_carrera" name="inscription_id" class="form-control" required>
				<option>Debe escoger un Estudiante Primero</option>
			</select>
		</div>
		<div class=" col-xs-7" style="padding: 0;">
		</div>
		<div class=" col-xs-3">
			{!! Form::label('Abono') !!}
			{!! Form::text('abono',null,['class'=>'form-control abono','placeholder'=>'Insert Pago','onkeypress'=>"return justNumbers(event);", 'required']) !!}
		</div>

		{!! Form::submit('Registrar',['class'=>'btn btn-primary col-xs-2','style'=>'margin-top:23.5px;']) !!}


		<div class=" col-xs-3" style="padding: 0;">
			{!! Form::label('Colegiatura Estado') !!}
			{!! Form::label('','',['class'=>'form-control','id'=>'colegiatura']) !!}
		</div>
		<div class=" col-xs-9" style="padding-right: 0;">
			{!! Form::label('Observaciones') !!}
			{!! Form::text('observacion',null,['class'=>'form-control','placeholder'=>'Insert Observación', 'maxlength'=>255]) !!}
		</div>

	</div>
	<table class="table table-hover">
		<thead>
			<th>Id</th>
			<th>Fecha a Pagar</th>
			<th>Pagó</th>
			<th>Abono</th>
			<th>Saldo</th>
			<th>Estado</th>
			<th>Observaciones</th>
		</thead>
		<tbody id="payments_pagos">
		</tbody>
	</table>
</div>