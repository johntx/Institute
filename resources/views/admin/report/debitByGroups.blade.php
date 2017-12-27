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
								<th>Fch. Ingreso</th>
								<th>Fecha Pagar</th>
								<th>Saldo</th>
							</tr>
						</thead>
						<tbody>
							@foreach (\Institute\Inscription::join('payments','inscriptions.id','=','payments.inscription_id')->select('inscriptions.*','payments.fecha_pagar')->where('payments.estado','Pendiente')->where('inscriptions.estado','Inscrito')->where('inscriptions.group_id',$group->id)->orderBy('payments.fecha_pagar','asc')->distinct()->get() as $key=>$inscription)
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
									@if (strtotime($inscription->group->startclass->fecha_inicio) > strtotime($inscription->people->fecha_ingreso))
									{{\Carbon\Carbon::parse($inscription->group->startclass->fecha_inicio)->format('d/m/Y')}}
									@else
									{{\Carbon\Carbon::parse($inscription->people->fecha_ingreso)->format('d/m/Y')}}
									@endif
								</td>
								<td>{{\Carbon\Carbon::parse($inscription->fecha_pagar)->format('d/m/Y')}}</td>
								<td>{!!$inscription->lastSaldoPayment()!!}</td>
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