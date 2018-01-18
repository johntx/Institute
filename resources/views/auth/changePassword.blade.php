<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<link rel="icon" type="image/png" href="{!!URL::to('icons/logomin.png')!!}" />
	<meta name="author" content="">
	<title>Restablecer Password</title>
	{!!Html::style('css/bootstrap.min.css')!!}
	{!!Html::style('css/metisMenu.min.css')!!}
	{!!Html::style('css/sb-admin-2.css')!!}
	{!!Html::style('css/font-awesome.min.css')!!}
	{!!Html::style('css/admin.css')!!}
</head>
<body>
	@include('alerts.request')
	<div class="container">
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<div class="login-panel panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Reset password</h3>
					</div>
					<div class="panel-body">
						<span>Inserte su antigua contraseña.</span><br><br>

						{!!Form::open(['url'=>'pass/changePassword'])!!}
						<div class="form-group">
							{!!Form::password('passwordold',['class'=>'form-control', 'placeholder'=>'Contraseña Antigua', 'required', 'maxlength'=>60])!!}
						</div>
						<span>Inserte su nueva contraseña.</span>
						<br>
						<br>
						<div class="form-group">
							{!!Form::password('password',['class'=>'form-control', 'placeholder'=>'Contraseña Nueva', 'required', 'maxlength'=>60])!!}
						</div>
						<div class="form-group">
							{!!Form::password('password_confirmation',['class'=>'form-control', 'placeholder'=>'Repetir Contraseña Nueva', 'required', 'maxlength'=>60])!!}
						</div>
						{!!Form::submit('Cambiar contraseña',['class'=>'btn btn-primary'])!!}
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
