<div class="form-group">
	{!! Form::label('Title*') !!}
	{!! Form::text('title',null,['class'=>'form-control','placeholder'=>'Insert Title','required', 'maxlength'=>100]) !!}
</div>
<div class="form-group">
	{!! Form::label('Text') !!}
	{!! Form::textarea('text',null,['class'=>'form-control','placeholder'=>'Insert Text']) !!}
</div>
<div class="form-group">
	{!! Form::label('Init Date*') !!}
	{!! Form::text('date',null,['class'=>'form-control datepicker','placeholder'=>'yyyy-mm-dd','required']) !!}
</div>
<div class="form-group">
	{!! Form::label('End Date*') !!}
	{!! Form::text('enddate',null,['class'=>'form-control datepicker','placeholder'=>'yyyy-mm-dd','required']) !!}
</div>
<div class="form-group">
	{!! Form::label('Lugar') !!}
	{!! Form::text('place',null,['class'=>'form-control','placeholder'=>'Insert Place', 'maxlength'=>255]) !!}
</div>
<div class="form-group">
	{!! Form::label('Photos') !!}
	{!! Form::file('photos[]',['class'=>'form-control','placeholder'=>'Insert Picture','multiple']) !!}
</div>
<div class="form-group">
	{!! Form::label('Link') !!}
	{!! Form::text('link',null,['class'=>'form-control','placeholder'=>'Insert Link', 'maxlength'=>255]) !!}
</div>