@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::model($evaluation,['route' => ['admin.evaluation.update',$evaluation->id],'method'=>'put']) !!}
@include('admin.evaluation.forms.form')
<div class="col-md-1">
	{!! Form::submit('Guardar',['class'=>'btn btn-primary']) !!}
	{!! Form::close() !!}
</div>
@endsection
@section('adminjs')
{!!Html::script('js/ventas.js')!!}
@endsection