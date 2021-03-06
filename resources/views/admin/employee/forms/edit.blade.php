<div class="form-group required">
	{!! Form::label('CI*') !!}
	{!! Form::text('ci',null,['class'=>'form-control','placeholder'=>'Insert CI','required','maxlength'=>20]) !!}
</div>
<div class="form-group required">
	{!! Form::label('Nombres*') !!}
	{!! Form::text('nombre',null,['class'=>'form-control','placeholder'=>'Insert Nombre','required','maxlength'=>50,'style'=>'text-transform: uppercase;']) !!}
</div>
<div class="form-group required">
	{!! Form::label('Apellidos*') !!}
	{!! Form::text('paterno',null,['class'=>'form-control','placeholder'=>'Insert Apellido','required','maxlength'=>100,'style'=>'text-transform: uppercase;']) !!}
</div>
<div class="form-group">
	{!! Form::label('Telefonos') !!}
	{!! Form::text('telefono',null,['class'=>'form-control','placeholder'=>'Insert Telefono','maxlength'=>100]) !!}
</div>
<div class="form-group">
	{!! Form::label('Fecha de Nacimiento') !!}
	{!! Form::text('fecha_nacimiento',null,['class'=>'form-control datepicker','placeholder'=>'yyyy-mm-dd']) !!}
</div>
<div class="form-group">
	{!! Form::label('Direccion') !!}
	{!! Form::text('direccion',null,['class'=>'form-control','placeholder'=>'Insert Direccion','maxlength'=>255]) !!}
</div>
<div class="form-group">
{!! Form::label('ID Biometrico') !!}
	<select name="code" id="" class="form-control selectpicker">
		<option value="">--Seleccione--</option>
		@foreach ($biometrics as $bio)
		<option @if ($bio->id==$employee->code)
			selected
		@endif value="{{$bio->id}}">{{$bio->nombre}}</option>
		@endforeach
	</select>
</div>

<br><br>
<b>DATOS DE USUARIO</b>
<br><br><br>

<div class="form-group">
	{!! Form::label('Usuario') !!}
	{!! Form::text('user',$employee->user->user,['class'=>'form-control','placeholder'=>'ingrese Usuario','required', 'maxlength'=>100]) !!}
</div>
<div class="form-group">
	{!! Form::label('Rol*') !!}
	{!! Form::select('role_id', $roles, $employee->user->role->id, ['class'=>'form-control','required' ]) !!}
</div>
<div class="form-group required">
	{!! Form::label('Sucursal') !!}
	{!! Form::select('office_id', $offices, $employee->office->id, ['class'=>'form-control','required' ]) !!}
</div>