@extends('layouts.admin')
@section('content')
@include('alerts.succes')
<?php $editar=false; $eliminar=false; ?>
@foreach(Auth::user()->role->functionalities as $func)
@if ($func->code=='EMEN')
<?php $editar=true; ?>
@endif
@if ($func->code=='DMEN')
<?php $eliminar=true; ?>
@endif
@endforeach
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
			@if ($editar)
			<td>
				{!!link_to_route('admin.menu.edit', $title = 'Editar', $parameters = $menu->id, $attributes = ['class'=>'btn btn-primary'])!!}
			</td>
			@endif
			@if ($eliminar)
			<td>
				{!!link_to_route('admin.menu.show', $title = 'Borrar', $parameters = $menu->id, $attributes = ['class'=>'btn btn-danger'])!!}
			</td>
			@endif
		</tbody>
		@endforeach
	</table>
</div>
{!!$menus->render()!!}
@endsection