@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::model($office) !!}
<div class="form-group">
	{!! Form::label('Code*') !!}
	{!! Form::label($office->code,null,['class'=>'form-control']) !!}
</div>
<div class="form-group">
	{!! Form::label('Label*') !!}
	{!! Form::label($office->label,null,['class'=>'form-control']) !!}
</div>
<div class="form-group">
	{!! Form::label('Icon*') !!}
	{!! Form::label($office->icon,null,['class'=>'form-control']) !!}
</div>
{!! Form::close() !!}
<div class="col-md-10"></div>
<div class="col-md-1">
	{!! Form::open(['route' => ['admin.office.destroy',$office->id],'method'=>'delete']) !!}
	{!! Form::submit('Borrar',['class'=>'btn btn-danger']) !!}
	{!! Form::close() !!}
</div>
@endsection