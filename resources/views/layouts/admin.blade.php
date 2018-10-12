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
  @include('alerts.success')
  @include('alerts.alert')
  @include('alerts.error')
  <div id="wrapper">
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0;">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="sr-only">Menu</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand">
          <img alt="C1EN" src="{!!URL::to('icons/brand.svg')!!}" height="18px">
        </a>
        <a style="padding-left: 0;" class="navbar-brand" href="{!!URL::to('admin')!!}"><i class="fa fa-refresh fa-fw"></i> Admin Instituto C1EN</a>
      </div>
      @if (Auth::user()->role->code != 'EST' && Auth::user()->role->code != 'DOC')
      <div class="col-xs-3 input-group input-group-sm navbar-left" style="padding: 10px 0 0 20px;">
        <span class="input-group-addon" id="sizing-addon1">
          <i class="fa fa-search fa-fw"></i>
        </span>
        <select class="form-control selectpicker" data-live-search="true" data-size="15" id="select_buscador">
          <option disabled selected>Buscar..</option>
          @foreach (\Institute\Inscription::distinct('people_id')->get() as $inscription)
          <option 
          value="{{$inscription->people->id}}">
          ({{$inscription->people->id}}) - {{$inscription->people->nombrecompleto()}} - ({{$inscription->group->startclass->career->nombre}}) - [{{$inscription->people->telefono}}]</option>
          @endforeach
        </select>
        <span class="input-group-btn">
          <a href="" class="btn btn-default" id="ver_search" enlace="{!!url('admin/student/search/')!!}/">
            <i class="fa fa-eye fa-fw" style="padding-top: 2.5px;"></i>
          </a>
          <a href="" class="btn btn-default" id="edit_search" enlace="{!!url('admin/student/')!!}/">
            <i class="fa fa-pencil fa-fw" style="padding-top: 2.5px;"></i>
          </a>
        </span>
      </div>
      @endif
      <ul class="nav navbar-top-links navbar-right">
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">{{Auth::user()->user}} ({{Auth::user()->people->nombre}}) <b>/{{Auth::user()->role->name}}</b><i class="fa fa-user fa-fw"></i><i class="fa fa-caret-down"></i>
          </a>
          <ul class="dropdown-menu dropdown-user">
            <li><a href="{!!URL::to('logout')!!}"><i class="fa fa-sign-out fa-fw"></i> Cerrar Sesion</a>
            </li>
            @if (Auth::user()->role->code != 'EST' && Auth::user()->role->code != 'DOC')
            <li><a href="{!!URL::to('pass/changePasswordForm')!!}"><i class="fa fa-edit fa-fw"></i> Cambiar Contraseña</a>
            </li>
            @endif
          </ul>
        </li>
      </ul>
      <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
          <ul class="nav" id="side-menu">
            @foreach(\Institute\Functionality::Join('privileges', 'privileges.functionality_id', '=', 'functionalities.id')->Join('roles', 'privileges.role_id', '=', 'roles.id')->Join('menus', 'functionalities.menu_id', '=', 'menus.id')->select('menus.*')->where('roles.code',Auth::user()->role->code)->distinct()->orderBy('id','asc')->get() as $menu)
            <li>
              <a href="#"><i class="fa fa-{{ $menu->icon }} fa-fw"></i> {{ $menu->label }}<span class="fa arrow"></span></a>
              <ul class="nav nav-second-level">
                @foreach(
                \Institute\Functionality::Join('privileges', 'privileges.functionality_id', '=', 'functionalities.id')->Join('roles', 'privileges.role_id', '=', 'roles.id')->Join('menus', 'functionalities.menu_id', '=', 'menus.id')->select('functionalities.*')->where('menus.code',$menu->code)->where('roles.code',Auth::user()->role->code)->where('functionalities.path','not like','%edit')->where('functionalities.path','not like','%delete')->distinct()->orderBy('id','asc')->get() as $functionality)
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
  @yield('adminjs2')
</body>
</html>
