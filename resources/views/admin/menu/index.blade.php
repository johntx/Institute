@extends('layouts.admin')
@section('content')
@include('alerts.succes')
<div class="table-responsive">
<table class="table table-hover">
	<thead>
		<th>Id</th>
		<th>Code</th>
		<th>Label</th>
		<th>Icon</th>
		<th>Edit</th>
	</thead>
	@foreach($menus as $menu)
	<tbody>
		<td>{{$menu->id}}</td>
		<td>{{$menu->code}}</td>
		<td>{{$menu->label}}</td>
		<td><i class="fa fa-{{$menu->icon}} fa-fw"></i></td>
		@foreach(Auth::user()->role->functionalities as $func)
		@if ($func->code=='EMEN')
		<td>
			{!!link_to_route('admin.menu.edit', $title = 'Editar', $parameters = $menu->id, $attributes = ['class'=>'btn btn-primary'])!!}
		</td>
		@endif
		@if ($func->code=='DMEN')
		<td>
			{!!link_to_route('admin.menu.show', $title = 'Borrar', $parameters = $menu->id, $attributes = ['class'=>'btn btn-danger'])!!}
		</td>
		@endif
		@endforeach
	</tbody>
	@endforeach
</table>
</div>
{!!$menus->render()!!}
@endsection