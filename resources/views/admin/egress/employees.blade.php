@extends('layouts.admin')
@section('content')
@include('alerts.succes')
<div class="table-responsive">
	<table class="table table-hover">
		<thead>
			<th>CI</th>
			<th>Nombre</th>
			<th>Rol</th>
			<th>Telefono</th>
			<th colspan="2">Opciones</th>
		</thead>
		@foreach($employees as $employee)
		<tbody>
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
		</tbody>
		@endforeach
	</table>
</div>
{!!$employees->render()!!}
@endsection