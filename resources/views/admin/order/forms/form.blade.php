<div id="alert_same" class="alert alert-danger alert-dismissible" role="alert" style="display: none">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<strong>Atención!</strong><br>Acabas de seleccionar el mismo item.
</div>
<br>
<input type="hidden" name="_token" id="token" value="{{csrf_token()}}">
{!! Form::hidden('people_id',null,['id'=>'people_id']) !!}
<div class="form-group" style="padding: 0;">
	{!! Form::label('Nombre Comprador*') !!}
	{!! Form::text('nombre',null,['class'=>'form-control','placeholder'=>'Nombre completo (Comprador)','required','maxlength'=>200,'id'=>'comprador','autocomplete'=>'off','style'=>'text-transform: uppercase;']) !!}
	<div id="lista_compradores" class="hide focus">
		<ul>
		</ul>
	</div>
</div>
<div class="form-group">
	{!! Form::label('Telefono') !!}
	{!! Form::text('telefono',null,['class'=>'form-control','placeholder'=>'Inserte Telefono','maxlength'=>100]) !!}
</div>
<div class="form-group">
	{!! Form::label('Observaciones') !!}
	{!! Form::text('detalle',null,['class'=>'form-control','placeholder'=>'Observaciones o Comentarios','maxlength'=>255]) !!}
</div>
<div class="panel panel-info">
	<div class="panel-heading">Selección de items</div>
	<table class="table table-condensed">
		<thead>
			<th>(Codigo) Nombre</th>
			<th>P/Unitario</th>
			<th>Cantidad</th>
			<th>Importe</th>
			<th>Quitar</th>
		</thead>
		<tbody>
			<td>
				<select name="item[]" class="selectpicker sel_itm last_sel" required data-live-search="true">
					<option disabled selected value> -- Seleccione un Item -- </option>
					@foreach ($items as $item)
					<option value="{{$item->id}}" code="{{$item->id}}" name="{{$item->nombre}}" stock="{{$item->stock}}" price="{{$item->precio}}">({{substr($item->career->nombre, 0, 3)}}) {{$item->nombre}} ({{$item->stock}} Unid.) ({{$item->precio}} Bs.)</option>
					@endforeach
				</select>
			</td>
			<td>
				<span class="price"></span><span> Bs.</span>
			</td>
			<td class="quantity">
				<input name="cantidad[]" min="0" max="100" type="number" class="form-control col-xs-1 quant" value="1" disabled required>
			</td>
			<td>
				<span class="subtotal"></span><span> Bs.</span>
			</td>
			<td class="remove">
				<button type="button" disabled class="btn btn-danger remove_btn">X</button>
			</td>
		</tbody>
		<tbody class="total_body" style="font-size: 21px;">
			<td></td>
			<td><b>Total:</b></td>
			<td></td>
			<td>
				<b><span id="total">0</span><span> Bs.</span></b>
			</td>
			<td></td>
		</tbody>
	</table>
	<table class="table" style="display: none;">
		<tbody id="new_item">
			<td>
				<select name="item[]" class="sel_itm" data-live-search="true">
					<option disabled selected value> -- Seleccione un Item -- </option>
					@foreach ($items as $item)
					<option value="{{$item->id}}" code="{{$item->id}}" name="{{$item->nombre}}" stock="{{$item->stock}}" price="{{$item->precio}}">({{substr($item->career->nombre, 0, 3)}}) {{$item->nombre}} ({{$item->stock}} Unid.) ({{$item->precio}} Bs.)</option>
					@endforeach
				</select>
			</td>
			<td>
				<span class="price"></span><span> Bs.</span>
			</td>
			<td class="quantity">
				<input name="cantidad[]" min="0" max="100" type="number" class="form-control col-xs-1 quant" value="1" disabled required>
			</td>
			<td>
				<span class="subtotal"></span> <span> Bs.</span>
			</td>
			<td class="remove">
				<button type="button" class="btn btn-danger" disabled>X</button>
			</td>
		</tbody>
	</table>
</div>
<div class="form-group col-sm-9"></div>
<div class="form-group col-sm-3">
	<span>Descuento en Bs:</span>
	<div class="input-group">
		<span class="input-group-addon" id="basic-addon1">$</span>
		{!! Form::number('descuento',0,['class'=>'form-control','min'=>'0','max'=>'20','id'=>'global_discount']) !!}
	</div>
</div>
<div class="col-sm-8"></div>
<div class="col-sm-4">
	<div id="showtot" style="display: none;">
		<label class="col-sm-4" style="font-size: 24px;">TOTAL:</label>
		<div class="col-sm-8" style="font-size: 24px;">
			<b><span id="total_global">0</span><span> Bs.</span></b>
		</div>
	</div>
</div>
<style>
	#lista_compradores{
		width: auto;
		border: 1px solid #D1D1D1;
	}
	#lista_compradores ul{
		list-style-type: none;
		padding: 0; margin: 0;
	}
	#lista_compradores ul li{
		height: 40px;
	}
	#lista_compradores ul li:hover{
		background-color: #E8E8E8;
		cursor: pointer;
	}
	#lista_compradores ul li div{
		padding: 8px 0 0 10px;
	}
</style>