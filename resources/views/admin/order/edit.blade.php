@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::model($order,['route' => ['admin.order.update',$order->id],'method'=>'put','files'=>true]) !!}
@include('admin.order.forms.edit')
<div class="col-md-1">
	{!! Form::submit('Guardar',['class'=>'btn btn-primary']) !!}
	{!! Form::close() !!}
</div>
@endsection
@section('adminjs')
{!!Html::script('js/ventas.js')!!}
@endsection