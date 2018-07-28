@extends('layouts.admin')
@section('content')
<?php $editar=false; $eliminar=false;
foreach (Session::get('functionalities') as $func) {
	if ($func->code=='EINC'){ $editar=true; }
	if ($func->code=='DINC'){ $eliminar=true; }
}
?>
<div class="table-responsive">
	<table class="table table-hover">
		<thead>
			<th>Id</th>
			<th>Fecha</th>
			<th>Usuario</th>
			<th>Items</th>
			<th>Monto</th>
			<th>Observaciones</th>
			<th>Opción</th>
		</thead>
		@foreach($incomes as $income)
		@if ($income->cancelled_income)
		<tbody style="background-color: rgba(255,100,0,0.3)">
		@else
		<tbody>
			@endif
			<td>{{$income->id}}</td>
			<td>{{Jenssegers\Date\Date::parse($income->fecha)->format('j M Y')}}</td>
			<td>{{$income->user->user}}</td>
			<td>@foreach ($income->incomelists as $lista)
				[{{$lista->item->nombre}} <b>({{$lista->cantidad}})</b>] 
			@endforeach</td>
			<td>{{$income->total}}</td>
			<td>{{$income->detalle}}</td>
			<td>
				{!!link_to_action('IncomeController@pdf', $title = 'Imprimir', $parameters = $income->id, $attributes = ['class'=>'btn btn-info pdfbtn','code'=>$income->id])!!}
			</td>
			@if ($editar)
			<!--td>
				{!!link_to_route('admin.income.edit', $title = 'Editar', $parameters = $income->id, $attributes = ['class'=>'btn btn-primary'])!!}
			</td-->
			@endif
			@if ($eliminar && Auth::user()->id==$income->user_id)
			<td>
				{!!link_to_route('admin.income.show', $title = 'Eliminar', $parameters = $income->id, $attributes = ['class'=>'btn btn-danger'])!!}
			</td>
			@endif
		</tbody>
		@endforeach
	</table>
</div>

<div class="modal fade" id="pdfModal" tabindex="0" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document" style="z-index: 2000">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">COMPROBANTE</h4>
			</div>
			<div style="text-align: center;">
				<iframe src="" style="width:100%; height:80%;" framebincome="0"></iframe>
			</div>
		</div>
	</div>
</div>
{!!$incomes->render()!!}
@endsection