<div class="form-group">
	{!! Form::label('Title*') !!}
	{!! Form::text('title',null,['class'=>'form-control','placeholder'=>'Insert Title','required', 'maxlength'=>50]) !!}
</div>
<div class="form-group">
	{!! Form::label('Text') !!}
	{!! Form::text('text',null,['class'=>'form-control','placeholder'=>'Insert Text', 'maxlength'=>150]) !!}
</div>
<div class="form-group">
	{!! Form::label('Picture*') !!}
	{!! Form::file('photo',['class'=>'form-control']) !!}
</div>