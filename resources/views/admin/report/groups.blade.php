@extends('layouts.admin')
@section('content')
@include('alerts.succes')

<div>
	<ul class="nav nav-tabs" role="tablist">
		<?php $n=0; ?>
		@foreach ($startclasses as $startclass)
		<li role="presentation" @if ($n==0) class="active" <?php $n=1; ?> @endif >
			<a href="#{{$startclass->id}}" aria-controls="{{$startclass->id}}" role="tab" data-toggle="tab">{{$startclass->career->nombre}}<h6>{{\Carbon\Carbon::parse($startclass->fecha_inicio)->format('d/m/Y')}}</h6></a>
		</li>
		@endforeach
	</ul>
	<br>
	<div class="tab-content">
		<?php $n=0; ?>
		@foreach ($startclasses as $startclass)
		<div role="tabpanel" class="tab-pane  @if ($n==0) active <?php $n=1; ?> @endif" id="{{$startclass->id}}">
			@foreach ($startclass->groups as $group)
		<div>
			<div class="panel panel-primary">
				<div class="panel-heading"><b>Grupo: </b>{{$group->turno}}</div>
				<div class="panel-body">
					<table class="tablaOrder table table-condensed compact hover">
						<thead>
							<tr>
								<th>Nº</th>
								<th>Nombre</th>
								<th>Esperado</th>
								<th>Fch. Inicio</th>
								<th>Telefono</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($group->inscriptions as $key=>$inscription)
							<tr>
								<td>{{++$key}}</td>
								<td>{{$inscription->people->nombrecompleto()}}</td>
								<td>
									{{\Carbon\Carbon::parse($inscription->group->startclass->fecha_inicio)->format('d/m/Y')}}
								</td>
								<td>
									{{\Carbon\Carbon::parse($inscription->fecha_ingreso)->format('d/m/Y')}}
								</td>
								<td>{{$inscription->people->telefono}}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
		@endforeach
		</div>
		@endforeach
	</div>
</div>

@endsection