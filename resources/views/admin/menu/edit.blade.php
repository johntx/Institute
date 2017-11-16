@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::model($menu,['route' => ['admin.menu.update',$menu->id],'method'=>'put']) !!}
@include('admin.menu.forms.form')
<div class="col-md-1">
	{!! Form::submit('Guardar',['class'=>'btn btn-primary']) !!}
	{!! Form::close() !!}
</div>
@endsection