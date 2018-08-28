<div class="form-group required">
	{!! Form::label('Nombre*') !!}
	{!! Form::text('nombre',null,['class'=>'form-control','placeholder'=>'Insert Nombre','required', 'maxlength'=>50,'style'=>'text-transform: uppercase;']) !!}
</div>
<div class="form-group required">
	{!! Form::label('Color de fondo*') !!}
	{!! Form::color('color',null) !!}
</div>
<div class="form-group required">
	{!! Form::label('Color de Texto*') !!}
	{!! Form::color('texto',null) !!}
</div>
<div class="form-group">
{!! Form::label('Llama lista') !!}
	{!! Form::select('lista',['no' => 'no','si' => 'si'],null,['class'=>'form-control','maxlength'=>10]) !!}
</div>
<div class="panel panel-default">
	<div class="panel-body">
		<div class="col-xs-6">
			<div class="panel panel-info">
				<div class="panel-heading">Asignaturas Seleccionadas</div>
				<div class="panel-body">
					<ul class="list-group" id="list_subject_form_career">
						@if ($career)
						@foreach ($career->subjects()->orderBy('nombre','asc')->get() as $subject)
						<li class='list-group-item list-group-item-success'>
							{{$subject->nombre}}
							<button class='btn btn-danger btn_quitar_subject' type='button'><i class='fa fa-close fa-fw'></i></button>
							<input type='hidden' name='subjects[]' value='{{$subject->id}}' >
						</li>
						@endforeach
						@endif
					</ul>
				</div>
			</div>
		</div>
		<div class="col-xs-6">
			<div class="panel panel-default">
				<div class="panel-heading">Listado de Asignaturas</div>
				<div class="panel-body">
					<ul class="list-group">
						@foreach ($subjects as $subject)
						<div class="col-xs-6">
							<div class="list-group-item list-group-item-warning add_subject_form_career" id_subject="{{$subject->id}}" name_subject="{{$subject->nombre}}">{{$subject->nombre}}</div>
						</div>
						@endforeach
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>