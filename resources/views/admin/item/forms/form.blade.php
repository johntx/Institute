<div class="form-group">
	{!! Form::label('Nombre*') !!}
	{!! Form::text('nombre',null,['class'=>'form-control','placeholder'=>'Insert Nombre','required', 'maxlength'=>100,'style'=>'text-transform: uppercase;']) !!}
</div>
<div class="form-group">
	{!! Form::label('Detalle') !!}
	{!! Form::text('detalle',null,['class'=>'form-control','placeholder'=>'Insert Detalle', 'maxlength'=>255]) !!}
</div>
<div class="form-group">
	{!! Form::label('Cantidad Hojas') !!}
	{!! Form::text('hojas',null,['class'=>'form-control','placeholder'=>'Insert Cantidad Hojas','onkeypress'=>"return justNumbers(event);"]) !!}
</div>
<div class="form-group">
	{!! Form::label('Costo') !!}
	{!! Form::text('costo',null,['class'=>'form-control','placeholder'=>'Insert Costo','onkeypress'=>"return justNumbers(event);"]) !!}
</div>
<div class="form-group">
	{!! Form::label('Precio') !!}
	{!! Form::text('precio',null,['class'=>'form-control','placeholder'=>'Insert Precio','onkeypress'=>"return justNumbers(event);"]) !!}
</div>
{!! Form::hidden('stock',0) !!}
<div class="form-group">
	{!! Form::label('Categoria') !!}
	{!! Form::select('category_id', $categories, null, ['class'=>'form-control','required','data-live-search'=>"true" ]) !!}
</div>
<div class="form-group">
	{!! Form::label('Carrera') !!}
	{!! Form::select('career_id', $career, null, ['class'=>'form-control','required','data-live-search'=>"true" ]) !!}
</div>