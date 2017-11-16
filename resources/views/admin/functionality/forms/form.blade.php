<div class="form-group">
	{!! Form::label('Code*') !!}
	{!! Form::text('code',null,['class'=>'form-control','placeholder'=>'Insert Code','required', 'maxlength'=>10,'style'=>'text-transform: uppercase;']) !!}
</div>
<div class="form-group">
	{!! Form::label('Label*') !!}
	{!! Form::text('label',null,['class'=>'form-control','placeholder'=>'Insert Label','required', 'maxlength'=>20,'style'=>'text-transform: capitalize;']) !!}
</div>
<div class="form-group">
	{!! Form::label('Path*') !!}
	{!! Form::text('path',null,['class'=>'form-control','placeholder'=>'admin/function/create','required', 'maxlength'=>50]) !!}
</div>
<div class="form-group">
	{!! Form::label('Menu*') !!}
	{!! Form::select('menu_id', $menus, null, ['class'=>'form-control selectpicker','required','data-live-search'=>"true" ]) !!}
</div>