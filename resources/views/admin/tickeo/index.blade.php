@extends('layouts.admin')
@section('content')
<div>
<?php $people=\Institute\People::find($people_id); ?>
	<br>
	{!! Form::label(\Institute\Biometric::find($people->code)->nombre) !!}
	<br>
	<div class="form-group">
		{!! Form::label('Desde:') !!}
		{!! Form::text('fecha',Carbon\Carbon::now()->subMonth()->format('Y-m-d'),['class'=>'form-control datepicker','id'=>'fecha_tickeos','placeholder'=>'yyyy-mm-dd']) !!}
	</div>
	@if (Auth::user()->role->code == "ADM" || Auth::user()->role->code == "ROOT")
	{!!link_to_action('TickeoController@tickeoEmpleado', $title = 'Obtener Tickeos', $parameters = $people_id.'/'.Carbon\Carbon::now()->subMonth()->format('Y-m-d'), $attributes = ['class'=>'btn btn-info','code'=>$people_id])!!}
	<br>
	<br>
	@endif
	{!!link_to_action('TickeoController@MiLogTickeo', $title = 'Log Tickeos', $parameters = $people_id.'/'.Carbon\Carbon::now()->subMonth()->format('Y-m-d'), $attributes = ['class'=>'btn btn-warning','code'=>$people_id])!!}
</div>
@endsection