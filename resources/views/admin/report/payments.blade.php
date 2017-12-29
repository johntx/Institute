@extends('layouts.admin')
@section('content')
@include('alerts.succes')
<div>
		<div class=" col-xs-6" style="padding: 0;">
			{!! Form::label('Fecha Inicio') !!}
			{!! Form::text('fecha_pago',\Carbon\Carbon::now()->subMonths(2)->format('Y-m-d'),['class'=>'form-control datepicker date_ingresos','placeholder'=>'yyyy-mm-dd','id'=>'date_ingresos_inicio']) !!}
		</div>
		<div class=" col-xs-6">
			{!! Form::label('Fecha Fin') !!}
			{!! Form::text('fecha_pago',\Carbon\Carbon::now()->addMonth()->format('Y-m-d'),['class'=>'form-control datepicker date_ingresos','placeholder'=>'yyyy-mm-dd','id'=>'date_ingresos_fin']) !!}
		</div>
	<canvas id="lineChart"></canvas>
	<div class="tab-content">
		<div class="panel-body">
			<table class="table table-condensed">
				<thead>
					<tr>
						<th>MES</th>
						<th>INGRESOS</th>
					</tr>
				</thead>
				<tbody id="ingresos">
				</tbody>
			</table>
		</div>
	</div>

</div>
@endsection