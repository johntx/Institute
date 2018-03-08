<div id="alert_same" class="alert alert-danger alert-dismissible" role="alert" style="display: none">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<strong>Atención!</strong><br>Acabas de seleccionar el mismo item.
</div>
<br>
<input type="hidden" name="_token" id="token" value="{{csrf_token()}}">
<div class="form-group">
	{!! Form::label('Observaciones') !!}
	{!! Form::text('detalle',null,['class'=>'form-control','placeholder'=>'Observaciones o Comentarios','maxlength'=>255]) !!}
</div>
<div class="panel panel-info">
	<div class="panel-heading">Selección de items</div>
	<table class="table table-condensed">
		<thead>
			<th>(Codigo) Nombre</th>
			<th>Cantidad</th>
			<th>Quitar</th>
		</thead>
		<tbody>
			<td>
				<select name="item[]" class="selectpicker sel_itm last_sel" required data-live-search="true">
					<option disabled selected value> -- Seleccione un Item -- </option>
					@foreach ($items as $item)
					<option value="{{$item->id}}" code="{{$item->id}}" name="{{$item->nombre}}">({{substr($item->career->nombre, 0, 3)}}) {{$item->nombre}}</option>
					@endforeach
				</select>
			</td>
			<td class="quantity">
				<input name="cantidad[]" type="number" class="form-control col-xs-1 quant" value="1" disabled required>
			</td>
			<td class="remove">
				<button type="button" disabled class="btn btn-danger remove_btn">X</button>
			</td>
		</tbody>
		<tbody class="total_body" style="font-size: 21px;">
		</tbody>
	</table>
	<table class="table" style="display: none;">
		<tbody id="new_item">
			<td>
				<select name="item[]" class="sel_itm" data-live-search="true">
					<option disabled selected value> -- Seleccione un Item -- </option>
					@foreach ($items as $item)
					<option value="{{$item->id}}" code="{{$item->id}}" name="{{$item->nombre}}">({{substr($item->career->nombre, 0, 3)}}) {{$item->nombre}}</option>
					@endforeach
				</select>
			</td>
			<td class="quantity">
				<input name="cantidad[]" type="number" class="form-control col-xs-1 quant" value="1" disabled required>
			</td>
			<td class="remove">
				<button type="button" class="btn btn-danger" disabled>X</button>
			</td>
		</tbody>
	</table>
</div>