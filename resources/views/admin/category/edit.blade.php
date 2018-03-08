@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::model($category,['route' => ['admin.category.update',$category->id],'method'=>'put']) !!}
@include('admin.category.forms.form')
<div class="col-md-1">
	{!! Form::submit('Guardar',['class'=>'btn btn-primary']) !!}
	{!! Form::close() !!}
</div>
@endsection