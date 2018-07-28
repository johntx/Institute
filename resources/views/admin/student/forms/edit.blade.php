<br>
<?php $del_est=false; $del_ins=false;
foreach (Session::get('functionalities') as $func) {
	if ($func->code=='DEST'){ $del_est=true; }
	if ($func->code=='DINS'){ $del_ins=true; }
}
?>
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
				{!! Form::text('fecha_nacimiento',null,['class'=>'form-control datepicker','placeholder'=>'yyyy-mm-dd','autocomplete'=>'off']) !!}
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
			<div class="form-group">
				{!! Form::label('Como se enteró del instituto') !!}
				<div class="input-group dropdown">
					{!! Form::text('encuesta',null,['class'=>'form-control dropdown-toggle inp_sel_turno','placeholder'=>'Encuesta','autocomplete'=>'off', 'maxlength'=>50]) !!}
					<ul class="dropdown-menu">
						<li><a href="#" data-value="Alguien que aprobo">Alguien que aprobo</a></li>
						<li><a href="#" data-value="Amigo/familiar">Amigo/familiar</a></li>
						<li><a href="#" data-value="Facebook">Facebook</a></li>
						<li><a href="#" data-value="Puesto">Puesto</a></li>
						<li><a href="#" data-value="Radio">Radio</a></li>
					</ul>
					<span role="button" class="input-group-addon dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="caret"></span></span>
				</div>
			</div>
			<div class="form-group">
				{!! Form::label('Observaciones') !!}
				{!! Form::text('observacion',null,['class'=>'form-control','placeholder'=>'Observaciones', 'maxlength'=>250]) !!}
			</div>
			@if ($del_est)
			{!!link_to_route('admin.student.show', $title = 'Eliminar Estudiante', $parameters = $student->id, $attributes = ['class'=>'btn btn-danger'])!!}
			@endif
		</div>
	</div>
</div>
@foreach ($student->inscriptions as $inscription)
<div class="col-xs-6" style="padding-right: 0;" id="{{$inscription->id}}">
	<div class="panel panel-info">
		<div class="panel-heading"><b>Inscripción:</b> {{$inscription->group->startclass->career->nombre}} {{$inscription->group->startclass->descripcion}} - [{{Jenssegers\Date\Date::parse($inscription->group->startclass->fecha_inicio)->format('j M Y')}}] ({{$inscription->group->startclass->estado}}) [{{$inscription->group->startclass->costo}}bs] ({{$inscription->id}})
		</div>
		<div class="panel-body">
			{!! Form::hidden('inscription_id[]',$inscription->id,['class'=>'form-control']) !!}
			<div class="form-group">
				{!! Form::label('Grupos') !!}
				<br>
				<select id="group_id" name="group_id[]" class="form-control">
					@foreach (\Institute\Career::get() as $k=>$career)
					<?php $b=false; ?>
					@foreach (\Institute\Group::leftjoin('inscriptions','groups.id','=','inscriptions.group_id')->join('startclasses','startclasses.id','=','groups.startclass_id')->select('groups.*', DB::raw('count(inscriptions.id) as inscritos'))->groupBy('groups.id')->where('startclasses.fecha_inicio',$inscription->group->startclass->fecha_inicio)->where('startclasses.career_id',$career->id)->get() as $group)
					<option value="{{$group->id}}" 
						@if ($inscription->group->id == $group->id)
						selected 
						@endif
						>{{$group->startclass->career->nombre}} {{$group->turno}} ({{$group->inscritos}} inscritos)
					</option>
					<?php $b=true; ?>
					@endforeach
					@if ($b)
					<option value="" disabled>-------------------------------------------------------------------</option>
					@endif
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
					{!! Form::text('fecha_ingreso[]',$inscription->fecha_ingreso,['class'=>'form-control datepicker','placeholder'=>'yyyy-mm-dd','autocomplete'=>'off']) !!}
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
				{!! Form::checkbox('extras[]',$extra->id,$extra->id,[ 'class'=>'extra_edit','id'=>$extra->nombre.$inscription->id, 'precio'=>$extra->precio, 'inscription'=>$inscription->id]) !!}
				@else
				{!! Form::checkbox('extras[]',$extra->id,null,[ 'class'=>'extra_edit','id'=>$extra->nombre.$inscription->id, 'precio'=>$extra->precio, 'inscription'=>$inscription->id]) !!}
				@endif
				{!! Form::label($extra->nombre.$inscription->id,$extra->nombre.' ($'.$extra->precio.')') !!}
			</div>
			@endforeach
			@if ($del_ins)
			{!!link_to_route('admin.inscription.show', $title = 'Eliminar Inscripción', $parameters = $inscription->id, $attributes = ['class'=>'btn btn-warning'])!!}
			@endif
		</div>
	</div>
</div>
@endforeach