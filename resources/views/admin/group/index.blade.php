@extends('layouts.admin')
@section('content')
@include('alerts.succes')
<div class="table-responsive">
	<table class="table table-hover">
		<thead>
			<th>Id</th>
			<th>Fecha de Inicio</th>
			<th>Carrera</th>
			<th>Turno</th>
			<th>Inscritos</th>
			<th>Estado</th>
			<th>Horario</th>
			<th>Edit</th>
		</thead>
		@foreach($groups as $group)
		<tbody>
			<td>{{$group->id}}</td>
			<td>{{Jenssegers\Date\Date::parse($group->startclass->fecha_inicio)->format('j M Y')}}</td>
			<td>{{$group->startclass->career->nombre}}</td>
			<td>{{$group->turno}}</td>
			<td>{{sizeof($group->inscriptions)}}</td>
			<td>({{$group->estado}})</td>
			<td>
				{!!link_to_action('GroupController@pdf', $title = 'Horario', $parameters = $group->id, $attributes = ['class'=>'btn btn-info pdfbtn','code'=>$group->id])!!}
			</td>
			<td>
				{!!link_to_action('GroupController@pdfanticipado', $title = 'Anticipado', $parameters = $group->id, $attributes = ['class'=>'btn btn-success pdfbtn','code'=>$group->id])!!}
			</td>
			<!--td>
				{!!link_to_action('GroupController@horario', $title = 'Horario', $parameters = $group->id, $attributes = ['class'=>'btn btn-success'])!!}
			</td-->
			@foreach(Auth::user()->role->functionalities as $func)
			@if ($func->code=='EGRO')
			<td>
				{!!link_to_route('admin.group.edit', $title = 'Editar', $parameters = $group->id, $attributes = ['class'=>'btn btn-primary'])!!}
			</td>
			@endif
			@if ($func->code=='DGRO' && sizeof($group->inscriptions)==0)
			<td>
				{!!link_to_route('admin.group.show', $title = 'Borrar', $parameters = $group->id, $attributes = ['class'=>'btn btn-danger'])!!}
			</td>
			@endif
			@endforeach
		</tbody>
		@endforeach
	</table>
</div>
<div class="modal fade" id="pdfModal" tabindex="0" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document" style="z-index: 2000">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">HORARIO</h4>
			</div>
			<div style="text-align: center;">
				<iframe src="" style="width:100%; height:80%;" frameborder="0"></iframe>
			</div>
		</div>
	</div>
</div>
{!!$groups->render()!!}
@endsection