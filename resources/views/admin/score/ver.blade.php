@extends('layouts.admin')
@section('adminjs')
{!!Html::script('js/score.js')!!}
<link href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css" rel="stylesheet"/>
<script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/3.2.2/js/dataTables.fixedColumns.min.js"></script>
<link href="https://cdn.datatables.net/fixedcolumns/3.2.2/css/fixedColumns.dataTables.min.css" rel="stylesheet"/>
@endsection
@section('content')
<br>
<div class=" vista_reducida tabla_score_ver">
	<table class="table table-hover table-condensed" style="width:100%">
		<thead>
			<tr>
				<th class="sobre">Nombre</th>
				<?php $rec_modulo=0; $igual=true; $ban=1;?>
				@foreach (\Institute\Test::where('career_id',$group->startclass->career_id)->groupBy('modulo')->orderBy('modulo','asc')->get() as $k=>$test_modulo)
				<?php $materia=1;  $m_c=$materia;?>
				@foreach ($group->startclass->career->subjects as $subject)
				<?php if (count($subject->tests)>0) {$materia*=-1; } ?>
				@foreach (\Institute\Test::where('career_id',$group->startclass->career_id)->where('subject_id',$subject->id)->where('modulo',$test_modulo->modulo)->orderBy('orden','asc')->get() as $k=>$test)
				<?php if ($rec_modulo!=$test_modulo->id){$igual=false;$ban=$ban*-1;}
				else{$igual=true;}
				$rec_modulo=$test_modulo->id; ?>
				<th class="nota_contenedor_fechas vista_movil" @if ($ban!=1) @if ($materia>0) style="background-color: #9A9BA3;"@else style="background-color: #BABABA;"@endif @else @if ($materia>0) style="background-color: #DBEDEA;" @else style="background-color:white;"@endif @endif>
					@if (!$igual)
					<div class="nombre_modulo">{{'MODULO '.$test_modulo->modulo}}</div>
					@endif
					@if ($m_c != $materia)
					<?php $m_c=$materia;?>
					<div class="nombre_materia">{{$subject->nombre}}</div>
					@endif
					<div class="nombre_test_vrt vista_movil">{{$test->nombre}}</div>
				</th>
				@endforeach

				@endforeach
				<th class="igual" @if ($ban!=1) style="background-color: #BABABA;"@endif></th>
				<th class="vista_movil" @if ($ban!=1) style="background-color: #BABABA;"@endif><p>Total</p></th>
				@endforeach
				<th style="text-align: center;"><p>Promedio</p></th>
			</tr>
		</thead>
		@foreach($inscriptions as $i=>$inscription)
		<tr @if ($inscription->estado == 'Retirado') style="background-color:#A460B8;" @endif @if ($inscription->debit()) style="background-color: #FF7878;"@elseif ($inscription->debitNext()) style="background-color: #FFF961;"@else style="background-color: #91F47E;"@endif>
			<td style="white-space: pre;"><b><a href="{{url('admin/student/search/'.$inscription->people->id)}}" style="color: #0800AB">{{$inscription->people->nombrecompleto()}}</a></b></td>
			<?php $rec_modulo=0; $ban=1;?>
			<?php $promedio = 0; $div_promedio = 0;?>
			@foreach (\Institute\Test::where('career_id',$group->startclass->career_id)->groupBy('modulo')->orderBy('modulo','asc')->get() as $k=>$test_modulo)
			<?php $total = 0; $divisor = 0;?>
			<?php if ($rec_modulo!=$test_modulo->id){$ban=$ban*-1;}?>
			<?php $materia=1;?>
			@foreach ($group->startclass->career->subjects as $subject)
			<?php if (count($subject->tests)>0) {$materia*=-1; } ?>
			@foreach (\Institute\Test::where('career_id',$group->startclass->career_id)->where('subject_id',$subject->id)->where('modulo',$test_modulo->modulo)->orderBy('orden','asc')->get() as $k=>$test)
			<td @if ($ban!=1) @if ($materia>0) style="background-color: #9A9BA3;"@else style="background-color: #BABABA;"@endif @else @if ($materia>0) style="background-color: #DBEDEA;" @else style="background-color:white;" @endif @endif>
				@if ($inscription->nota($test)!=null)
				<button class="btn btn-default" style="padding: 2px 3px 2px 2px;" type="button" inscription_id="{{$inscription->id}}" group_id="{{"$group->id"}}" test_id="{{$test->id}}" nota="{{$inscription->nota($test)['nota']}}" score_id="{{$inscription->nota($test)['id']}}" class="btn btn-default" aria-label="Left Align">{{$inscription->nota($test)['nota']}}</button>
				<?php $total = $total+intval($inscription->nota($test)['nota']); ?>
				<?php $divisor++; ?>
				@else
				<button class="btn btn-primary" style="padding: 2px 2px 2px 2px;" type="button" inscription_id="{{$inscription->id}}" group_id="{{$group->id}}" subject_id="{{"$subject->id"}}" test_id="{{$test->id}}" class="btn btn-default" aria-label="Left Align"><i class="fa fa-plus fa-fw"></i></button>
				@endif
			</td>
			@endforeach
			@endforeach
			<?php $div_promedio++; ?>
			<td class="igual" @if ($ban!=1) style="background-color: #BABABA;"@endif>=</td>
			<?php if($divisor==0){$divisor=1;} ?>
			<td class="cont_add_nota" @if ($ban!=1) style="background-color: #BABABA;text-align:center;"@else style="text-align:center;"@endif>{{round( $total/$divisor, 1, PHP_ROUND_HALF_UP)}}</td>
			<?php $promedio = $promedio+round( $total/$divisor, 1, PHP_ROUND_HALF_UP); ?>
			@endforeach
			<td style="text-align: center;"> @if ($promedio!=0)
				<b>{{round( $promedio/$div_promedio, 1, PHP_ROUND_HALF_UP)}}</b>
				@endif
			</td>
		</tr>
		@endforeach
	</table>
</div>
<style>
	.vista_movil *{font-size: 12px;}
	.vista_movil td{padding: 4px !important;}
	.vista_movil td form{margin: 0 !important;}
	.switch{margin: 0;}
	.nota_contenedor_fechas{position:relative; height: 220px;}
	.nombre_modulo{
		position:absolute;font-size:14px;padding-left:5px;width:100px;bottom:200px;left:0;z-index:1;
	}
	.nombre_materia{
		position:absolute;padding-left:5px;bottom:185;left:0;white-space: pre;background-color:inherit;cursor:pointer;overflow: hidden;z-index:1;
	}
	.sobre{
		z-index: 10;position: relative;background-color:#FFFFFF;
	}
	.nombre_materia:hover{
		z-index:5;border:black 1px solid;margin:-2px 0 0 -2px;padding-right:4px;border-radius:2px;-webkit-box-shadow: 2px 2px 5px 0px rgba(0,0,0,0.75);
		-moz-box-shadow: 2px 2px 5px 0px rgba(0,0,0,0.75);
		box-shadow: 2px 2px 5px 0px rgba(0,0,0,0.75);
	}
	.nombre_test_vrt{transform:rotate(-90deg);width:170px;position: absolute;left:-70px;bottom:85px;height:16px;overflow: hidden;
	}
</style>
@endsection