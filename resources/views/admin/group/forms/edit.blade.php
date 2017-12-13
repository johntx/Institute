<div class="form-group">
	{!! Form::label('Inicio de clases') !!}
	<select name="startclass_id" id="startclass" class="form-control selectpicker">
		@foreach ($startclasses as $startclass)
		<option value="{{ $startclass->id }}"
		@if ($startclass->id == $group->startclass_id)
		 selected 
		@endif
		>{{ $startclass->career->nombre }} - [{{ $startclass->fecha_inicio }}] - ({{ $startclass->estado }})</option>
		@endforeach
	</select>
</div>
<div class="form-group">
	{!! Form::label('Turno') !!}
	{!! Form::select('turno',['Mañana' => 'Mañana','Tarde' => 'Tarde','Noche' => 'Noche'],null,['class'=>'form-control','maxlength'=>20]) !!}
</div>
<div class="form-group" style="display: none;">
	{!! Form::label('Estado') !!}
	{!! Form::select('estado',['Vigente' => 'Vigente','Culminado' => 'Culminado','Cerrado' => 'Cerrado'],null,['class'=>'form-control','maxlength'=>20]) !!}
</div>
