
<div class="form-group">
	{!! Form::label('Fecha de Inicio') !!}
	{!! Form::text('fecha_inicio',null,['class'=>'form-control datepicker','placeholder'=>'AAAA-mm-dd']) !!}
</div>
<div class="form-group">
	{!! Form::label('Carrera') !!}
	{!! Form::select('career_id', $careers, null, ['class'=>'form-control selectpicker','required' ]) !!}
</div>
<div class="form-group">
	{!! Form::label('estado*') !!}
	{!! Form::select('estado',['Espera' => 'Espera','Iniciado' => 'Iniciado','Cerrado' => 'Cerrado'],null,['class'=>'form-control selectpicker','maxlength'=>20]) !!}
</div>