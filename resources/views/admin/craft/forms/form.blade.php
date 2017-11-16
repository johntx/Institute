<div class="form-group">
	{!! Form::label('Name*') !!}
	{!! Form::text('name',null,['class'=>'form-control','placeholder'=>'Insert Name','required', 'maxlength'=>100]) !!}
</div>
<div class="form-group">
	{!! Form::label('Description') !!}
	{!! Form::textarea('description',null,['class'=>'form-control','placeholder'=>'Insert Description']) !!}
</div>
<div class="form-group">
	{!! Form::label('Link') !!}
	{!! Form::text('link',null,['class'=>'form-control','placeholder'=>'Insert Link', 'maxlength'=>255,'required']) !!}
</div>
<div class="form-group">
	{!! Form::label('Photo') !!}
	{!! Form::file('photo',['class'=>'form-control','placeholder'=>'Insert Picture']) !!}
</div>