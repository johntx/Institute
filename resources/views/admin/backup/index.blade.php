@extends('layouts.admin')
@section('content')
<?php $eliminar=false;
foreach (Auth::user()->role->functionalities as $func) {
	if ($func->code=='DBAC'){ $eliminar=true; }
}
?>
<div class="table-responsive">
	<table class="table table-hover">
		<thead>
			<th>Id</th>
			<th>Nombre</th>
			<th>Dirección</th>
			@if ($eliminar)<th>Eliminar</th>@endif
		</thead>
		<tbody>
			@foreach($backups as $backup)
			<tr>
				<td>{{$backup->id}}</td>
				<td>{{$backup->nombre}}</td>
				<td>{{$backup->direccion}}</td>
				@if ($eliminar)
				<td>
					{!!link_to_route('admin.backup.show', $title = 'Borrar', $parameters = $backup->id, $attributes = ['class'=>'btn btn-danger'])!!}
				</td>
				@endif
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
{!!$backups->render()!!}
@endsection