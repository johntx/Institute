<div class="form-group">
	{!! Form::label('Name*') !!}
	{!! Form::text('name',null,['class'=>'form-control','placeholder'=>'Insert Name','required', 'maxlength'=>100]) !!}
</div>
<div class="form-group">
	{!! Form::label('Business*') !!}
	{!! Form::text('business',null,['class'=>'form-control','placeholder'=>'Insert Business','required', 'maxlength'=>100,'style'=>'text-transform: uppercase;']) !!}
</div>
<div class="form-group">
	{!! Form::label('Text*') !!}
	{!! Form::text('text',null,['class'=>'form-control','placeholder'=>'Insert Text','required', 'maxlength'=>255]) !!}
</div>