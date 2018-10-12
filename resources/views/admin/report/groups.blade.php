@extends('layouts.admin')
@section('content')
<div style="padding-top: 5px;">
	<ul class="nav nav-tabs" role="tablist">
		@foreach ($startclasses as $key=>$startclass)
		<li role="presentation" @if ($key==0) class="active" @endif>
			<a href="#{{$startclass->id}}" style="background-color: {{$startclass->career['color']}}; color: {{$startclass->career['texto']}};" aria-controls="{{$startclass->id}}" role="tab" data-toggle="tab">{{$startclass->career['nombre']}}<h6>{{Jenssegers\Date\Date::parse($startclass->fecha_inicio)->format('j M Y')}}</h6></a>
		</li>
		@endforeach
	</ul>
	<br>
	<div class="tab-content">
		@foreach ($startclasses as $key=>$startclass)
		<div role="tabpanel" class="tab-pane  @if ($key==0) active @endif" id="{{$startclass->id}}">
			@foreach ($startclass->groups()->orderBy('turno','asc')->get() as $group)
			<div class="panel panel-primary">
				<div class="panel-heading"><b>Grupo: </b>{{$group->turno}} &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <b> Convocatoria: </b><span style="font-size: 16px; margin: 0;"> &nbsp;<b>{{Jenssegers\Date\Date::parse($startclass->fecha_inicio)->format('j M Y')}}</b></span> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <b>Duración: {{$group->startclass->duracion}}</b> mes/es</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-condensed table-hover">
							<thead>
								<tr>
									<th>Nº</th>
									<th>Nombre</th>
									<th>Ext</th>
									<th>Pagos</th>
									<th>Mes</th>
									<th>Inicio Estd.</th>
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
									style="background-color: rgba(255,0,0,0.4);"
									@elseif ($inscription->debitNext())
									style="background-color: rgba(255,255,0,0.6);"
									@else
									style="background-color: rgba(0,255,0,0.7);"
									@endif >
									<?php
									if($inscription->fecha_ingreso>$inscription->group->startclass->fecha_inicio)
										$fecha_ingreso=$inscription->fecha_ingreso;
									else
										$fecha_ingreso=$inscription->group->startclass->fecha_inicio;
									$mese = \Carbon\Carbon::parse($fecha_ingreso)->diffInMonths(\Carbon\Carbon::now());
									?>
									<td>{{++$n}}</td>
									<td><a href="{{url('admin/student/search/'.$inscription->people->id)}}" style="color: #0800AB">{{$inscription->people->nombrecompleto()}}</a></td>
									<td>@foreach ($inscription->extras as $extra)
										<b>{{$extra->nombre[0]}}</b>
									@endforeach</td>
									<td style="text-align:center">{{round( $inscription->abono/$inscription->monto, 1, PHP_ROUND_HALF_UP)}}</td>
									<td>{{$mese+1}}/{{$inscription->group->startclass->duracion}}</td>
									<td>
										{{Jenssegers\Date\Date::parse($fecha_ingreso)->format('j M Y')}}
									</td>
									<td><b>{{Jenssegers\Date\Date::parse($inscription->fecha_pagar)->format('j M Y')}}</b>
									</td>
									<td>{{$inscription->monto-$inscription->debe}}</td>
									<td>{{$inscription->debe}}</td>
									<td><a href="https://api.whatsapp.com/send?phone=591{{$inscription->people->telefono}}" target="_blank">{{$inscription->people->telefono}}</a></td>
								</tr>
								@endforeach
								@foreach (\Institute\Inscription::join('payments','inscriptions.id','=','payments.inscription_id')->select('inscriptions.*','payments.fecha_pagar','payments.saldo as debe')->where('inscriptions.colegiatura','Pagado')->where('inscriptions.estado','Inscrito')->where('inscriptions.group_id',$group->id)->groupBy('inscriptions.id')->distinct()->get() as $inscription)
								<tr style="background-color: rgba(0,200,200,0.2);">
									<?php
									if($inscription->fecha_ingreso>$inscription->group->startclass->fecha_inicio)
										$fecha_ingreso=$inscription->fecha_ingreso;
									else
										$fecha_ingreso=$inscription->group->startclass->fecha_inicio;
									$mese = \Carbon\Carbon::parse($fecha_ingreso)->diffInMonths(\Carbon\Carbon::now());
									?>
									<td>{{++$n}}</td>
									<td><a href="{{url('admin/student/search/'.$inscription->people->id)}}" style="color: #0800AB">{{$inscription->people->nombrecompleto()}}</a></td>
									<td>@foreach ($inscription->extras as $extra)
										<b>{{$extra->nombre[0]}}</b>
									@endforeach</td>
									<td style="text-align:center">{{round( $inscription->abono/$inscription->monto, 1, PHP_ROUND_HALF_UP)}}</td>
									<td>{{$mese+1}}/{{$inscription->group->startclass->duracion}}</td>
									<td>
										{{Jenssegers\Date\Date::parse($fecha_ingreso)->format('j M Y')}}
									</td>
									<td>Pagado</td>
									<td>-</td>
									<td>-</td>
									<td><a href="https://api.whatsapp.com/send?phone=591{{$inscription->people->telefono}}" target="_blank">{{$inscription->people->telefono}}</a></td>
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