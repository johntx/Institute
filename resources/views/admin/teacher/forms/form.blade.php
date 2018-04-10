<div class="form-group required">
	{!! Form::label('CI') !!}
	{!! Form::text('ci',null,['class'=>'form-control','placeholder'=>'Insert CI','required', 'maxlength'=>20,'onkeypress'=>"return justNumbers(event);"]) !!}
</div>
<div class="form-group required">
	{!! Form::label('Nombres*') !!}
	{!! Form::text('nombre',null,['class'=>'form-control','placeholder'=>'Insert Nombre','required', 'maxlength'=>50]) !!}
</div>
<div class="form-group required">
	{!! Form::label('Apellidos*') !!}
	{!! Form::text('paterno',null,['class'=>'form-control','placeholder'=>'Insert Apellido Paterno','required', 'maxlength'=>100]) !!}
</div>
<div class="form-group required">
	{!! Form::label('Sucursal*') !!}
	{!! Form::select('office_id', $offices, null, ['class'=>'form-control','required' ]) !!}
</div>
<div class="form-group">
	{!! Form::label('Telefonos') !!}
	{!! Form::text('telefono',null,['class'=>'form-control','placeholder'=>'Insert Telefono', 'maxlength'=>100]) !!}
</div>
<div class="form-group">
	{!! Form::label('Fecha de Ingreso') !!}
	{!! Form::text('fecha_ingreso',Carbon\Carbon::now()->format('Y-m-d'),['class'=>'form-control datepicker','placeholder'=>'yyyy-mm-dd']) !!}
</div>
<div class="form-group">
{!! Form::label('ID Biometrico') !!}
	{!! Form::select('code', $biometrics, null, ['class'=>'form-control selectpicker']) !!}
</div>
<div class="panel panel-default">
	<div class="panel-body">
		<div class="col-xs-6">
			<div class="panel panel-info">
				<div class="panel-heading">Asignaturas Seleccionadas</div>
				<div class="panel-body">
					<ul class="list-group" id="list_subject_form_career">
						@if ($teacher)
						@foreach ($teacher->subjects()->orderBy('nombre','asc')->get() as $subject)
						<li class='list-group-item list-group-item-success'>
							{{$subject->nombre}}
							<button class='btn btn-danger btn_quitar_subject' type='button'><i class='fa fa-close fa-fw'></i></button>
							<input type='hidden' name='subjects[]' value='{{$subject->id}}' >
						</li>
						@endforeach
						@endif
					</ul>
				</div>
			</div>
		</div>
		<div class="col-xs-6">
			<div class="panel panel-default">
				<div class="panel-heading">Listado de Asignaturas</div>
				<div class="panel-body">
					<ul class="list-group">
						@foreach ($subjects as $subject)
						<div class="col-xs-6">
							<div class="list-group-item list-group-item-warning add_subject_form_career" id_subject="{{$subject->id}}" name_subject="{{$subject->nombre}}">{{$subject->nombre}}</div>
						</div>
						@endforeach
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>