@extends('layouts.admin')
@section('content')
@include('alerts.succes')
<div class="table-responsive">
	<table class="table table-hover">
		<thead>
			<th>Id</th>
			<th>Name</th>
			<th>Business</th>
			<th>Text</th>
			<th>Edit</th>
		</thead>
		@foreach($testimonials as $testimonial)
		<tbody>
			<td>{{$testimonial->id}}</td>
			<td>{{$testimonial->name}}</td>
			<td>{{$testimonial->business}}</td>
			<td>{{$testimonial->text}}</td>
			@foreach(Auth::user()->role->functionalities as $func)
			@if ($func->code=='ETST')
			<td>
				{!!link_to_route('admin.testimonial.edit', $title = 'Editar', $parameters = $testimonial->id, $attributes = ['class'=>'btn btn-primary'])!!}
			</td>
			@endif
			@if ($func->code=='DTST')
			<td>
				{!!link_to_route('admin.testimonial.show', $title = 'Borrar', $parameters = $testimonial->id, $attributes = ['class'=>'btn btn-danger'])!!}
			</td>
			@endif
			@endforeach
		</tbody>
		@endforeach
	</table>
</div>
{!!$testimonials->render()!!}
@endsection