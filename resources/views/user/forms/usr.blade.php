<div class="form-group">
	{!! Form::label('Usuario') !!}
	{!! Form::text('user',null,['class'=>'form-control','placeholder'=>'ingrese Usuario' , 'required', 'maxlength'=>100]) !!}
</div>
<div class="form-group">
	{!! Form::label('Password') !!}
	{!! Form::password('password',['class'=>'form-control','placeholder'=>'ingrese el Password', 'maxlength'=>60]) !!}
</div>
<div class="form-group">
	{!! Form::label('Role*') !!}
	{!! Form::select('role_id', $roles, null, ['class'=>'form-control','required' ]) !!}
</div>