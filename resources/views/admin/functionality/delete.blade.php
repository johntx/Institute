@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::model($functionality) !!}
<div class="form-group">
	{!! Form::label('Code*') !!}
	{!! Form::label($functionality->code,null,['class'=>'form-control']) !!}
</div>
<div class="form-group">
	{!! Form::label('Label*') !!}
	{!! Form::label($functionality->label,null,['class'=>'form-control']) !!}
</div>
<div class="form-group">
	{!! Form::label('Path*') !!}
	{!! Form::label($functionality->path,null,['class'=>'form-control']) !!}
</div>
<div class="form-group">
	{!! Form::label('Menu*') !!}
	{!! Form::select('menu_id', $menus, null, ['class'=>'form-control']) !!}
</div>	{!! Form::close() !!}
<div class="col-md-10"></div>
<div class="col-md-1">
	{!! Form::open(['route' => ['admin.functionality.destroy',$functionality->id],'method'=>'delete']) !!}
	{!! Form::submit('Borrar',['class'=>'btn btn-danger']) !!}
	{!! Form::close() !!}
	</div>
@endsection