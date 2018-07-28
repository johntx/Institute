<div class="form-group">
	{!! Form::label('Inicio de clases') !!}
	<select name="startclass_id" id="startclass" class="form-control selectpicker">
		@foreach ($startclasses as $startclass)
		<option value="{{ $startclass->id }}"
			@if ($startclass->id == $group->startclass_id)
			selected 
			@endif
			>{{ $startclass->career['nombre'] }} - [{{ $startclass->fecha_inicio }}] - ({{ $startclass->estado }})</option>
			@endforeach
		</select>
	</div>
	<div class="form-group">
		{!! Form::label('Turno') !!}

		<div class="input-group dropdown">
			{!! Form::text('turno','Mañana',['class'=>'form-control dropdown-toggle inp_sel_turno','placeholder'=>'Insert Turno', 'maxlength'=>30]) !!}
			<ul class="dropdown-menu">
				<li><a href="#" data-value="Mañana">Mañana</a></li>
				<li><a href="#" data-value="Tarde">Tarde</a></li>
				<li><a href="#" data-value="Noche">Noche</a></li>
			</ul>
			<span role="button" class="input-group-addon dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="caret"></span></span>
		</div>
	</div>
	<div class="form-group" style="display: none;">
		{!! Form::label('Estado') !!}
		{!! Form::select('estado',['Vigente' => 'Vigente','Culminado' => 'Culminado','Cerrado' => 'Cerrado'],null,['class'=>'form-control','maxlength'=>20]) !!}
	</div>
