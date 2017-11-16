@extends('layouts.admin')
@section('content')
@include('alerts.succes')
<div class="table-responsive">
<table class="table table-hover">
	<thead>
		<th>Id</th>
		<th>Title</th>
		<th>Text</th>
		<th>Photo</th>
		<th>operation</th>
	</thead>
	@foreach($sliders as $slider)
	<tbody>
		<td>{{$slider->id}}</td>
		<td>{{$slider->title}}</td>
		<td>{{$slider->text}}</td>
		<td><img src="{!!URL::to($slider->photo)!!}" alt="" height="100px"></td>
		@foreach(Auth::user()->role->functionalities as $func)
		@if ($func->code=='ESLI')
		<td>
			{!!link_to_route('admin.slider.edit', $title = 'Editar', $parameters = $slider->id, $attributes = ['class'=>'btn btn-primary'])!!}
		</td>
		@endif
		@if ($func->code=='DSLI')
		<td>
			{!!link_to_route('admin.slider.show', $title = 'Borrar', $parameters = $slider->id, $attributes = ['class'=>'btn btn-danger'])!!}
		</td>
		@endif
		@endforeach
	</tbody>
	@endforeach
</table>
</div>
{!!$sliders->render()!!}
@endsection