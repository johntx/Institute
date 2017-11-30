@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::model($startclass,['route' => ['admin.startclass.update',$startclass->id],'method'=>'put']) !!}
@include('admin.startclass.forms.edit')
<div class="col-md-1">
	{!! Form::submit('Guardar',['class'=>'btn btn-primary']) !!}
	{!! Form::close() !!}
</div>
@endsection