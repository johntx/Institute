@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::model($group,['route' => ['admin.group.update',$group->id],'method'=>'put']) !!}
@include('admin.group.forms.edit')
<div class="col-md-1">
	{!! Form::submit('Guardar',['class'=>'btn btn-primary']) !!}
	{!! Form::close() !!}
</div>
@endsection