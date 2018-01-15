<br>
<div class="col-xs-6" style="padding-left: 0;">
	<div class="panel panel-default">
		<div class="panel-heading">Convocatoria</div>
		<div class="panel-body">
			<div class="form-group">
				{!! Form::label('Fecha de Inicio') !!}
				{!! Form::text('fecha_inicio',null,['class'=>'form-control datepicker','placeholder'=>'AAAA-mm-dd']) !!}
			</div>
			<div class="form-group">
				{!! Form::label('Duracion en meses') !!}
				{!! Form::text('duracion',null,['class'=>'form-control','onkeypress'=>"return justNumbers(event);",'required']) !!}
			</div>
			<div class="form-group">
				{!! Form::label('Descripcion') !!}
				{!! Form::text('descripcion',null,['class'=>'form-control']) !!}
			</div>
			<div class="form-group">
				{!! Form::label('Carrera') !!}
				{!! Form::select('career_id', $careers, null, ['class'=>'form-control selectpicker','required' ]) !!}
			</div>
			<div class="form-group">
				{!! Form::label('Costo en Bs.') !!}
				{!! Form::text('costo',null,['class'=>'form-control','onkeypress'=>"return justNumbers(event);",'required']) !!}
			</div>
			<div class="form-group">
				{!! Form::label('Sucursal*') !!}
				{!! Form::select('office_id', $offices, null, ['class'=>'form-control selectpicker','required']) !!}
			</div>
		</div>
	</div>
</div>
<div class="col-xs-6" style="padding-right: 0;">
	<div class="panel panel-default">
		<div class="panel-heading">Habrir Grupos</div>
		<div class="panel-body">
			<div class="form-group">
				{!! Form::checkbox('turno[]','Mañana',false,['id'=>'mañana']) !!}
				{!! Form::label('mañana','Turno Mañana') !!}
				<br>
				{!! Form::checkbox('turno[]','Tarde',false,['id'=>'tarde']) !!}
				{!! Form::label('tarde','Turno Tarde') !!}
				<br>
				{!! Form::checkbox('turno[]','Noche',false,['id'=>'noche']) !!}
				{!! Form::label('noche','Turno Noche') !!}
			</div>
		</div>
	</div>
</div>