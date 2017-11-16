@extends('layouts.admin')
@section('content')
@include('alerts.succes')
<div class="table-responsive">
	<table class="table table-hover">
		<thead>
			<th>Id</th>
			<th>Name</th>
			<th>Description</th>
			<th>Date</th>
			<th>Link</th>
			<th>Photo</th>
			<th>Edit</th>
		</thead>
		@foreach($crafts as $craft)
		<tbody>
			<td>{{$craft->id}}</td>
			<td>{{$craft->name}}</td>
			<td>{{$craft->description}}</td>
			<td>{{$craft->date}}</td>
			<td>{{$craft->link}}</td>
			<td>
				<img src="{!!URL::to($craft->photo)!!}" alt="" height="60px">
			</td>
			@foreach(Auth::user()->role->functionalities as $func)
			@if ($func->code=='ECRF')
			<td>
				{!!link_to_route('admin.craft.edit', $title = 'Editar', $parameters = $craft->id, $attributes = ['class'=>'btn btn-primary'])!!}
			</td>
			@endif
			@if ($func->code=='DCRF')
			<td>
				{!!link_to_route('admin.craft.show', $title = 'Borrar', $parameters = $craft->id, $attributes = ['class'=>'btn btn-danger'])!!}
			</td>
			@endif
			@endforeach
		</tbody>
		@endforeach
	</table>
</div>
{!!$crafts->render()!!}
@endsection