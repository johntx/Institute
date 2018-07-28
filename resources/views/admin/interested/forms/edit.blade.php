<div class="form-group">
	{!! Form::label('Nombre') !!}
	{!! Form::text('nombre',null,['class'=>'form-control','placeholder'=>'Inserte Nombre', 'maxlength'=>200,'style'=>'text-transform: uppercase;']) !!}
</div>
<div class="form-group required">
	{!! Form::label('Telefonos*') !!}
	{!! Form::text('telefono',null,['class'=>'form-control','placeholder'=>'Insert Telefono','required', 'maxlength'=>100]) !!}
</div>
<div class="form-group">
	{!! Form::label('Carrera o Area') !!}
	{!! Form::select('career_id', $careers, null, ['class'=>'form-control selectpicker','required' ]) !!}
</div>
<div class="form-group">
{!! Form::label('Enviado') !!}
	<select name="enviado" class="form-control">
		<option value="{{null}}">No</option>
		<option @if ($interested->enviado)selected @endif value="Si">Si</option>
	</select>
</div>