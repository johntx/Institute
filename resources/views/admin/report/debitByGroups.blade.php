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
			<div class="panel panel-primary">
				<div class="panel-heading"><b>Grupo: </b>{{$group->turno}}&nbsp;</div>
				<div class="panel-body">
					<table class="tablab3 table table-condensed compact">
						<thead>
							<tr>
								<th>Nº</th>
								<th>Nombre</th>
								<th>Fch. Inicio</th>
								<th>Fecha Pagar</th>
								<th>Fch. Fin</th>
								<th>Abono</th>
								<th>Saldo</th>
								<th>Telefono</th>
							</tr>
						</thead>
						<tbody>
							@foreach (\Institute\Inscription::
							join('payments','inscriptions.id','=','payments.inscription_id')
							->select('inscriptions.*','payments.fecha_pagar','payments.saldo as debe')
							->where('payments.estado','Pendiente')
							->where('inscriptions.estado','Inscrito')
							->where('inscriptions.group_id',$group->id)
							->orderBy('payments.fecha_pagar','asc')
							->distinct()->get() as $key=>$inscription)
							<tr @if ($inscription->debit())
								style="background-color: rgba(255,0,0,0.25);" 
								@elseif ($inscription->debitNext())
								style="background-color: rgba(255,255,0,0.25);" 
								@else
								style="background-color: rgba(0,255,0,0.25);" 
								@endif >
								<td>{{++$key}}</td>
								<td>{{$inscription->people->nombrecompleto()}}</td>
								<td>
									{{Jenssegers\Date\Date::parse($inscription->fechaInicioMes())->format('j M Y')}}
								</td>
								<td><b>{{Jenssegers\Date\Date::parse($inscription->fecha_pagar)->format('j M Y')}}</b></td>
								<td>
									{{Jenssegers\Date\Date::parse($inscription->fechaFinMes())->format('j M Y')}}
								</td>
								<td>{{$inscription->monto-$inscription->debe}}</td>
								<td>{{$inscription->debe}}</td>
								<td>{{$inscription->people->telefono}}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
			@endforeach
		</div>
		@endforeach
	</div>
</div>
@endsection