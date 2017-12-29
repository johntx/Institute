<div class="form-group required">
	{!! Form::label('Nombre*') !!}
	{!! Form::text('nombre',null,['class'=>'form-control','placeholder'=>'Insert Nombre','required', 'maxlength'=>50,'style'=>'text-transform: uppercase;']) !!}
</div>
	<div class="form-group">
		{!! Form::label('Modalidad (Tipo)') !!}
		{!! Form::select('tipo',['Mes' => 'Mensual','Semana' => 'Semanal'],null,['class'=>'form-control','maxlength'=>20]) !!}
	</div>
	<div class="form-group">
		{!! Form::label('Duracion') !!}
		{!! Form::text('duracion',null,['class'=>'form-control','onkeypress'=>"return justNumbers(event);"]) !!}
	</div>
<div class="form-group">
	{!! Form::label('Costo en Bs.') !!}
	{!! Form::number('costo',null,['class'=>'form-control']) !!}
</div>