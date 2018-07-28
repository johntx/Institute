@extends('layouts.admin')
@section('content')
<?php $editar=false; $eliminar=false;
foreach (Session::get('functionalities') as $func) {
	if ($func->code=='ETST'){ $editar=true; }
	if ($func->code=='DTST'){ $eliminar=true; }
}
?>
<div class="table-responsive">
	<table class="table table-hover tablaNoOrder compact">
		<thead>
			<th>Carrera</th>
			<th>Materias</th>
			<th>Registros</th>
			@if ($editar)<th>Modificar</th>@endif
			@if ($eliminar)<th>Eliminar</th>@endif
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
				<td style="font-size: 12px;">
					@foreach ($career->tests as $test)
						[{{$test->nombre}}] 
					@endforeach
				</td>
				@if ($editar)
				<td>
					{!!link_to_route('admin.test.edit', $title = 'Registro', $parameters = $career->id, $attributes = ['class'=>'btn btn-primary'])!!}
				</td>
				@endif
				@if ($eliminar)
				<td>
					{!!link_to_route('admin.test.show', $title = 'Borrar', $parameters = $career->id, $attributes = ['class'=>'btn btn-danger'])!!}
				</td>
				@endif
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
@endsection