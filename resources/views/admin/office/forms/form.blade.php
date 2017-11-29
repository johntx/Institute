<div class="form-group required">
	{!! Form::label('Nombre*') !!}
	{!! Form::text('nombre',null,['class'=>'form-control','placeholder'=>'Insert Nombre','required', 'maxlength'=>100]) !!}
</div>
<div class="form-group">
	{!! Form::label('Dirección') !!}
	{!! Form::text('direccion',null,['class'=>'form-control','placeholder'=>'Insert Dirección', 'maxlength'=>255]) !!}
</div>