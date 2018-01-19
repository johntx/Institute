<!DOCTYPE html>
<html lang="es" ondragstart="return false">
<!-- oncontextmenu="return false"  onselectstart="return false" -->
<head>
	<title>Recivo #{{$payment->id}}</title>
	<meta charset="utf-8">
	<meta name = "format-detection" content = "telephone=no" />
	<link rel="icon" type="image/png" href="{!!URL::to('icons/logomin.png')!!}" />
	{!! Html::style('css/recivo.css') !!}
</head>
<?php
if($payment->inscription->fecha_ingreso > $payment->inscription->group->startclass->fecha_inicio)
	$fecha_ingreso=$payment->inscription->fecha_ingreso;
else
	$fecha_ingreso=$payment->inscription->group->startclass->fecha_inicio;
?>
<body>
	<div class="recivo original">
		<div>
			<img class="agua" src="{!!URL::to('icons/agua.svg')!!}">
			<div class="top">
				<img src="{!!URL::to('icons/c1en.svg')!!}">
				<h1>RECIBO</h1>
				<div>
					<span> <em> <b>Nº</b> {{$payment->id}}</em></span>
					<span class="abono"><b>Bs.</b> {{$payment->abono}}</span>
				</div>
			</div>
			<div class="mid">
				<div>
					<div>
						<span><b>Recibí de:</b> {{$payment->inscription->people->nombrecompleto()}}</span>
					</div>
					<div>
						<span><b>La suma de:</b> {{$suma}} BOLIVIANOS 00/100</span>
					</div>
					<div>
						<span><b>Por concepto de:</b> CURSO "{{$payment->inscription->group->startclass->career->nombre}} {{$payment->inscription->group->startclass->descripcion}}"</span>
					</div>
					<div>
						<span class="turno"><b>Turno:</b> {{$payment->inscription->group->turno}}</span>
						<span class="inicio"><b>Inicio:</b> {{Jenssegers\Date\Date::parse($fecha_ingreso)->format('j \d\e F \d\e Y')}}</span>
					</div>
					<div>
						<span class="total"><b>Total:</b> {{$payment->saldo}}</span>
						<span class="acuenta"><b>A cuenta:</b> {{$payment->abono}}</span>
						<span class="saldo"><b>Saldo:</b> {{$payment->saldo-$payment->abono}}</span>
					</div>
					<div>
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
				<h1>RECIBO</h1>
				<div>
					<span><em><b>Nº</b> {{$payment->id}}</em></span>
					<span class="abono"><b>Bs.</b> {{$payment->abono}}</span>
				</div>
			</div>
			<div class="mid">
				<div>
					<div>
						<span><b>Recibí de:</b> {{$payment->inscription->people->nombrecompleto()}}</span>
					</div>
					<div>
						<span><b>La suma de:</b> {{$suma}} BOLIVIANOS 00/100</span>
					</div>
					<div>
						<span><b>Por concepto de:</b> CURSO "{{$payment->inscription->group->startclass->career->nombre}} {{$payment->inscription->group->startclass->descripcion}}"</span>
					</div>
					<div>
						<span class="turno"><b>Turno:</b> {{$payment->inscription->group->turno}}</span>
						<span class="inicio"><b>Inicio:</b> {{Jenssegers\Date\Date::parse($fecha_ingreso)->format('j \d\e F \d\e Y')}}</span>
					</div>
					<div>
						<span class="total"><b>Total:</b> {{$payment->saldo}}</span>
						<span class="acuenta"><b>A cuenta:</b> {{$payment->abono}}</span>
						<span class="saldo"><b>Saldo:</b> {{$payment->saldo-$payment->abono}}</span>
					</div>
					<div>
						<span class="ciudad"><b>Cochabamba</b> {{Jenssegers\Date\Date::now()->format('j \d\e F \d\e Y')}}</span>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
