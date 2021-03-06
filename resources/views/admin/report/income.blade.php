@extends('layouts.admin')
@section('content')
<div>
	<div class=" col-xs-6" style="padding: 0;">
		{!! Form::label('Fecha Inicio') !!}
		{!! Form::text('fecha_pago',\Carbon\Carbon::now()->subMonths(2)->format('Y-m-d'),['class'=>'form-control datepicker date_ingresos','placeholder'=>'yyyy-mm-dd','id'=>'date_ingresos_inicio']) !!}
	</div>
	<div class="col-xs-6">
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
						<th>EGRESOS</th>
						<th>TOTAL</th>
					</tr>
				</thead>
				<tbody id="ingresos">
				</tbody>
			</table>
		</div>
	</div>
</div>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
@endsection
@section('adminjs')
<script>$('document').ready(function(){
	cargaringresos();
});
</script>
@endsection