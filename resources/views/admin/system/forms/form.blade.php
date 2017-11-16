<div class="form-group">
	{!! Form::label('Code*') !!}
	{!! Form::text('code',null,['class'=>'form-control','placeholder'=>'Insert Code','required', 'maxlength'=>10,'style'=>'text-transform: uppercase;']) !!}
</div>
<div class="form-group">
	{!! Form::label('Name*') !!}
	{!! Form::text('name',null,['class'=>'form-control','placeholder'=>'Insert Name','required', 'maxlength'=>20,'style'=>'text-transform: capitalize;']) !!}
</div>