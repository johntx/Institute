<div class="form-group required">
	{!! Form::label('CI*') !!}
	{!! Form::text('ci',null,['class'=>'form-control','placeholder'=>'Insert CI','required', 'maxlength'=>20]) !!}
</div>
<div class="form-group required">
	{!! Form::label('Nombres*') !!}
	{!! Form::text('nombre',null,['class'=>'form-control','placeholder'=>'Insert Nombre','required', 'maxlength'=>50]) !!}
</div>
<div class="form-group required">
	{!! Form::label('Apellido Paterno*') !!}
	{!! Form::text('paterno',null,['class'=>'form-control','placeholder'=>'Insert Apellido','required', 'maxlength'=>50]) !!}
</div>
<div class="form-group required">
	{!! Form::label('Apellido Materno*') !!}
	{!! Form::text('materno',null,['class'=>'form-control','placeholder'=>'Insert Apellido','required', 'maxlength'=>50]) !!}
</div>
<div class="form-group">
	{!! Form::label('Fecha de Ingreso') !!}
	{!! Form::text('fecha_ingreso',Carbon\Carbon::now()->format('Y-m-d'),['class'=>'form-control datepicker','placeholder'=>'yyyy-mm-dd']) !!}
</div>
<div class="form-group">
	{!! Form::label('Fecha de Nacimiento') !!}
	{!! Form::text('fecha_nacimiento',null,['class'=>'form-control datepicker','placeholder'=>'yyyy-mm-dd']) !!}
</div>
<div class="form-group">
	{!! Form::label('Direccion') !!}
	{!! Form::text('direccion',null,['class'=>'form-control','placeholder'=>'Insert Direccion', 'maxlength'=>255]) !!}
</div>
<div class="form-group">
	{!! Form::label('Telefonos') !!}
	{!! Form::text('telefono',null,['class'=>'form-control','placeholder'=>'Insert Telefono', 'maxlength'=>100]) !!}
</div>
