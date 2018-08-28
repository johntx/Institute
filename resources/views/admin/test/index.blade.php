@extends('layouts.admin')
@section('content')
<?php $editar=false; $eliminar=false;
foreach (Auth::user()->role->functionalities as $func) {
	if ($func->code=='ETST'){ $editar=true; }
	if ($func->code=='DTST'){ $eliminar=true; }
}
?>
<div class="table-responsive">
	<table class="table table-hover tablaNoOrder compact">
		<thead>
			<th>Carrera</th>
			<th>Materias</th>
			@if ($eliminar)<th>Módulos</th>@endif
			@if ($editar)<th>Modificar</th>@endif
		</thead>
		<tbody>
			@foreach($careers as $career)
			<tr>
				<td>{{$career->nombre}}</td>
				<td style="font-size: 12px;">
					@foreach ($career->subjects as $subject)
						[{{$subject->nombre[0]}}{{$subject->nombre[1]}}{{$subject->nombre[2]}}] 
					@endforeach
				</td>
				@if ($eliminar)
				<td>
					{!!link_to_route('admin.test.show', $title = 'Ver', $parameters = $career->id, $attributes = ['class'=>'btn btn-success'])!!}
				</td>
				@endif
				@if ($editar)
				<td>
					{!!link_to_route('admin.test.edit', $title = 'Registro', $parameters = $career->id, $attributes = ['class'=>'btn btn-primary'])!!}
				</td>
				@endif
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
@endsection