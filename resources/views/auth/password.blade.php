<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<title>Enviar email</title>
	{!!Html::style('css/bootstrap.min.css')!!}
	{!!Html::style('css/metisMenu.min.css')!!}
	{!!Html::style('css/sb-admin-2.css')!!}
	{!!Html::style('css/font-awesome.min.css')!!}
	{!!Html::style('css/admin.css')!!}
</head>
<body>
	@include('alerts.request')
	@include('alerts.status')
	<div class="container">
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<div class="login-panel panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Send mail</h3>
					</div>
					<div class="panel-body">
						<span>Ingrese su email, se le enviará un enlace a su correo para que pueda cambiar su contraseña.</span><br><br>

						{!!Form::open(['url'=>'password/email'])!!}
						<div class="form-group">
							{!!Form::email('email',null,['class'=>'form-control', 'placeholder'=>'Email', 'required', 'maxlength'=>100,"value"=>"{{old('email')}}"])!!}
						</div>
						{!!Form::submit('Enviar',['class'=>'btn btn-primary'])!!}
						{!!Form::close()!!}
					</div>
				</div>
			</div>
		</div>
	</div>
	{!!Html::script('js/jquery.js')!!}
	{!!Html::script('js/bootstrap.min.js')!!}
	{!!Html::script('js/metisMenu.min.js')!!}
	{!!Html::script('js/sb-admin-2.js')!!}
	{!!Html::script('js/admin.js')!!}
</body>
</html>
