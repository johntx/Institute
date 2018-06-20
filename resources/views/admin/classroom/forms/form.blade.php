<div class="form-group required">
	{!! Form::label('Area*') !!}
	{!! Form::text('area',null,['class'=>'form-control','placeholder'=>'Insert Area','required', 'maxlength'=>20,'style'=>'text-transform: uppercase;']) !!}
</div>
<div class="form-group required">
	{!! Form::label('Piso*') !!}
	{!! Form::text('piso',null,['class'=>'form-control','placeholder'=>'Insert Piso','required', 'maxlength'=>10,'style'=>'text-transform: uppercase;']) !!}
</div>
<div class="form-group required">
	{!! Form::label('Aula*') !!}
	{!! Form::text('aula',null,['class'=>'form-control','placeholder'=>'Insert Aula','required', 'maxlength'=>10,'style'=>'text-transform: uppercase;']) !!}
</div>
<div class="form-group">
	{!! Form::label('Sucursal*') !!}
	{!! Form::select('office_id', $offices, null, ['class'=>'form-control selectpicker','required']) !!}
</div>