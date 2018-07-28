<div style="padding-top: 5px;">
	<ul class="nav nav-tabs" role="tablist">
		@foreach ($career->subjects as $key=>$subject)
		<li role="presentation" @if ($key==0) class="active" @endif>
			<a href="#{{$subject->id}}" aria-controls="{{$subject->id}}" role="tab" data-toggle="tab">{{$subject->nombre}}</a>
		</li>
		@endforeach
	</ul>
	<br>
	<div class="tab-content">
		@foreach ($career->subjects as $key=>$subject)
		<div role="tabpanel" class="tab-pane subject_modulo @if ($key==0) active @endif" id="{{$subject->id}}">
			@foreach (\Institute\Test::where('subject_id',$subject->id)->where('career_id',$career->id)->groupBy('modulo')->get() as $ttsm)
			<div class="panel panel-primary modulo_padre">
				<div class="panel-heading"><b><span>Módulo: </span><span class="n_modulo"></span></b><span class="btn btn-danger del_name btn-xs" style="float: right;">X</span></div>

				@foreach (\Institute\Test::where('subject_id',$subject->id)->where('career_id',$career->id)->where('modulo',$ttsm->modulo)->get() as $test)

				<div class="panel-body">
					<div class="col-md-11" style="padding: 0;">
						<input type="text" name="nombre[]" autocomplete="off" value="{{$test->nombre}}" class="form-control nombre_registro" placeholder="Ingrese Nombre (Examen # - Práctica # - Tema #)" required maxlength="250" style="text-transform: uppercase;">
						<input type="hidden" name="subject_id[]" value="{{$subject->id}}">
						<input type="hidden" name="modulo[]" class="input_modulo" value="{{null}}">
					</div>
					<div class="col-md-1"><span class="btn btn-danger del_name">X</span></div>
				</div>

				@endforeach
				<span class="btn btn-warning tbn_clonar_nombre" style="margin: 0 0 20px 15px;">Nuevo Registro</span>
				<div class="panel-body clonar" style="display: none;">
					<div class="col-md-11" style="padding: 0;">
						<input type="text" name="nombre[]" autocomplete="off" value="{{null}}" class="form-control nombre_registro" placeholder="Ingrese Nombre (Examen # - Práctica # - Tema #)" required maxlength="250" style="text-transform: uppercase;" disabled>
						<input type="hidden" name="subject_id[]" value="{{$subject->id}}" disabled>
						<input type="hidden" name="modulo[]" class="input_modulo" value="{{null}}" disabled>
					</div>
					<div class="col-md-1"><span class="btn btn-danger del_name">X</span></div>
				</div>
			</div>
			@endforeach
			<span class="btn btn-info tbn_clonar_modulo btn-lg" style="margin-bottom:20px; margin-left:calc(50% - 97px);">&emsp; Nuevo Módulo &emsp;</span>

			<div class="panel panel-primary modulo_padre panel_clonar" style="display: none;">
				<div class="panel-heading"><b><span>Módulo: </span><span class="n_modulo"></span></b><span class="btn btn-danger del_name btn-xs" style="float: right;">X</span></div>
				<div class="panel-body">
					<div class="col-md-11" style="padding: 0;">
						<input type="text" name="nombre[]" autocomplete="off" value="{{null}}" class="form-control nombre_registro primer_nombre" placeholder="Ingrese Nombre (Examen # - Práctica # - Tema #)" required maxlength="250" style="text-transform: uppercase;" disabled>
						<input type="hidden" name="subject_id[]" class="primer_nombre" value="{{$subject->id}}" disabled>
						<input type="hidden" name="modulo[]" class="input_modulo primer_nombre" value="{{null}}" disabled>
					</div>
					<div class="col-md-1"><span class="btn btn-danger del_name">X</span></div>
				</div>
				<span class="btn btn-warning tbn_clonar_nombre" style="margin: 0 0 20px 15px;">Nuevo Registro</span>
				<div class="panel-body clonar" style="display: none;">
					<div class="col-md-11" style="padding: 0;">
						<input type="text" name="nombre[]" autocomplete="off" value="{{null}}" class="form-control nombre_registro" placeholder="Ingrese Nombre (Examen # - Práctica # - Tema #)" required maxlength="250" style="text-transform: uppercase;" disabled>
						<input type="hidden" name="subject_id[]" value="{{$subject->id}}" disabled>
						<input type="hidden" name="modulo[]" class="input_modulo" value="{{null}}" disabled>
					</div>
					<div class="col-md-1"><span class="btn btn-danger del_name">X</span></div>
				</div>
			</div>
		</div>
		@endforeach
	</div>
</div>
<input type="hidden" name="career_id" value="{{$career->id}}">