@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::model($menu) !!}
<div class="form-group">
	{!! Form::label('Code*') !!}
	{!! Form::label($menu->code,null,['class'=>'form-control']) !!}
</div>
<div class="form-group">
	{!! Form::label('Label*') !!}
	{!! Form::label($menu->label,null,['class'=>'form-control']) !!}
</div>
<div class="form-group">
	{!! Form::label('Icon*') !!}
	{!! Form::label($menu->icon,null,['class'=>'form-control']) !!}
</div>
{!! Form::close() !!}
<div class="col-md-10"></div>
<div class="col-md-1">
	{!! Form::open(['route' => ['admin.menu.destroy',$menu->id],'method'=>'delete']) !!}
	{!! Form::submit('Borrar',['class'=>'btn btn-danger']) !!}
	{!! Form::close() !!}
</div>
@endsection