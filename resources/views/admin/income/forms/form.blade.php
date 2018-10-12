<br>
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
		</thead>
		<tbody>
			@foreach ($career->items as $item)
			<tr>
				<td>
					{!! Form::label($item->id,"(".substr($item->career->nombre, 0, 3).") ".$item->nombre,['style'=>'padding:8px; width:100%;','class'=>'check_item','item'=>$item->id]) !!}

					<input type="hidden" name="item[]" value="{{$item->id}}" class="{{$item->id}}">
				</td>
				<td>
					[<b><span class="stock">{{$item->stock}}</span><span>&nbsp; Un.</span></b>]
				</td>
				<td class="quantity">
					<input name="cantidad[]" type="number" class="form-control col-xs-1 quant" value="0" min="0" required>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	<input type="hidden" name="career" value="{{$career->nombre}}">
</div>