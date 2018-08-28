@extends('layouts.admin')
@section('content')
<?php $editar=false; $eliminar=false;
foreach (Auth::user()->role->functionalities as $func) {
	if ($func->code=='EINT'){ $editar=true; }
	if ($func->code=='DINT'){ $eliminar=true; }
}
?>
<div class="table-responsive">
	<table class="table table-hover tablaNoOrder compact ">
		<thead>
			<th>Id</th>
			<th>Nombre</th>
			<th>Telefono</th>
			<th>Carrera</th>
			<th>Fecha</th>
			<th>Enviado</th>
			<th>User</th>
			@if ($editar)<th>Editar</th>@endif
			@if ($eliminar)<th>Eliminar</th>@endif
		</thead>
		<tbody>
			@foreach($interesteds as $interested)
			<tr @if ($interested->enviado) style="background-color: #54FB4F;" @endif>
				<td>{{$interested->id}}</td>
				<td>{{$interested->nombre}}</td>
				<td><a id="env_wha" int="{{$interested->id}}" href="https://api.whatsapp.com/send?phone=591{{$interested->telefono}}" target="_blank">{{$interested->telefono}}</a></td>
				<td>{{$interested->career->nombre}}</td>
				<td><b>{{Jenssegers\Date\Date::parse($interested->fecha)->format('j M Y')}}</b><br>&nbsp;&nbsp;{{Jenssegers\Date\Date::parse($interested->fecha)->format('H:i:s')}}</td>
				<td>@if (!$interested->enviado)no @endif{{$interested->enviado}}</td>
				<td>@if ($interested->user_id!=null || $interested->user_id!=""){{$interested->user['user']}} @endif</td>
				@if ($editar)
				<td>
					{!!link_to_route('admin.interested.edit', $title = 'Editar', $parameters = $interested->id, $attributes = ['class'=>'btn btn-primary'])!!}
				</td>
				@endif
				@if ($eliminar)
				<td>
					{!!link_to_route('admin.interested.show', $title = 'Borrar', $parameters = $interested->id, $attributes = ['class'=>'btn btn-danger'])!!}
				</td>
				@endif
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
{!!$interesteds->render()!!}
@endsection