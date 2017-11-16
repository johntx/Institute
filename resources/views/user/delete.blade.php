@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::model($user,['route' => ['user.update',$user->id],'method'=>'put']) !!}<div class="form-group">
{!! Form::label('Usuario') !!}
{!! Form::label($user->user,null,['class'=>'form-control','placeholder'=>'ingrese el Usuario' , 'required', 'maxlength'=>100]) !!}
</div>
<div class="form-group">
	{!! Form::label('Role*') !!}
	{!! Form::select('role_id', $roles, null, ['class'=>'form-control','disabled' ]) !!}
</div>
{!! Form::close() !!}
<div class="col-md-10"></div>
<div class="col-md-1">
	{!! Form::open(['route' => ['user.destroy',$user->id],'method'=>'delete']) !!}
	{!! Form::submit('Delete',['class'=>'btn btn-danger']) !!}
	{!! Form::close() !!}
</div>

@endsection