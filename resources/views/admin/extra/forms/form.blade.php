<div class="form-group required">
	{!! Form::label('Nombre*') !!}
	{!! Form::text('nombre',null,['class'=>'form-control','placeholder'=>'Insert Nombre','required', 'maxlength'=>50,'style'=>'text-transform: uppercase;']) !!}
</div>
<div class="form-group required">
	{!! Form::label('Precio*') !!}
	{!! Form::text('precio',null,['class'=>'form-control','placeholder'=>'Insert Precio','required', 'style'=>'text-transform: uppercase;','onkeypress'=>"return justNumbers(event);"]) !!}
</div>