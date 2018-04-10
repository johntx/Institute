@extends('layouts.admin')
@section('content')
@include('alerts.succes')
<div class="table-responsive">
	@foreach($careers as $career)
	<div class="panel panel-danger">
		<div class="panel-heading">Carrera: ({{$career->nombre}})</div>
		<div class="panel-body">
			@foreach($career->startclasses()->where('startclasses.estado','!=','Cerrado')->get() as $startclass)
			<div class="panel panel-primary">
				<div class="panel-heading">Convocatoria: ({{Jenssegers\Date\Date::parse($startclass->fecha_inicio)->format('j M Y')}}) ({{$startclass->descripcion}}) ({{$career->nombre}})</div>
				<div class="panel-body">
					@foreach($startclass->groups as $group)
					<div class="panel panel-info">
						<div class="panel-heading">Turno: ({{$group->turno}})</div>
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table table-hover table-condensed" style=" font-size: 12px">
									<thead>
										<th>CI</th>
										<th>Nombre</th>
										<th>Fecha Nac.</th>
										<th>Telefono</th>
										<th>Carrera</th>
									</thead>
									@foreach($group->inscriptions()->where('inscriptions.estado','Inscrito')->get() as $inscription)
									<tr>
										<td>{{$inscription->people->ci}}</td>
										<td>{{$inscription->people->nombrecompleto()}}</td>
										<td>{{Jenssegers\Date\Date::parse($inscription->people->fecha_nacimiento)->format('j M Y')}}</td>
										<td><a href="https://api.whatsapp.com/send?phone=591{{$inscription->people->telefono}}" target="_blank">{{$inscription->people->telefono}}</a></td>
										<td>{{$career->nombre}}</td>
									</tr>
									@endforeach
								</table>
							</div>
						</div>
					</div>
					@endforeach
				</div>
			</div>
			@endforeach
		</div>
	</div>
	@endforeach
</div>
@endsection