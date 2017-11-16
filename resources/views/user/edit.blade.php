@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::model($user,['route' => ['user.update',$user->id],'method'=>'put']) !!}
@include('user.forms.usr')
<div class="col-md-1">
	{!! Form::submit('Update',['class'=>'btn btn-primary']) !!}
	{!! Form::close() !!}
</div>
@endsection