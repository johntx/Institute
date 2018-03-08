<!DOCTYPE html>
<html lang="es" ondragstart="return false">
<!-- oncontextmenu="return false"  onselectstart="return false" -->
<head>
	<title>Recivo Venta #{{$order->id}}</title>
	<meta charset="utf-8">
	<meta name = "format-detection" content = "telephone=no" />
	<link rel="icon" type="image/png" href="{!!URL::to('icons/logomin.png')!!}" />
	{!! Html::style('css/pdf_venta.css') !!}
</head>

<body>
	<div class="recivo original">
		<div>
			<img class="agua" src="{!!URL::to('icons/agua.svg')!!}">
			<div class="top">
				<img src="{!!URL::to('icons/c1en.svg')!!}">
				<h1>RECIBO</h1>
				<div>
					<span> <em> <b>Nº</b> {{$order->id}}</em></span>
				</div>
			</div>
			<div class="mid">
				<div>
					<div>
						<span><b>Señor(es):</b> {{$order->nombre}}</span>
					</div>
					<div>
						<table>
							<tbody>
								<tr>
									<th>Nº</th>
									<th>Descripción</th>
									<th>Precio/U</th>
									<th>Cantidad</th>
									<th>Importe</th>
								</tr>
								@foreach ($order->buylists as $n=>$buylist)
								<tr>
									<td>{{$n+1}}</td>
									<td class="nombre_item">{{$buylist->item->nombre}}</td>
									<td>{{$buylist->item->precio}}</td>
									<td>{{$buylist->cantidad}}</td>
									<td>{{number_format($buylist->cantidad*$buylist->item->precio, 2,'.','')}}</td>
								</tr>
								@endforeach
								@if ($order->total!=$order->subtotal)
								<tr>
									<td style="border: none;"></td>
									<td style="border: none;"></td>
									<th colspan="2" style="border: 1px solid; text-align: left;">Subtotal: </th>
									<td><strike>{{$order->subtotal}}</strike></td>
								</tr>
								<tr>
									<td style="border: none;"></td>
									<td style="border: none;"></td>
									<th colspan="2" style="border: 1px solid; text-align: left;">Descuento en Bs.: </th>
									<td>{{$order->descuento}}</td>
								</tr>
								@endif
								<tr style="font-size: 16px !important;">
									<td style="border: none;"></td>
									<td style="border: none;"></td>
									<th colspan="2" style="border: 1px solid; text-align: left;">Total: </th>
									<td>{{$order->total}}</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="city">
						<span class="ciudad"><b>Cochabamba</b> {{Jenssegers\Date\Date::now()->format('j \d\e F \d\e Y')}}</span>
					</div>
				</div>
			</div>
		</div>
		<span class="user">{{\Institute\User::find($order->user_id)->people->iniciales()}}</span>
	</div>
	<div id="separador"></div>
	<div class="recivo copia">
		<div>
			<img class="agua" src="{!!URL::to('icons/agua.svg')!!}">
			<div class="top">
				<img src="{!!URL::to('icons/c1en.svg')!!}">
				<h1>RECIBO</h1>
				<div>
					<span> <em> <b>Nº</b> {{$order->id}}</em></span>
				</div>
			</div>
			<div class="mid">
				<div>
					<div>
						<span><b>Señor(es):</b> {{$order->nombre}}</span>
					</div>
					<div>
						<table>
							<tbody>
								<tr>
									<th>Nº</th>
									<th>Descripción</th>
									<th>Precio/U</th>
									<th>Cantidad</th>
									<th>Importe</th>
								</tr>
								@foreach ($order->buylists as $n=>$buylist)
								<tr>
									<td>{{$n+1}}</td>
									<td class="nombre_item">{{$buylist->item->nombre}}</td>
									<td>{{$buylist->item->precio}}</td>
									<td>{{$buylist->cantidad}}</td>
									<td>{{number_format($buylist->cantidad*$buylist->item->precio, 2,'.','')}}</td>
								</tr>
								@endforeach
								@if ($order->total!=$order->subtotal)
								<tr>
									<td style="border: none;"></td>
									<td style="border: none;"></td>
									<th colspan="2" style="border: 1px solid; text-align: left;">Subtotal: </th>
									<td><strike>{{$order->subtotal}}</strike></td>
								</tr>
								<tr>
									<td style="border: none;"></td>
									<td style="border: none;"></td>
									<th colspan="2" style="border: 1px solid; text-align: left;">Descuento en Bs.: </th>
									<td>{{$order->descuento}}</td>
								</tr>
								@endif
								<tr style="font-size: 16px !important;">
									<td style="border: none;"></td>
									<td style="border: none;"></td>
									<th colspan="2" style="border: 1px solid; text-align: left;">Total: </th>
									<td>{{$order->total}}</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="city2">
						<span class="ciudad"><b>Cochabamba</b> {{Jenssegers\Date\Date::now()->format('j \d\e F \d\e Y')}}</span>
					</div>
				</div>
			</div>
		</div>
		<span class="user2">{{\Institute\User::find($order->user_id)->people->iniciales()}}</span>
	</div>
</body>
</html>
<style>
	.recivo>div>.mid table{
		@if (sizeof($order->buylists)>6)
			@if (sizeof($order->buylists)>8)
				@if (sizeof($order->buylists)>10)
					@if (sizeof($order->buylists)>12)
					font-size: 7px;
					@else
					font-size: 9px;
					@endif
				@else
				font-size: 11px;
				@endif
			@else
			font-size: 14px;
			@endif
		@else
		font-size: 16px;
		@endif
	}
</style>