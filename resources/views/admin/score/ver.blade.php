@extends('layouts.admin')
@section('content')
<?php $editar=false;
foreach (Auth::user()->role->functionalities as $func) {
	if ($func->code=='ESCO'){ $editar=true; }
}
?>
<div class="tabla-scroll-doble">
	<div class="nombres">
		<div class="header">Nombre</div>
		<div class="body">
			@foreach($inscriptions as $i=>$inscription)
			<div class="{{$inscription->id}}" @if ($inscription->estado=='Retirado') style="background-color:rgba(156,39,176,0.5);" @endif @if ($inscription->debit()) style="background-color:rgba(244,67,54,0.5);" @elseif ($inscription->debitNext()) style="background-color:rgba(255,152,0,0.5);" @else style="background-color:rgba(76,175,80,0.5);" @endif>
				<a target="_blank" href="{{url('admin/student/search/'.$inscription->people->id)}}">{{$inscription->people->nombrecompleto()}}</a>
			</div>
			@endforeach
		</div>
	</div>
	<div class="notas">
		<div class="conte">
			<div class="header">
				<?php $rec_modulo=0; $ban=1;?>
				@foreach (\Institute\Test::where('career_id',$group->startclass->career_id)->groupBy('modulo')->orderBy('modulo','asc')->get() as $k=>$test_modulo)
				<div class="modulos" modulo="{{$test_modulo->id}}" style="width: 150px; overflow: hidden;">
					<div class="nombre_modulo btn btn-primary" style="top: 10px;">{{'MODULO '.$test_modulo->modulo}}</div>
					<?php $materia=1;?>
					@foreach ($group->startclass->career->subjects as $subject)
					<?php
					$tsts = \Institute\Test::where('career_id',$group->startclass->career_id)->where('subject_id',$subject->id)->where('modulo',$test_modulo->modulo)->orderBy('orden','asc')->get();
					?>
					@if (count($tsts)>0)
					<div class="materias" materia="{{$subject->id}}">
						<div class="nombre_materia btn btn-warning">{{$subject->nombre}}</div>
						<?php if (count($subject->tests)>0) {$materia*=-1; } ?>
						@foreach ($tsts as $k=>$test)
						<?php if ($rec_modulo!=$test_modulo->id){$ban=$ban*-1;}
						$rec_modulo=$test_modulo->id; ?>
						<div class="registros asis_{{$test->id}}" @if ($ban!=1) @if ($materia>0) style="background-color: #9A9BA3;"@else style="background-color: #BABABA;"@endif @else @if ($materia>0) style="background-color: #DBEDEA;" @else style="background-color:white;"@endif @endif>
							<div class="nombre_test">{{$test->nombre}}</div>
						</div>
						<?php $cont[$k]=0; ?>
						@endforeach
					</div>
					@endif
					@endforeach
					<div class="materias" materia="total_modulo_{{$test_modulo->modulo}}">
						<div class="nombre_materia btn btn-warning">PROMEDIO</div>
						<div class="registros asis_igual_{{$test_modulo->modulo}}">
							<div class="nombre_test"></div>
						</div>
						<div class="registros asis_total_{{$test_modulo->modulo}}">
							<div class="nombre_test">TOTAL MODULO</div>
						</div>
					</div>
				</div>
				@endforeach
				<div class="modulos" modulo="promedio" style="width: 150px; overflow: hidden;">
					<div class="nombre_modulo promo btn btn-success" style="top: 10px;">PROMEDIO</div>
					<div class="materias" materia="promedio">
						<div class="registros asis_igual">
							<div class="nombre_test"></div>
						</div>
						<div class="registros asis_promedio">
							<div class="nombre_test">PROMEDIO</div>
						</div>
					</div>
				</div>
			</div>
			<div class="body">
				@foreach($inscriptions as $i=>$inscription)
				<div>
					<div class="asis_hover" ins="{{$inscription->id}}">
						<?php $rec_modulo=0; $ban=1;?>
						<?php $promedio = 0; $div_promedio = 0;?>
						@foreach (\Institute\Test::where('career_id',$group->startclass->career_id)->groupBy('modulo')->orderBy('modulo','asc')->get() as $k=>$test_modulo)
						<div class="body_modulos" modulo="{{$test_modulo->id}}" style="width: 150px; overflow: hidden;">
							<?php $total = 0; $divisor = 0;?>
							<?php if ($rec_modulo!=$test_modulo->id){$ban=$ban*-1;}?>
							<?php $materia=1;?>
							@foreach ($group->startclass->career->subjects as $subject)
							<?php if (count($subject->tests)>0) {$materia*=-1; } ?>
							@foreach (\Institute\Test::where('career_id',$group->startclass->career_id)->where('subject_id',$subject->id)->where('modulo',$test_modulo->modulo)->orderBy('orden','asc')->get() as $k=>$test)
							<div asis="asis_{{$test->id}}" modulo="{{$test_modulo->id}}" materia="{{$subject->id}}" @if($inscription->estado=='Retirado') style="background-color:rgba(156,39,176,0.4);" @endif @if ($inscription->debit()) style="background-color:rgba(244,67,54,0.4);" @elseif ($inscription->debitNext()) style="background-color:rgba(255,152,0,0.4);" @else style="background-color:rgba(76,175,80,0.4);" @endif>
								@if ($inscription->nota($test)!=null)
								<button class="@if ($editar) edit_nota @endif btn btn-primary" inscription_id="{{$inscription->id}}" group_id="{{"$group->id"}}" test_id="{{$test->id}}" nota="{{$inscription->nota($test)['nota']}}" score_id="{{$inscription->nota($test)['id']}}">{{$inscription->nota($test)['nota']}}</button>
								<?php $total = $total+intval($inscription->nota($test)['nota']); ?>
								<?php $divisor++; ?>
								@else
								<button class=" @if ($editar) new_nota @endif btn btn-default" inscription_id="{{$inscription->id}}" group_id="{{$group->id}}" subject_id="{{$subject->id}}" test_id="{{$test->id}}">+</button>
								@endif
							</div>
							@endforeach
							@endforeach
							<?php $div_promedio++; ?>
							<div asis="asis_igual_{{$test_modulo->modulo}}" modulo="{{$test_modulo->id}}" materia="materia_{{$test_modulo->id}}">
								<div>=</div>
							</div>
							<?php if($divisor==0){$divisor=1;} ?>
							<div asis="asis_total_{{$test_modulo->modulo}}" modulo="{{$test_modulo->id}}" materia="materia_{{$test_modulo->id}}">
								<button class="btn btn-success btn_promedio">{{round( $total/$divisor, 1, PHP_ROUND_HALF_UP)}}</button>
							</div>
						</div>
						<?php $promedio = $promedio+round( $total/$divisor, 1, PHP_ROUND_HALF_UP); ?>
						@endforeach
						<div class="body_modulos" modulo="promedio" style="width: 150px; overflow: hidden;">
							<div asis="asis_igual" modulo="igual" materia="materia_promedio">
								<div>=</div>
							</div>
							<div asis="asis_promedio" modulo="promedio" materia="materia_promedio">
								@if ($promedio!=0)
								<button class="btn btn-success btn_promedio">{{round( $promedio/$div_promedio, 1, PHP_ROUND_HALF_UP)}}</button>
								@endif
							</div>
						</div>
					</div>
				</div>
				@endforeach
			</div>
		</div>
	</div>
</div>
<div class="modal_nota">
	<span class="modal_nota_close btn btn-danger">&times;</span>
	{!! Form::open(['route' => 'admin.score.store', 'id'=>'asig_nota']) !!}
	<input type="text" name="nota" class="nota" placeholder="Nota" onkeypress="return justNumbers(event);" autofocus autocomplete="off">
	<input type="hidden" name="inscription_id" class="inscription_id" value="">
	<input type="hidden" name="test_id" value="{{null}}" class="test_id">
	<input type="hidden" name="score_id" value="{{null}}" class="score_id">
	<input type="hidden" name="group_id" value="{{null}}" class="group_id">
	<input type="hidden" name="subject_id" value="{{null}}" class="subject_id">
	<button class="btn btn-primary">Guardar</button>
	{!! Form::close() !!}
</div>
<div class="background_modal">
</div>
@endsection