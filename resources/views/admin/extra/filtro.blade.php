@extends('layouts.admin')
@section('content')
<div class="table-responsive">
	<table class="table table-hover">
		<thead>
			<th>Socabon</th>
		</thead>
		<tbody>
			<?php $key=1; ?>
			@foreach($socabon as $assistance)
			<tr style="background-color: rgba(0,255,0,0.25);" >
				<td>@if ($key<10){{'0'.$key.'. '}}@else {{$key.'. '}}@endif {{$assistance->inscription->people->nombrecompleto()}}</td>
			</tr>
			<?php $key++; ?>
			@endforeach
		</tbody>
		<thead>
			<th>Sacaba</th>
		</thead>
		<tbody>
			<?php $key=1; ?>
			@foreach($sacaba as $assistance)
			<tr style="background-color: rgba(255,0,0,0.25);">
				<td>@if ($key<10){{'0'.$key.'. '}}@else {{$key.'. '}}@endif {{$assistance->inscription->people->nombrecompleto()}}</td>
			</tr>
			<?php $key++; ?>
			@endforeach
		</tbody>
	</table>
</div>
@endsection