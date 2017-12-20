
<div class="form-group">
	{!! Form::label('Fecha de Inicio') !!}
	{!! Form::text('fecha_inicio',null,['class'=>'form-control datepicker','placeholder'=>'AAAA-mm-dd']) !!}
</div>
<div class="form-group">
	{!! Form::label('Carrera') !!}
	{!! Form::select('career_id', $careers, null, ['class'=>'form-control selectpicker','required' ]) !!}
</div>
<div class="form-group">
	{!! Form::label('Sucursal*') !!}
	{!! Form::select('office_id', $offices, null, ['class'=>'form-control selectpicker','required']) !!}
</div>