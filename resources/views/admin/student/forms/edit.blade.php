<br>
<div class="col-xs-6" style="padding: 0;">
	<div class="panel panel-success">
		<div class="panel-heading">Kardex del Estudiante</div>
		<div class="panel-body">
			<div class="form-group required">
				{!! Form::label('Nombres*') !!}
				{!! Form::text('nombre',null,['class'=>'form-control','placeholder'=>'Insert Nombre','required', 'maxlength'=>50,'style'=>'text-transform: uppercase;']) !!}
			</div>
			<div class="form-group required">
				{!! Form::label('Apellidos*') !!}
				{!! Form::text('paterno',null,['class'=>'form-control','placeholder'=>'Insert Apellido','required', 'maxlength'=>100,'style'=>'text-transform: uppercase;']) !!}
			</div>
			<div class="form-group">
				{!! Form::label('CI') !!}
				{!! Form::text('ci',null,['class'=>'form-control','placeholder'=>'Insert CI', 'maxlength'=>20,'onkeypress'=>"return justNumbers(event);"]) !!}
			</div>
			<div class="form-group">
				{!! Form::label('Fecha de Nacimiento') !!}
				{!! Form::text('fecha_nacimiento',null,['class'=>'form-control datepicker','placeholder'=>'yyyy-mm-dd']) !!}
			</div>
			<div class="form-group">
				{!! Form::label('Telefonos') !!}
				{!! Form::text('telefono',null,['class'=>'form-control','placeholder'=>'Insert Telefono', 'maxlength'=>100]) !!}
			</div>
		</div>
	</div>
</div>
@foreach ($student->inscriptions as $inscription)
<div class="col-xs-6" style="padding-right: 0;">
	<div class="panel panel-info">
		<div class="panel-heading"><b>Inscripción:</b> {{$inscription->career->nombre}} - [{{date_format(date_create($inscription->group->startclass->fecha_inicio),'d-m-Y')}}] ({{$inscription->group->startclass->estado}}) [{{$inscription->group->startclass->career->costo}}bs]</div>
		<div class="panel-body">
			{!! Form::hidden('career_id[]',$inscription->career_id,['class'=>'form-control']) !!}
			{!! Form::hidden('inscription_id[]',$inscription->id,['class'=>'form-control']) !!}
			<div class="form-group">
				{!! Form::label('Grupos') !!}
				<br>
				<select id="group_id" name="group_id[]" class="form-control">
					@foreach (\Institute\Group::leftjoin('inscriptions','groups.id','=','inscriptions.group_id')
						->select('groups.*', DB::raw('count(inscriptions.id) as inscritos'))
						->groupBy('groups.id')
						->where('startclass_id',$inscription->group->startclass->id)
						->get() as $group)
						<option value="{{$group->id}}" 
							@if ($inscription->group->id == $group->id)
							selected 
							@endif
							>{{$group->startclass->career->nombre}} {{$group->turno}} ({{$group->inscritos}} inscritos)
						</option>
						@endforeach
					</select>
				</div>
				<div class="form-group">
					{!! Form::label('Estado') !!}
					{!! Form::select('estado[]',['Inscrito' => 'Inscrito','Culminado' => 'Culminado','Retirado' => 'Retirado'],$inscription->estado,['class'=>'form-control','maxlength'=>20]) !!}
				</div>
				<div class="form-group">
					{!! Form::label('Fecha de Inscripción') !!}
					{!! Form::text('fecha_ingreso[]',$inscription->fecha_ingreso,['class'=>'form-control datepicker','placeholder'=>'yyyy-mm-dd']) !!}
				</div>
				<div class="col-xs-6" style="padding-left: 0;">
					<div class="form-group">
						{!! Form::label('Pagos por mes') !!}
						{!! Form::text('monto[]',$inscription->monto,['class'=>'form-control','onkeypress'=>"return justNumbers(event);",'required']) !!}
					</div>
				</div>
				<div class="col-xs-6" style="padding-right: 0;">
					<div class="form-group">
						{!! Form::label('Abono total') !!}
						{!! Form::text('abono[]',$inscription->abono,['class'=>'form-control','onkeypress'=>"return justNumbers(event);",'required']) !!}
					</div>
				</div>
				<div class="col-xs-6" style="padding-left: 0;">
					<div class="form-group">
						{!! Form::label('Total a pagar') !!}
						{!! Form::text('total[]',$inscription->total,['class'=>'form-control','onkeypress'=>"return justNumbers(event);",'required']) !!}
					</div>
				</div>
				<div class="col-xs-6" style="padding-right: 0;">
					<div class="form-group">
						{!! Form::label('Estado de pagos') !!}
						{!! Form::select('colegiatura[]',['Debe' => 'Debe','Pagado' => 'Pagado'],$inscription->colegiatura,['class'=>'form-control','maxlength'=>20]) !!}
					</div>
				</div>
			</div>
		</div>
	</div>
	@endforeach