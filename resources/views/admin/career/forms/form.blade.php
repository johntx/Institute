<div class="form-group required">
	{!! Form::label('Nombre*') !!}
	{!! Form::text('nombre',null,['class'=>'form-control','placeholder'=>'Insert Nombre','required', 'maxlength'=>50,'style'=>'text-transform: uppercase;']) !!}
</div>
<div class="form-group">
	{!! Form::label('Duracion en semanas') !!}
	{!! Form::number('duracion',null,['class'=>'form-control']) !!}
</div>
<div class="form-group">
	{!! Form::label('Costo en Bs.') !!}
	{!! Form::number('costo',null,['class'=>'form-control']) !!}
</div>
<div class="form-group">
	{!! Form::label('Sucursal*') !!}
	{!! Form::select('office_id', $offices, null, ['class'=>'form-control selectpicker','required']) !!}
</div>