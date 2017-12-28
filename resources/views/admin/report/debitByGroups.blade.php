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
			<div class="panel panel-primary">
				<div class="panel-heading"><b>Grupo:</b>{{$group->turno}}&nbsp;</div>
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
							@foreach (\Institute\Inscription::join('payments','inscriptions.id','=','payments.inscription_id')->select('inscriptions.*','payments.fecha_pagar','payments.saldo as debe')->where('payments.estado','Pendiente')->where('inscriptions.estado','Inscrito')->where('inscriptions.group_id',$group->id)->orderBy('payments.fecha_pagar','asc')->distinct()->get() as $key=>$inscription)
							<tr @if ($inscription->debit())
								class="danger" 
								@elseif ($inscription->debitNext())
								class="warning" 
								@else
								class="success" 
								@endif >
								<td>{{++$key}}</td>
								<td>{{ucwords(strtolower($inscription->people->nombrecompleto()))}}</td>
								<td>
									{{\Carbon\Carbon::parse($inscription->fechaInicioMes())->format('d/m/Y')}}
								</td>
								<td><b>{{\Carbon\Carbon::parse($inscription->fecha_pagar)->format('d/m/Y')}}</b></td>
								<td>
									{{\Carbon\Carbon::parse($inscription->fechaFinMes())->format('d/m/Y')}}
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