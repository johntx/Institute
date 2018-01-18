<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Instituto C1EN</title>
  <link rel="icon" type="image/png" href="{!!URL::to('icons/logomin.png')!!}" />
  {!!Html::style('css/bootstrap.min.css')!!}
  {!!Html::style('css/jquery-ui.min.css')!!}
  {!!Html::style('css/metisMenu.min.css')!!}
  {!!Html::style('css/sb-admin-2.css')!!}
  {!!Html::style('css/font-awesome.min.css')!!}
  {!!Html::style('css/bootstrap-select.css')!!}
  {!!Html::style('css/datatables.css')!!}
  {!!Html::style('css/admin.css')!!}
  @yield('admincss')
</head>
<body>
@include('alerts.succes')
  <div id="wrapper">
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
      <div class="navbar-header">
        <a class="navbar-brand">
          <img alt="C1EN" src="{!!URL::to('icons/brand.svg')!!}" height="18px">
        </a>
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="sr-only">Menu</span>
        </button>
        <a style="padding-left: 0" class="navbar-brand" href="{!!URL::to('admin')!!}">Admin Instituto C1EN</a>
      </div>
      <form class="navbar-form navbar-left" id="form_buscador" role="search">
        <div class="form-group input-group input-group-sm">
          <span class="input-group-addon" id="sizing-addon1">
            <i class="fa fa-search fa-fw"></i>
          </span>
          <input type="text" id="buscador" class="form-control focus" placeholder="Buscar..">
          <span class="input-group-btn">
            <button class="btn btn-default" id="close_searcher" type="button">
              <i class="fa fa-close fa-fw"></i>
            </button>
          </span>
        </div>
        <div id="ebuscados" class="hide focus">
          <ul>
          </ul>
        </div>
      </form>
      <ul class="nav navbar-top-links navbar-right">
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">{{Auth::user()->user}} <b>/{{Auth::user()->role->name}}</b><i class="fa fa-user fa-fw"></i><i class="fa fa-caret-down"></i>
          </a>
          <ul class="dropdown-menu dropdown-user">
            <li><a href="{!!URL::to('logout')!!}"><i class="fa fa-sign-out fa-fw"></i> Cerrar Sesion</a>
            </li>
            <li><a href="{!!URL::to('pass/changePasswordForm')!!}"><i class="fa fa-edit fa-fw"></i> Cambiar Contraseña</a>
            </li>
          </ul>
        </li>
      </ul>
      <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
          <ul class="nav" id="side-menu">
            @foreach(\Institute\Functionality::Join('privileges', 'privileges.functionality_id', '=', 'functionalities.id')
              ->Join('roles', 'privileges.role_id', '=', 'roles.id')
              ->Join('menus', 'functionalities.menu_id', '=', 'menus.id')
              ->select('menus.*')
              ->where('roles.code',Auth::user()->role->code)
              ->distinct()->orderBy('id','asc')->get()
              as $menu)
              <li>
                <a href="#"><i class="fa fa-{{ $menu->icon }} fa-fw"></i> {{ $menu->label }}<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                  @foreach(
                    \Institute\Functionality::Join('privileges', 'privileges.functionality_id', '=', 'functionalities.id')
                    ->Join('roles', 'privileges.role_id', '=', 'roles.id')
                    ->Join('menus', 'functionalities.menu_id', '=', 'menus.id')
                    ->select('functionalities.*')
                    ->where('menus.code',$menu->code)
                    ->where('roles.code',Auth::user()->role->code)
                    ->where('functionalities.path','not like','%edit')
                    ->where('functionalities.path','not like','%delete')
                    ->distinct()->orderBy('id','asc')->get()
                    as $functionality)
                    <li>
                      <a href="{{URL::to($functionality->path)}}"><i class='fa fa-circle-o fa-fw'></i> {{ $functionality->label }}</a>
                    </li>
                    @endforeach
                  </ul>
                </li>
                @endforeach
              </ul>
            </div>
          </div>
        </nav>
        <div id="page-wrapper">
          @yield('content')
        </div>
      </div>
      {!!Html::script('js/jquery.js')!!}
      {!!Html::script('js/jquery-ui.min.js')!!}
      {!!Html::script('js/bootstrap.min.js')!!}
      {!!Html::script('js/metisMenu.min.js')!!}
      {!!Html::script('js/sb-admin-2.js')!!}
      {!!Html::script('js/admin.js')!!}
      {!!Html::script('js/bootstrap-select.js')!!}
      {!!Html::script('js/datatables.js')!!}
      {!!Html::script('js/mdb.js')!!}
      @yield('adminjs')
    </body>
    </html>
