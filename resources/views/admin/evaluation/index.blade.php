@extends('layouts.admin')
@section('content')
<?php $editar=false; $eliminar=false; ?>
@foreach(Auth::user()->role->functionalities as $func)
@if ($func->code=='EEGR')
<?php $editar=true; ?>
@endif
@if ($func->code=='DEGR')
<?php $eliminar=true; ?>
@endif
@endforeach
<div class="table-responsive">
	<table class="table table-hover">
		<thead>
			<th>Id</th>
			<th>Fecha</th>
			<th>Docente</th>
			<th>Estudiante</th>
			<th>P1</th>
			<th>P2</th>
			<th>P3</th>
			<th>P4</th>
			<th>P5</th>
			<th>P6</th>
		</thead>
		@foreach($evaluations as $evaluation)
		<tbody>
			<td>{{$evaluation->id}}</td>
			<td>{{Jenssegers\Date\Date::parse($evaluation->fecha)->format('j M Y')}}</td>
			<td>{{$evaluation->people->nombrecompleto()}}</td>
			<td>{{$evaluation->inscription->people->nombrecompleto()}}</td>
			<td>{{$evaluation->p1}}</td>
			<td>{{$evaluation->p2}}</td>
			<td>{{$evaluation->p3}}</td>
			<td>{{$evaluation->p4}}</td>
			<td>{{$evaluation->p5}}</td>
			<td>{{$evaluation->p6}}</td>
			@if ($editar)
			<td>
				{!!link_to_route('admin.evaluation.edit', $title = 'Editar', $parameters = $evaluation->id, $attributes = ['class'=>'btn btn-primary'])!!}
			</td>
			@endif
			@if ($eliminar)
			<td>
				{!!link_to_route('admin.evaluation.show', $title = 'Borrar', $parameters = $evaluation->id, $attributes = ['class'=>'btn btn-danger'])!!}
			</td>
			@endif
		</tbody>
		@endforeach
	</table>
</div>
{!!$evaluations->render()!!}
@endsection