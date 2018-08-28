@extends('layouts.admin')
@section('content')
<?php $editar=false; $eliminar=false;
foreach (Auth::user()->role->functionalities as $func) {
	if ($func->code=='EEXONL'){ $editar=true; }
	if ($func->code=='DEXONL'){ $eliminar=true; }
}
?>
<div class="table-responsive">
	<table class="table table-hover tablaNoOrder compact">
		<thead>
			<th>Carrera</th>
			<th>Materias</th>
			@if ($editar)<th>Preguntas</th>@endif
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
				@if ($editar)
				<td>
					{!!link_to_route('admin.exam.edit', $title = 'Preguntas', $parameters = $career->id, $attributes = ['class'=>'btn btn-success'])!!}
				</td>
				@endif
				@if ($eliminar)
				<td>
					{!!link_to_route('admin.exam.show', $title = 'Borrar', $parameters = $career->id, $attributes = ['class'=>'btn btn-danger'])!!}
				</td>
				@endif
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
@endsection