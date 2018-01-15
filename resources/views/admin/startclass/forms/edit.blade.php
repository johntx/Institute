
<div class="form-group">
	{!! Form::label('Fecha de Inicio') !!}
	{!! Form::text('fecha_inicio',null,['class'=>'form-control datepicker','placeholder'=>'AAAA-mm-dd']) !!}
</div>
<div class="form-group">
	{!! Form::label('Fecha Fin') !!}
	{!! Form::text('fecha_fin',null,['class'=>'form-control datepicker','placeholder'=>'AAAA-mm-dd']) !!}
</div>
<div class="form-group">
	{!! Form::label('Estado') !!}
	{!! Form::select('estado',['Espera' => 'Espera','Iniciado' => 'Iniciado','Cerrado' => 'Cerrado'],null,['class'=>'form-control','maxlength'=>20]) !!}
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