<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Log In</title>
  {!!Html::style('css/bootstrap.min.css')!!}
  {!!Html::style('css/metisMenu.min.css')!!}
  {!!Html::style('css/sb-admin-2.css')!!}
  {!!Html::style('css/font-awesome.min.css')!!}
  {!!Html::style('css/admin.css')!!}
</head>
<body>
  @include('alerts.message')
  @include('alerts.status')
  @include('alerts.errors')
  <div class="container">
    <div class="row">
      <div class="col-md-4 col-md-offset-4">
        <div class="login-panel panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Log In</h3>
          </div>
          <div class="panel-body">
            @include('user/forms.log')
            <br>
            <span>{!!link_to('password/email', $title = 'Olvidaste tu contraseña?',$attributes=null,$secure=null)!!}</span>
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
