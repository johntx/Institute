@extends('layouts.admin')
@section('content')
@include('alerts.succes')

@foreach ($startclasses as $startclass)
<div class="panel panel-default" style="padding: 0;">
	<div class="panel-heading"><b>Convocatoria: </b>{{$startclass->career->nombre}} <b>Fecha inicio: </b>{{ \Carbon\Carbon::parse($startclass->fecha_inicio)->format('d/m/Y')}} <b>Sucursal: </b>{{ $startclass->office->nombre }}</div>
	<div class="panel-body">
		@foreach ($startclass->groups as $group)
		<div class="col-xs-6">
			<div class="panel panel-primary">
				<div class="panel-heading"><b>Grupo: </b>{{$group->turno}}</div>
				<div class="panel-body">
					<b>Inscritos: </b>{{ sizeof($group->inscriptions) }}
				</div>
			</div>
		</div>
		@endforeach
	</div>
</div>
@endforeach

@endsection