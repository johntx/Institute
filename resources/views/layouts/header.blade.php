<!DOCTYPE html>
<html lang="es" ondragstart="return false">
<!-- oncontextmenu="return false"  onselectstart="return false" -->
<head>
	<title>Instituto</title>
	<meta charset="utf-8">
	<meta name = "format-detection" content = "telephone=no" />
	<link rel="icon" type="image/png" href="#" />
	{!!Html::style('css/header.css')!!}
	@yield('css')
</head>
<header>
	<div>
		<img src="{!!URL::to('icons/logo.svg')!!}">
	</div>
	<ul>
		<li><a href="#">Opcion</a></li>
		<li><a href="#">Opcion</a></li>
		<li><div>Opcion</div></li>
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