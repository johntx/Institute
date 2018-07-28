@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::model($payment,['route' => ['admin.payment.update',$payment->id],'method'=>'put','files'=>true]) !!}
@include('admin.payment.forms.edit')
<div class="col-md-1">
	{!! Form::submit('Guardar',['class'=>'btn btn-primary']) !!}
	{!! Form::close() !!}
</div>
@endsection