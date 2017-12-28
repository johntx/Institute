<!DOCTYPE html>
<html lang="es" ondragstart="return false">
<!-- oncontextmenu="return false"  onselectstart="return false" -->
<head>
	<title>Instituto C1EN</title>
	<meta charset="utf-8">
	<meta name = "format-detection" content = "telephone=no" />
	<link rel="icon" type="image/png" href="{!!URL::to('icons/logomin.png')!!}" />
	{!!Html::style('css/header.css')!!}
	@yield('css')
</head>
<header>
	<div>
		<img src="{!!URL::to('icons/logo.svg')!!}">
	</div>
	<ul>
		<li><a href="#">Inicio</a></li>
		<li><a href="#">Nosotros</a></li>
		<li><div>Carreras</div></li>
		@if(!Auth::user())
		<li><div class="log">Log In</div></li>
		@else
		<li><a href="admin">{{ Auth::user()->user }}</a></li>
		@endif
	</ul>
</header>
@include('modal.login')
<body>
	@yield('body')
</body>
{!!Html::script('js/jquery.js')!!}
{!!Html::script('js/jquery-ui.min.js')!!}
{!!Html::script('js/header.js')!!}
@yield('js')
</html>