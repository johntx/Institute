<div class="form-group">
	{!! Form::label('Code*') !!}
	{!! Form::text('code',null,['class'=>'form-control','placeholder'=>'Insert Code','required', 'maxlength'=>10,'style'=>'text-transform: uppercase;']) !!}
</div>
<div class="form-group">
	{!! Form::label('Label*') !!}
	{!! Form::text('label',null,['class'=>'form-control','placeholder'=>'Insert Label','required', 'maxlength'=>20,'style'=>'text-transform: capitalize;']) !!}
</div>
<div class="form-group">
	{!! Form::label('Icon*') !!}
	{!! Form::text('icon',null,['class'=>'form-control','placeholder'=>'Insert Icon','required', 'maxlength'=>20]) !!}
</div>