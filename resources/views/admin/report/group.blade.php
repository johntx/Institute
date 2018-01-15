@extends('layouts.admin')
@section('content')
@include('alerts.succes')
<div class="tab-content">
		@foreach ($startclass->groups as $group)
		<div class="panel panel-primary">
			<div class="panel-heading"><b>Grupo: </b>{{$group->turno}} &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <b> Convocatoria: </b>{{Jenssegers\Date\Date::parse($startclass->fecha_inicio)->format('j M Y')}} al {{Jenssegers\Date\Date::parse($startclass->fecha_fin)->format('j M Y')}}</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-condensed table-hover">
						<thead>
							<tr>
								<th>Nº</th>
								<th>Nombre</th>
								<th>Esperado</th>
								<th>Inició</th>
								<th>Abono</th>
								<th>Total Pagar</th>
								<th>Telefono</th>
								<th>Estado</th>
							</tr>
						</thead>
						<tbody>
							<?php $n = 0; ?>
							@foreach ($group->inscriptions as $inscription)
							<tr>
								<?php
								if($inscription->fecha_ingreso>$inscription->group->startclass->fecha_inicio)
									$fecha_ingreso=$inscription->fecha_ingreso;
								else
									$fecha_ingreso=$inscription->group->startclass->fecha_inicio;
								?>
								<td>{{++$n}}</td>
								<td>{{$inscription->people->nombrecompleto()}}</td>
								<td>
									{{Jenssegers\Date\Date::parse($inscription->group->startclass->fecha_inicio)->format('j M Y')}}
								</td>
								<td>
									{{Jenssegers\Date\Date::parse($fecha_ingreso)->format('j M Y')}}
								</td>
								<td>{{$inscription->abono}}</td>
								<td>{{$inscription->total}}</td>
								<td>{{$inscription->people->telefono}}</td>
								<td>{{$inscription->estado}}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
		@endforeach
	</div>
@endsection