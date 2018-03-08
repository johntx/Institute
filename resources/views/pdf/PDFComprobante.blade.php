<!DOCTYPE html>
<html lang="es" ondragstart="return false">
<!-- oncontextmenu="return false"  onselectstart="return false" -->
<head>
	<title>Recivo Venta #{{$income->id}}</title>
	<meta charset="utf-8">
	<meta name = "format-detection" content = "telephone=no" />
	<link rel="icon" type="image/png" href="{!!URL::to('icons/logomin.png')!!}" />
	{!! Html::style('css/pdf_comprobante.css') !!}
</head>

<body>
	<div class="recivo original">
		<div>
			<img class="agua" src="{!!URL::to('icons/agua.svg')!!}">
			<div class="top">
				<img src="{!!URL::to('icons/c1en.svg')!!}">
				<h1>INGRESO DE ITEMS</h1>
				<div>
					<span> <em> <b>Nº</b> {{$income->id}}</em></span>
				</div>
			</div>
			<div class="mid">
				<div>
					<div>
						<span><b>Usuario:</b> {{$income->user->people->nombrecompleto()}}</span>
					</div>
					<div>
						<table>
							<tbody>
								<tr>
									<th>Nº</th>
									<th>Descripción</th>
									<th>Cantidad</th>
								</tr>
								@foreach ($income->incomelists as $n=>$incomelist)
								<tr>
									<td>{{$n+1}}</td>
									<td class="nombre_item">{{$incomelist->item->nombre}}</td>
									<td>{{$incomelist->cantidad}}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
					<div class="city">
						<span class="ciudad"><b>Cochabamba</b> {{Jenssegers\Date\Date::now()->format('j \d\e F \d\e Y')}}</span>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="separador"></div>
	<div class="recivo copia">
		<div>
			<img class="agua" src="{!!URL::to('icons/agua.svg')!!}">
			<div class="top">
				<img src="{!!URL::to('icons/c1en.svg')!!}">
				<h1>INGRESO DE ITEMS</h1>
				<div>
					<span> <em> <b>Nº</b> {{$income->id}}</em></span>
				</div>
			</div>
			<div class="mid">
				<div>
					<div>
						<span><b>Usuario:</b> {{$income->user->people->nombrecompleto()}}</span>
					</div>
					<div>
						<table>
							<tbody>
								<tr>
									<th>Nº</th>
									<th>Descripción</th>
									<th>Cantidad</th>
								</tr>
								@foreach ($income->incomelists as $n=>$incomelist)
								<tr>
									<td>{{$n+1}}</td>
									<td class="nombre_item">{{$incomelist->item->nombre}}</td>
									<td>{{$incomelist->cantidad}}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
					<div class="city2">
						<span class="ciudad"><b>Cochabamba</b> {{Jenssegers\Date\Date::now()->format('j \d\e F \d\e Y')}}</span>
					</div>
				</div>
			</div>
		</div>
		
	</div>
</body>
</html>
<style>
	.recivo>div>.mid table{
		@if (sizeof($income->incomelists)>6)
			@if (sizeof($income->incomelists)>8)
				@if (sizeof($income->incomelists)>10)
					@if (sizeof($income->incomelists)>12)
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