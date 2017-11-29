<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Institute</title>
  {!!Html::style('css/bootstrap.min.css')!!}
  {!!Html::style('css/jquery-ui.min.css')!!}
  {!!Html::style('css/metisMenu.min.css')!!}
  {!!Html::style('css/sb-admin-2.css')!!}
  {!!Html::style('css/font-awesome.min.css')!!}
  {!!Html::style('css/bootstrap-select.css')!!}
  {!!Html::style('css/admin.css')!!}
</head>
<body>
  <div id="wrapper">
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="{!!URL::to('admin')!!}"><i class="fa fa-database"></i> Admin Institute</a>
      </div>
      <ul class="nav navbar-top-links navbar-right">
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">{{Auth::user()->user}} <b>/{{Auth::user()->role->name}}</b><i class="fa fa-user fa-fw"></i><i class="fa fa-caret-down"></i>
          </a>
          <ul class="dropdown-menu dropdown-user">
            <li><a href="{!!URL::to('logout')!!}"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
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
              ->distinct()->get()
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
                    ->distinct()->get()
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
  </script>
</body>
</html>
