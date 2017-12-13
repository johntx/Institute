<div class="form-group required">
	{!! Form::label('Nombre*') !!}
	{!! Form::text('nombre',null,['class'=>'form-control','placeholder'=>'Insert Nombre','required', 'maxlength'=>50,'style'=>'text-transform: uppercase;']) !!}
</div>
<div class="form-group col-md-12" style="padding: 0">
<div class="form-group col-xs-6" style="padding: 0">
	{!! Form::label('Duracion en Meses') !!}
	{!! Form::text('mes',null,['class'=>'form-control mes','onkeypress'=>"return justNumbers(event);"]) !!}
</div>
<div class="form-group col-xs-6">
	{!! Form::label('Duracion en semanas') !!}
	{!! Form::text('duracion',null,['class'=>'form-control duracion','onkeypress'=>"return justNumbers(event);"]) !!}
</div>
</div>
<div class="form-group">
	{!! Form::label('Costo en Bs.') !!}
	{!! Form::number('costo',null,['class'=>'form-control']) !!}
</div>
<div class="form-group">
	{!! Form::label('Sucursal*') !!}
	{!! Form::select('office_id', $offices, null, ['class'=>'form-control selectpicker','required']) !!}
</div>