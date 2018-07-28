<br>
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
			<th>Stock</th>
			<th>Cantidad</th>
			<th>P/Unitario</th>
			<th>Importe</th>
		</thead>
		<tbody>
			@foreach ($career->items as $item)
			<tr class="{{$item->id}}" @if ($item->stock==0) style="background-color: #E09696;" @endif>
				<td>
				{!! Form::label($item->id,"(".substr($item->career->nombre, 0, 3).") ".$item->nombre,['style'=>'padding:8px; width:100%;','class'=>'check_item','item'=>$item->id]) !!}
					
					<input type="hidden" name="item[]" value="{{$item->id}}" disabled class="{{$item->id}}">
				</td>
				<td>
					<input type="checkbox" id="{{$item->id}}" item="{{$item->id}}" class="check_item" name="cancelado" style="width: 100%; height: 35px;" @if ($item->stock==0) disabled @endif>
				</td>
				<td>
					[<b><span class="stock">{{$item->stock}}</span><span>&nbsp; Un.</span></b>]
				<td>
					<span class="price {{$item->id}}">{{$item->precio}}</span><span> Bs.</span>
				</td>
				<td class="quantity">
					<input name="cantidad[]" min="0" max="{{$item->stock}}" type="number" class="form-control col-xs-1 quant {{$item->id}}" item="{{$item->id}}" @if ($item->stock>0) value="1" @else value="0" @endif  required disabled>
				</td>
				<td>
					<span class="subtotal {{$item->id}}"></span><span> Bs.</span>
				</td>
			</tr>
			@endforeach
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
</div>
<div class="form-group col-sm-9"></div>
<div class="form-group col-sm-3">
	<span>Descuento en Bs:</span>
	<div class="input-group">
		<span class="input-group-addon" id="basic-addon1">$</span>
		{!! Form::number('descuento',0,['class'=>'form-control','id'=>'global_discount','autocomplete'=>'off']) !!}
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