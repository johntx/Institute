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
				{!! Form::checkbox('turno[]','Mañana 08:00 a 10:00',false,['id'=>'Mañana 08:00 a 10:00']) !!}
				{!! Form::label('Mañana 08:00 a 10:00','Mañana 08:00 a 10:00') !!}
				<br>
				{!! Form::checkbox('turno[]','Mañana 10:00 a 12:00',false,['id'=>'Mañana 10:00 a 12:00']) !!}
				{!! Form::label('Mañana 10:00 a 12:00','Mañana 10:00 a 12:00') !!}
				<br>
				{!! Form::checkbox('turno[]','Tarde 14:30 a 16:30',false,['id'=>'Tarde 14:30 a 16:30']) !!}
				{!! Form::label('Tarde 14:30 a 16:30','Tarde 14:30 a 16:30') !!}
				<br>
				{!! Form::checkbox('turno[]','Tarde 16:30 a 18:30',false,['id'=>'Tarde 16:30 a 18:30']) !!}
				{!! Form::label('Tarde 16:30 a 18:30','Tarde 16:30 a 18:30') !!}
			</div>
			<div class="form-group">
				{!! Form::text('otro', null, ['class'=>'form-control','placeholder'=>'Otro Turno..']) !!}
			</div>
		</div>
	</div>
</div>