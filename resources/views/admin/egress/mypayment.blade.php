@extends('layouts.admin')
@section('content')
<div class="table-responsive">
	<table class="table table-hover">
		<thead>
			<th>Id</th>
			<th>Glosa</th>
			<th>Monto</th>
			<th>Tipo</th>
			<th>Fecha</th>
		</thead>
		@foreach($egresses as $egress)
		<tbody>
			<td>{{$egress->id}}</td>
			<td>{{$egress->glosa}}</td>
			<td>{{$egress->monto}}</td>
			<td>{{$egress->tipo}}</td>
			<td>{{Jenssegers\Date\Date::parse($egress->fecha)->format('j M Y')}}</td>
		</tbody>
		@endforeach
	</table>
</div>
@endsection