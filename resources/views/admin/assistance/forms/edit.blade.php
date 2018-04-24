<br>
<div class="col-xs-6" style="padding: 0;">
	<div class="panel panel-success">
		<div class="panel-heading">Kardex del Estudiante</div>
		<div class="panel-body">
			<div class="form-group required">
				{!! Form::label('Nombres*') !!}
				{!! Form::text('nombre',null,['class'=>'form-control','placeholder'=>'Inserte Nombre','required', 'maxlength'=>50,'style'=>'text-transform: uppercase;']) !!}
			</div>
			<div class="form-group required">
				{!! Form::label('Apellidos*') !!}
				{!! Form::text('paterno',null,['class'=>'form-control','placeholder'=>'Inserte Apellido','required', 'maxlength'=>100,'style'=>'text-transform: uppercase;']) !!}
			</div>
			<div class="form-group">
				{!! Form::label('CI') !!}
				{!! Form::text('ci',null,['class'=>'form-control','placeholder'=>'Inserte CI', 'maxlength'=>20,'onkeypress'=>"return justNumbers(event);"]) !!}
			</div>
			<div class="form-group">
				{!! Form::label('Fecha de Nacimiento') !!}
				{!! Form::text('fecha_nacimiento',null,['class'=>'form-control datepicker','placeholder'=>'yyyy-mm-dd']) !!}
			</div>
			<div class="form-group">
				{!! Form::label('Telefonos') !!}
				{!! Form::text('telefono',null,['class'=>'form-control','placeholder'=>'Inserte Telefono', 'maxlength'=>100]) !!}
			</div>
			<div class="form-group">
				{!! Form::label('Telefonos Padres') !!}
				{!! Form::text('telefono2',null,['class'=>'form-control','placeholder'=>'Inserte Telefono', 'maxlength'=>200]) !!}
			</div>
			<div class="form-group">
				{!! Form::label('Carrera') !!}
				{!! Form::text('carrera',null,['class'=>'form-control','placeholder'=>'Inserte Carrera a la que postula', 'maxlength'=>50,'style'=>'text-transform: uppercase;']) !!}
			</div>
			@if (!empty(Auth::user()->role->functionalities()->select('functionalities.*')->where('code','DEST')->first()))
			{!!link_to_route('admin.student.show', $title = 'Eliminar Estudiante', $parameters = $student->id, $attributes = ['class'=>'btn btn-danger'])!!}
			@endif
		</div>
	</div>
</div>
@foreach ($student->inscriptions as $inscription)
<div class="col-xs-6" style="padding-right: 0;">
	<div class="panel panel-info">
		<div class="panel-heading"><b>Inscripción:</b> {{$inscription->group->startclass->career->nombre}} {{$inscription->group->startclass->descripcion}} - [{{date_format(date_create($inscription->group->startclass->fecha_inicio),'d-m-Y')}}] ({{$inscription->group->startclass->estado}}) [{{$inscription->group->startclass->costo}}bs]
		</div>
		<div class="panel-body">
			{!! Form::hidden('inscription_id[]',$inscription->id,['class'=>'form-control']) !!}
			<div class="form-group">
				{!! Form::label('Grupos') !!}
				<br>
				<select id="group_id" name="group_id[]" class="form-control">
					@foreach (\Institute\Group::leftjoin('inscriptions','groups.id','=','inscriptions.group_id')->select('groups.*', DB::raw('count(inscriptions.id) as inscritos'))->groupBy('groups.id')->where('startclass_id',$inscription->group->startclass->id)->get() as $group)
					<option value="{{$group->id}}" 
						@if ($inscription->group->id == $group->id)
						selected 
						@endif
						>{{$group->startclass->career->nombre}} {{$group->turno}} ({{$group->inscritos}} inscritos)
					</option>
					@endforeach
				</select>
			</div>
			<div class="col-xs-6" style="padding-left: 0;">
				<div class="form-group">
					{!! Form::label('Estado') !!}
					{!! Form::select('estado[]',['Inscrito' => 'Inscrito','Culminado' => 'Culminado','Retirado' => 'Retirado'],$inscription->estado,['class'=>'form-control','maxlength'=>20]) !!}
				</div>
			</div>
			<div class="col-xs-6" style="padding-right: 0;">
				<div class="form-group">
					{!! Form::label('Fecha de Inscripción') !!}
					{!! Form::text('fecha_ingreso[]',$inscription->fecha_ingreso,['class'=>'form-control datepicker','placeholder'=>'yyyy-mm-dd']) !!}
				</div>
			</div>
			<div class="form-group">
				{!! Form::label('Pagos por mes') !!}
				{!! Form::text('monto[]',$inscription->monto,['class'=>'form-control','id'=>'monto','onkeypress'=>"return justNumbers(event);",'required']) !!}
			</div>
			<div class="form-group">
				{!! Form::label('Abono total') !!}
				{!! Form::label($inscription->abono,null,['class'=>'form-control','abono'=>$inscription->abono,'id'=>'abon','onkeypress'=>"return justNumbers(event);",'required']) !!}
			</div>
			<div class="form-group">
				{!! Form::label('Total a pagar') !!}
				{!! Form::text('total[]',$inscription->total,['class'=>'form-control','id'=>'totl','onkeypress'=>"return justNumbers(event);",'required']) !!}
			</div>
			<div class="form-group">
				{!! Form::label('Estado de pagos') !!}
				{!! Form::select('colegiatura[]',['Debe' => 'Debe','Pagado' => 'Pagado'],$inscription->colegiatura,['class'=>'form-control','maxlength'=>20]) !!}
			</div>
			<?php $iextras = $inscription->extras; ?>
			@foreach($extras as $extra)
			<div class="form-group">
				@if ($iextras->contains($extra->id))
				{!! Form::checkbox('extras[]',$extra->id,$extra->id,[ 'class'=>'extra2','id'=>$extra->nombre, 'precio'=>$extra->precio]) !!}
				@else
				{!! Form::checkbox('extras[]',$extra->id,null,[ 'class'=>'extra2','id'=>$extra->nombre, 'precio'=>$extra->precio]) !!}
				@endif
				{!! Form::label($extra->nombre,$extra->nombre.' ($'.$extra->precio.')') !!}
			</div>
			@endforeach
			@if (!empty(Auth::user()->role->functionalities()->select('functionalities.*')->where('code','DINS')->first()))
			{!!link_to_route('admin.inscription.show', $title = 'Eliminar Inscripción', $parameters = $inscription->id, $attributes = ['class'=>'btn btn-warning'])!!}
			@endif
		</div>
	</div>
</div>
@endforeach