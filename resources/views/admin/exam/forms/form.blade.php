
@foreach (\Institute\Exam::join('exams_subjects','exams.id','=','exams_subjects.exam_id')->where('subject_id',$subject->id)->where('career_id',$career->id)->get() as $exam)
<div class="panel panel-success modulo_padre">
	<div class="panel-heading"><b><span>Pregunta: </span><span class="n_modulo"></span></b><span class="btn btn-danger del_name btn-xs" style="float: right;">X</span></div>
	<div class="panel-body cuerpo_numerador">
		<div class="form-group col-xs-12">
			<input type="text" name="pregunta[]" autocomplete="off" value="{{$exam->pregunta}}" class="form-control nombre_registro" placeholder="Ingrese Pregunta" required maxlength="255" style="text-transform: uppercase;">
		</div>
		<div class="form-group col-xs-11">
			<input type="text" name="respuesta1[]" autocomplete="off" value="{{$exam->respuesta1}}" class="form-control" placeholder="Ingrese Respuesta 1" required maxlength="200">
		</div>
		<input type="checkbox" name="correcta[]" class="form-group col-xs-1 check_uniq" style="height:25px; width: 25px;" value="1" @if($exam->correcta==1) checked @else disabled @endif>
		<div class="form-group col-xs-11">
			<input type="text" name="respuesta2[]" autocomplete="off" value="{{$exam->respuesta2}}" class="form-control" placeholder="Ingrese Respuesta 2" maxlength="200">
		</div>
		<input type="checkbox" name="correcta[]" class="form-group col-xs-1 check_uniq" style="height:25px; width: 25px;" value="2" @if($exam->correcta==2) checked @else disabled @endif>
		<div class="form-group col-xs-11">
			<input type="text" name="respuesta3[]" autocomplete="off" value="{{$exam->respuesta3}}" class="form-control" placeholder="Ingrese Respuesta 3" maxlength="200">
		</div>
		<input type="checkbox" name="correcta[]" class="form-group col-xs-1 check_uniq" style="height:25px; width: 25px;" value="3" @if($exam->correcta==3) checked @else disabled @endif>
		<div class="form-group col-xs-11">
			<input type="text" name="respuesta4[]" autocomplete="off" value="{{$exam->respuesta4}}" class="form-control" placeholder="Ingrese Respuesta 4" maxlength="200">
		</div>
		<input type="checkbox" name="correcta[]" class="form-group col-xs-1 check_uniq" style="height:25px; width: 25px;" value="4" @if($exam->correcta==4) checked @else disabled @endif>
		<div class="form-group col-xs-11">
			<input type="text" name="respuesta5[]" autocomplete="off" value="{{$exam->respuesta5}}" class="form-control" placeholder="Ingrese Respuesta 5" maxlength="200">
		</div>
		<input type="checkbox" name="correcta[]" class="form-group col-xs-1 check_uniq" style="height:25px; width: 25px;" value="5" @if($exam->correcta==5) checked @else disabled @endif>
	</div>
</div>
@endforeach
<span class="btn btn-info tbn_clonar_pregunta btn-lg" style="margin-bottom:20px; margin-left:calc(50% - 97px);">&emsp; Nueva Pregunta &emsp;</span>
<div class="panel panel-success modulo_padre panel_clonar" style="display: none;">
	<div class="panel-heading"><b><span>Pregunta: </span><span class="n_modulo"></span></b><span class="btn btn-danger del_name btn-xs" style="float: right;">X</span></div>
	<div class="panel-body">
		<div class="form-group col-xs-12">
			<input type="text" name="pregunta[]" autocomplete="off" value="{{null}}" class="form-control nombre_registro" placeholder="Ingrese Pregunta" required maxlength="255" style="text-transform: uppercase;" disabled>
		</div>
		<div class="form-group col-xs-11">
			<input type="text" name="respuesta1[]" autocomplete="off" value="{{null}}" class="form-control" placeholder="Ingrese Respuesta 1" maxlength="200" required disabled>
		</div>
		<input type="checkbox" name="correcta[]" class="form-group col-xs-1 check_uniq" style="height:25px; width:25px;" value="1" disabled>
		<div class="form-group col-xs-11">
			<input type="text" name="respuesta2[]" autocomplete="off" value="{{null}}" class="form-control" placeholder="Ingrese Respuesta 2" maxlength="200" disabled>
		</div>
		<input type="checkbox" name="correcta[]" class="form-group col-xs-1 check_uniq" style="height:25px; width:25px;" value="2" disabled>
		<div class="form-group col-xs-11">
			<input type="text" name="respuesta3[]" autocomplete="off" value="{{null}}" class="form-control" placeholder="Ingrese Respuesta 3" maxlength="200" disabled>
		</div>
		<input type="checkbox" name="correcta[]" class="form-group col-xs-1 check_uniq" style="height:25px; width:25px;" value="3" disabled>
		<div class="form-group col-xs-11">
			<input type="text" name="respuesta4[]" autocomplete="off" value="{{null}}" class="form-control" placeholder="Ingrese Respuesta 4" maxlength="200" disabled>
		</div>
		<input type="checkbox" name="correcta[]" class="form-group col-xs-1 check_uniq" style="height:25px; width:25px;" value="4" disabled>
		<div class="form-group col-xs-11">
			<input type="text" name="respuesta5[]" autocomplete="off" value="{{null}}" class="form-control" placeholder="Ingrese Respuesta 5" maxlength="200" disabled>
		</div>
		<input type="checkbox" name="correcta[]" class="form-group col-xs-1 check_uniq" style="height:25px; width:25px;" value="5" disabled>
	</div>
</div>
<input type="hidden" name="career_id" value="{{$career->id}}">
<input type="hidden" name="subject_id" value="{{$subject->id}}">