@extends('layouts.admin')
@section('content')
@include('alerts.succes')
<br>
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
				<div class="panel-heading"><b>Grupo: </b>{{$group->turno}} &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <b> Convocatoria: </b>{{Jenssegers\Date\Date::parse($startclass->fecha_inicio)->format('j M Y')}}</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-condensed compact hover">
							<thead>
								<tr>
									<th>Nº</th>
									<th>Nombre</th>
									<th>Mes</th>
									<th>M.Est.</th>
									<th>M.Pagar</th>
									<th>Esperado</th>
									<th>Inició</th>
									<th>Fch. Pagar</th>
									<th>Abono</th>
									<th>Saldo</th>
									<th>Telefono</th>
								</tr>
							</thead>
							<tbody>
								<?php $n = 0; ?>
								@foreach (\Institute\Inscription::join('payments','inscriptions.id','=','payments.inscription_id')->select('inscriptions.*','payments.fecha_pagar','payments.saldo as debe')->where('payments.estado','Pendiente')->where('inscriptions.estado','Inscrito')->where('inscriptions.group_id',$group->id)->orderBy('payments.fecha_pagar','asc')->get() as $inscription)
								<tr @if ($inscription->debit())
									style="background-color: rgba(255,0,0,0.25);" 
									@elseif ($inscription->debitNext())
									style="background-color: rgba(255,255,0,0.25);" 
									@else
									style="background-color: rgba(0,255,0,0.25);" 
									@endif >
									<?php
									if($inscription->fecha_ingreso>$inscription->group->startclass->fecha_inicio)
										$fecha_ingreso=$inscription->fecha_ingreso;
									else
										$fecha_ingreso=$inscription->group->startclass->fecha_inicio;
									$mes = \Carbon\Carbon::parse($inscription->group->startclass->fecha_inicio)->diffInMonths(\Carbon\Carbon::now());
									$mese = \Carbon\Carbon::parse($fecha_ingreso)->diffInMonths(\Carbon\Carbon::now());
									$mes0 = \Carbon\Carbon::parse($fecha_ingreso)->diffInMonths(\Carbon\Carbon::parse($inscription->fecha_pagar));
									?>
									<td>{{++$n}}</td>
									<td>{{$inscription->people->nombrecompleto()}}</td>
									<td>{{$mes+1}}</td>
									<td>{{$mese+1}}</td>
									<td>{{$mes0+1}}</td>
									<td>
										{{Jenssegers\Date\Date::parse($inscription->group->startclass->fecha_inicio)->addMonth($mes)->format('j M Y')}}
									</td>
									<td>
										{{Jenssegers\Date\Date::parse($fecha_ingreso)->addMonth($mese)->format('j M Y')}}
									</td>
									<td><b>{{Jenssegers\Date\Date::parse($inscription->fecha_pagar)->format('j M Y')}}</b>
									</td>
									<td>{{$inscription->monto-$inscription->debe}}</td>
									<td>{{$inscription->debe}}</td>
									<td>{{$inscription->people->telefono}}</td>
								</tr>
								@endforeach
								@foreach (\Institute\Inscription::join('payments','inscriptions.id','=','payments.inscription_id')->select('inscriptions.*','payments.fecha_pagar','payments.saldo as debe')->where('inscriptions.colegiatura','Pagado')->where('inscriptions.estado','Inscrito')->where('inscriptions.group_id',$group->id)->groupBy('inscriptions.id')->distinct()->get() as $inscription)
								<tr>
									<?php
									if($inscription->fecha_ingreso>$inscription->group->startclass->fecha_inicio)
										$fecha_ingreso=$inscription->fecha_ingreso;
									else
										$fecha_ingreso=$inscription->group->startclass->fecha_inicio;
									$mes = \Carbon\Carbon::parse($inscription->group->startclass->fecha_inicio)->diffInMonths(\Carbon\Carbon::now());
									$mese = \Carbon\Carbon::parse($fecha_ingreso)->diffInMonths(\Carbon\Carbon::now());
									$mes0 = \Carbon\Carbon::parse($fecha_ingreso)->diffInMonths(\Carbon\Carbon::parse($inscription->fecha_pagar));
									?>
									<td>{{++$n}}</td>
									<td>{{$inscription->people->nombrecompleto()}}</td>
									<td>{{$mes+1}}</td>
									<td>{{$mese+1}}</td>
									<td>{{$mes0+1}}</td>
									<td>
										{{Jenssegers\Date\Date::parse($inscription->group->startclass->fecha_inicio)->addMonth($mes)->format('j M Y')}}
									</td>
									<td>
										{{Jenssegers\Date\Date::parse($fecha_ingreso)->addMonth($mese)->format('j M Y')}}
									</td>
									<td>Pagado</td>
									<td>-</td>
									<td>-</td>
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