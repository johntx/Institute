<div class="form-group">
	{!! Form::label('Lunes') !!}
	{!! Form::text('lunes',null,['class'=>'form-control','placeholder'=>'Inserte Disponibilidad', 'maxlength'=>255]) !!}
</div>
<div class="form-group">
	{!! Form::label('MARTES') !!}
	{!! Form::text('martes',null,['class'=>'form-control','placeholder'=>'Inserte Disponibilidad', 'maxlength'=>255]) !!}
</div>
<div class="form-group">
	{!! Form::label('MIERCOLES') !!}
	{!! Form::text('miercoles',null,['class'=>'form-control','placeholder'=>'Inserte Disponibilidad', 'maxlength'=>255]) !!}
</div>
<div class="form-group">
	{!! Form::label('JUEVES') !!}
	{!! Form::text('jueves',null,['class'=>'form-control','placeholder'=>'Inserte Disponibilidad', 'maxlength'=>255]) !!}
</div>
<div class="form-group">
	{!! Form::label('VIERNES') !!}
	{!! Form::text('viernes',null,['class'=>'form-control','placeholder'=>'Inserte Disponibilidad', 'maxlength'=>255]) !!}
</div>
<div class="form-group">
	{!! Form::label('SABADO') !!}
	{!! Form::text('sabado',null,['class'=>'form-control','placeholder'=>'Inserte Disponibilidad', 'maxlength'=>255]) !!}
</div>
<input type="hidden" name="id" value="{{$id}}">
<input type="hidden" name="people_id" value="{{$id}}">