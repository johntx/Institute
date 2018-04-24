@extends('layouts.admin')
@section('content')
@include('alerts.succes')
<div>
	<div class="form-group">
		{!! Form::label('Desde') !!}
		{!! Form::text('fecha',Carbon\Carbon::now()->subMonth()->format('Y-m-d'),['class'=>'form-control datepicker','id'=>'fecha_tickeos','placeholder'=>'yyyy-mm-dd']) !!}
	</div>
	{!!link_to_action('TickeoController@tickeoEmpleado', $title = 'Obtener Tickeos', $parameters = $people_id.'/'.Carbon\Carbon::now()->subMonth()->format('Y-m-d'), $attributes = ['class'=>'btn btn-info tickeos_btn_pdf','code'=>$people_id])!!}
	<br>
	<br>
	{!!link_to_action('TickeoController@MiLogTickeo', $title = 'Log Tickeos', $parameters = $people_id.'/'.Carbon\Carbon::now()->subMonth()->format('Y-m-d'), $attributes = ['class'=>'btn btn-warning tickeos_btn_pdf','code'=>$people_id])!!}
</div>
@endsection