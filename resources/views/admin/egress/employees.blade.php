@extends('layouts.admin')
@section('content')
@include('alerts.succes')
<div class="table-responsive">
	<table class="table table-hover tablaNoOrder compact">
		<thead>
			<th>CI</th>
			<th>Nombre</th>
			<th>Rol</th>
			<th>Telefono</th>
			<th>Registrar</th>
			<th>Ver</th>
		</thead>
		<tbody>
		@foreach($employees as $employee)
		<tr>
			<td>{{$employee->ci}}</td>
			<td>{{$employee->nombrecompleto()}}</td>
			<td>{{$employee->user->role->name}}</td>
			<td>{{$employee->telefono}}</td>
			<td>
				{!!link_to_action('EgressController@paymentform', $title = 'Registrar Pago', $parameters = $employee->id, $attributes = ['class'=>'btn btn-success','code'=>$employee->id])!!}
			</td>
			<td>
				{!!link_to_action('EgressController@mypayment', $title = 'Ver pagos', $parameters = $employee->id, $attributes = ['class'=>'btn btn-info','code'=>$employee->id])!!}
			</td>
			</tr>
		@endforeach
		</tbody>
	</table>
</div>
@endsection