@extends('layouts.admin')
@section('content')
@include('alerts.succes')
<div class="table-responsive">
	<table class="table table-hover">
		<thead>
			<th>Id</th>
			<th>Nombre</th>
			<th>Precio</th>
			<th>Edit</th>
		</thead>
		@foreach($extras as $extra)
		<tbody>
			<td>{{$extra->id}}</td>
			<td>{{$extra->nombre}}</td>
			<td>{{$extra->precio}}</td>
			@foreach(Auth::user()->role->functionalities as $func)
			@if ($func->code=='EEXT')
			<td>
				{!!link_to_route('admin.extra.edit', $title = 'Editar', $parameters = $extra->id, $attributes = ['class'=>'btn btn-primary'])!!}
			</td>
			@endif
			@if ($func->code=='DEXT')
			<td>
				{!!link_to_route('admin.extra.show', $title = 'Borrar', $parameters = $extra->id, $attributes = ['class'=>'btn btn-danger'])!!}
			</td>
			@endif
			@endforeach
		</tbody>
		@endforeach
	</table>
</div>
{!!$extras->render()!!}
@endsection