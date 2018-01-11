@extends('layouts.admin')
@section('content')
@include('alerts.succes')

<div>
	<ul class="nav nav-tabs" role="tablist">
		@foreach ($startclasses as $key=>$startclass)
		<li role="presentation" @if ($key==0) class="active" @endif >
			<a href="#{{$startclass->id}}" aria-controls="{{$startclass->id}}" role="tab" data-toggle="tab">{{$startclass->career->nombre}}<h6>{{Jenssegers\Date\Date::parse($startclass->fecha_inicio)->format('j M Y')}}</h6></a>
		</li>
		@endforeach
	</ul>
	<br>
	<div class="tab-content">
		@foreach ($startclasses as $key=>$startclass)
		<div role="tabpanel" class="tab-pane  @if ($key==0) active @endif" id="{{$startclass->id}}">
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
								@foreach ($group->inscriptions()->where('estado','Inscrito')->get() as $key=>$inscription)
								<tr>
									<td>{{++$key}}</td>
									<td>{{$inscription->people->nombrecompleto()}}</td>
									<td>
										{{Jenssegers\Date\Date::parse($inscription->group->startclass->fecha_inicio)->format('j M Y')}}
									</td>
									<td>
										{{Jenssegers\Date\Date::parse($inscription->fecha_ingreso)->format('j M Y')}}
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