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
<body>
	<div class="recivo original">
		<div>
			<img class="agua" src="{!!URL::to('icons/agua.svg')!!}">
			<div class="top">
				<img src="{!!URL::to('icons/c1en.svg')!!}">
				<h1>RECIBO</h1>
				<div>
					<span><b>Nº</b> {{$payment->id}}</span>
					<span class="abono"><b>Bs.</b> {{$payment->abono}}</span>
				</div>
			</div>
			<div class="mid">
				<div>
					<div>
						<span><b>Recibí de:</b> {{$payment->inscription->people->nombrecompleto()}}</span>
					</div>
					<div>
						<span><b>La suma de:</b> {{$suma}} 00/100</span>
					</div>
					<div>
						<span><b>Por concepto de:</b> CURSO "{{$payment->inscription->career->nombre}}"</span>
					</div>
					<div>
						<span class="turno"><b>Turno:</b> {{$payment->inscription->group->turno}}</span>
						<span class="inicio"><b>Inicio:</b> {{$fecha_inicio}}</span>
					</div>
					<div>
						<span class="total"><b>Total:</b> {{$payment->abono}}</span>
						<span class="acuenta"><b>A cuenta:</b> {{$payment->saldo}}</span>
						<span class="saldo"><b>Saldo:</b> {{$payment->saldo-$payment->abono}}</span>
					</div>
					<div>
						<span class="ciudad"><b>Cochabamba</b> {{$fecha_actual}}</span>
					</div>
						<span class="entregue_ line">----------------------------------------</span>
						<span class="recibi_ line">----------------------------------------</span>
					<div>
						<span class="entregue"><b>Entregue conforme</b></span>
						<span class="recibi"><b>Recibí conforme</b></span>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="recivo copia">
		<div>
			<img class="agua" src="{!!URL::to('icons/agua.svg')!!}">
			<div class="top">
				<img src="{!!URL::to('icons/c1en.svg')!!}">
				<h1>RECIBO</h1>
				<div>
					<span><b>Nº</b> {{$payment->id}}</span>
					<span class="abono"><b>Bs.</b> {{$payment->abono}}</span>
				</div>
			</div>
			<div class="mid">
				<div>
					<div>
						<span><b>Recibí de:</b> {{$payment->inscription->people->nombrecompleto()}}</span>
					</div>
					<div>
						<span><b>La suma de:</b> {{$suma}} 00/100</span>
					</div>
					<div>
						<span><b>Por concepto de:</b> CURSO "{{$payment->inscription->career->nombre}}"</span>
					</div>
					<div>
						<span class="turno"><b>Turno:</b> {{$payment->inscription->group->turno}}</span>
						<span class="inicio"><b>Inicio:</b> {{$fecha_inicio}}</span>
					</div>
					<div>
						<span class="total"><b>Total:</b> {{$payment->abono}}</span>
						<span class="acuenta"><b>A cuenta:</b> {{$payment->saldo}}</span>
						<span class="saldo"><b>Saldo:</b> {{$payment->saldo-$payment->abono}}</span>
					</div>
					<div>
						<span class="ciudad"><b>Cochabamba</b> {{$fecha_actual}}</span>
					</div>
						<span class="entregue_ line">----------------------------------------</span>
						<span class="recibi_ line">----------------------------------------</span>
					<div>
						<span class="entregue"><b>Entregue conforme</b></span>
						<span class="recibi"><b>Recibí conforme</b></span>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
