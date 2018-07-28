@extends('layouts.admin')
@section('content')
<br>
@foreach ($group->startclass->career->subjects as $subject)
<div class="table-responsive">
	<div class="panel panel-primary">
		<div class="panel-heading">Asignatura: <b>{{$subject->nombre}}</b>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; Grupo: {{$group->startclass->career->nombre}} ({{$group->startclass->estado}}) [{{Jenssegers\Date\Date::parse($group->startclass->fecha_inicio)->format('j M Y')}}] Turno:{{$group->turno}}</div>
		<div class="panel-body">
			<div class="table-responsive vista_reducida">
				<table class="table table-hover table-condensed">
					<thead>
						<th>No</th>
						<th>Nombre</th>
						<?php $rec_partial=0; $igual=true; $ban=1;?>
						@foreach (\Institute\Test::where('career_id',$group->startclass->career_id)->where('subject_id',$subject->id)->groupBy('modulo')->get() as $k=>$test_modulo)
						@foreach (\Institute\Test::where('career_id',$group->startclass->career_id)->where('subject_id',$subject->id)->where('modulo',$test_modulo->modulo)->get() as $k=>$test)
						<?php if ($rec_partial!=$test_modulo->id){$igual=false;$ban=$ban*-1;}
						else{$igual=true;}
						$rec_partial=$test_modulo->id; ?>
						<th class="nota_contenedor_fechas vista_movil" @if ($ban!=1) style="background-color: #BABABA;"@endif>
							@if (!$igual)
							<div class="nombre_modulo">{{' MODULO '.$test_modulo->modulo}}</div>
							@endif
							<p class="nombre_test_vrt vista_movil">{{$test->nombre}}</p>
						</th>
						@endforeach
						<th class="igual" @if ($ban!=1) style="background-color: #BABABA;"@endif></th>
						<th class="vista_movil" @if ($ban!=1) style="background-color: #BABABA;"@endif><p>Total</p></th>
						@endforeach
						<th style="text-align: center;"><p>Promedio</p></th>
					</thead>
					@foreach($inscriptions as $i=>$inscription)
					<tr @if ($inscription->estado == 'Retirado') style="background-color: rgba(0,0,80,0.4);" @endif @if ($inscription->debit()) style="background-color: rgba(255,0,0,0.25);"  @elseif ($inscription->debitNext()) style="background-color: rgba(255,255,0,0.25);"  @else style="background-color: rgba(0,255,0,0.25);"  @endif >
						<td>{{++$i}}</td>
						<td><b><a href="{{url('admin/student/search/'.$inscription->people->id)}}" style="color: #0800AB">{{$inscription->people->nombrecompleto()}}</a></b></td>
						<?php $rec_partial=0; $ban=1;?>
						<?php $promedio = 0; $div_promedio = 0;?>
						@foreach (\Institute\Test::where('career_id',$group->startclass->career_id)->where('subject_id',$subject->id)->groupBy('modulo')->get() as $k=>$test_modulo)
						<?php $total = 0; $divisor = 0;?>
						<?php if ($rec_partial!=$test_modulo->id){$ban=$ban*-1;}?>
						@foreach (\Institute\Test::where('career_id',$group->startclass->career_id)->where('subject_id',$subject->id)->where('modulo',$test_modulo->modulo)->get() as $k=>$test)
						<td @if ($ban!=1) style="background-color: #BABABA;"@endif>
							@if ($inscription->nota($test)!=null)
							<button class="btn btn-default" style="padding: 2px 3px 2px 2px;" type="button" inscription_id="{{$inscription->id}}" group_id="{{"$group->id"}}" test_id="{{$test->id}}" nota="{{$inscription->nota($test)['nota']}}" score_id="{{$inscription->nota($test)['id']}}" class="btn btn-default" aria-label="Left Align">{{$inscription->nota($test)['nota']}}</button>
							<?php $total = $total+intval($inscription->nota($test)['nota']); ?>
							@else
							<button class="btn btn-primary" style="padding: 2px 2px 2px 2px;" type="button" inscription_id="{{$inscription->id}}" group_id="{{$group->id}}" subject_id="{{"$subject->id"}}" test_id="{{$test->id}}" class="btn btn-default" aria-label="Left Align"><i class="fa fa-plus fa-fw"></i></button>
							@endif
							<?php $divisor++; ?>
						</td>
						@endforeach
						<?php $div_promedio++; ?>
						<td class="igual" @if ($ban!=1) style="background-color: #BABABA;"@endif>=</td>
						<td class="cont_add_nota" @if ($ban!=1) style="background-color: #BABABA;"@endif>{{round( $total/$divisor, 1, PHP_ROUND_HALF_UP)}}</td>
						<?php $promedio = $promedio+round( $total/$divisor, 1, PHP_ROUND_HALF_UP); ?>
						@endforeach
						<td style="text-align: center;"> @if ($promedio!=0)
							<b>{{round( $promedio/$div_promedio, 1, PHP_ROUND_HALF_UP)}}</b>
						@endif</td>
					</tr>
					@endforeach
				</table>
			</div>
		</div>
	</div>
</div>
@endforeach
<style>
	.vista_movil *{font-size: 12px;}
	.vista_movil td{padding: 4px !important;}
	.vista_movil td form{margin: 0 !important;}
	.switch{margin: 0;}
	.nota_contenedor_fechas{position:relative; height: 110px;}
	.nombre_test_vrt{transform:rotate(-90deg);position:absolute;width:100px;right:-15px;top:45px;
	}
	.nombre_modulo{
		position: absolute; top: 0;left: 0; font-size: 14px;padding-left:10px; width: 100px;z-index: 1000;
	}
</style>
@endsection