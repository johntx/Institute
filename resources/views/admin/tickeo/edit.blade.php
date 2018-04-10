@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::model($item,['route' => ['admin.item.update',$item->id],'method'=>'put']) !!}
@include('admin.item.forms.form')
<div class="col-md-1">
	{!! Form::submit('Guardar',['class'=>'btn btn-primary']) !!}
	{!! Form::close() !!}
</div>
@endsection