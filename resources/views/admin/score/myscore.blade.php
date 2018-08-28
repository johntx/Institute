@extends('layouts.admin')
@section('content')
<br>
@foreach(Auth::user()->people->inscriptions->where('estado','Inscrito') as $inscription)
<div class="panel panel-primary">
	<div class="panel-heading">Carrera: ({{$inscription->group->startclass->career->nombre}})</div>
	<div class="panel-body">
		<div class="table-responsive">
			<div class="table-responsive vista_reducida">
				<table class="table table-hover table-condensed">
					<thead>
						<tr>
							<th>Nombre</th>
							<?php $rec_modulo=0; $igual=true; $ban=1;?>
							@foreach (\Institute\Test::where('career_id',$inscription->group->startclass->career_id)->groupBy('modulo')->orderBy('modulo','asc')->get() as $k=>$test_modulo)
							<?php $materia=1;  $m_c=$materia;?>
							@foreach ($inscription->group->startclass->career->subjects as $subject)
							<?php if (count($subject->tests)>0) {$materia*=-1; } ?>
							@foreach (\Institute\Test::where('career_id',$inscription->group->startclass->career_id)->where('subject_id',$subject->id)->where('modulo',$test_modulo->modulo)->orderBy('orden','asc')->get() as $k=>$test)
							<?php if ($rec_modulo!=$test_modulo->id){$igual=false;$ban=$ban*-1;}
							else{$igual=true;}
							$rec_modulo=$test_modulo->id; ?>
							<th class="nota_contenedor_fechas vista_movil" @if ($ban!=1) @if ($materia>0) style="background-color: #9A9BA3;"@else style="background-color: #BABABA;"@endif @else @if ($materia>0) style="background-color: #DBEDEA;" @else style="background-color:white;"@endif @endif>
								@if (!$igual)
								<div class="nombre_modulo">{{'MODULO '.$test_modulo->modulo}}</div>
								@endif
								@if ($m_c != $materia)
								<?php $m_c=$materia;?>
								<div class="nombre_test_vrt">{{$subject->nombre}}</div>
								@endif
							</th>
							@endforeach

							@endforeach
							<th class="igual" @if ($ban!=1) style="background-color: #BABABA;"@endif></th>
							<th class="vista_movil" @if ($ban!=1) style="background-color: #BABABA;"@endif><p>Total</p></th>
							@endforeach
							<th style="text-align: center;"><p>Promedio</p></th>
						</tr>
					</thead>
					<tr @if ($inscription->estado == 'Retirado') style="background-color: rgba(0,0,80,0.4);" @endif @if ($inscription->debit()) style="background-color: rgba(255,0,0,0.25);"  @elseif ($inscription->debitNext()) style="background-color: rgba(255,255,0,0.25);"  @else style="background-color: rgba(0,255,0,0.25);"  @endif >
						<td style="white-space: pre;"><b><a href="{{url('admin/student/search/'.$inscription->people->id)}}" style="color: #0800AB">{{$inscription->people->nombrecompleto()}}</a></b></td>
						<?php $rec_modulo=0; $ban=1;?>
						<?php $promedio = 0; $div_promedio = 0;?>
						@foreach (\Institute\Test::where('career_id',$inscription->group->startclass->career_id)->groupBy('modulo')->orderBy('modulo','asc')->get() as $k=>$test_modulo)
						<?php $total = 0; $divisor = 0;?>
						<?php if ($rec_modulo!=$test_modulo->id){$ban=$ban*-1;}?>
						<?php $materia=1;?>
						@foreach ($inscription->group->startclass->career->subjects as $subject)
						<?php if (count($subject->tests)>0) {$materia*=-1; } ?>
						@foreach (\Institute\Test::where('career_id',$inscription->group->startclass->career_id)->where('subject_id',$subject->id)->where('modulo',$test_modulo->modulo)->orderBy('orden','asc')->get() as $k=>$test)
						<td @if ($ban!=1) @if ($materia>0) style="background-color: #9A9BA3;"@else style="background-color: #BABABA;"@endif @else @if ($materia>0) style="background-color: #DBEDEA;" @endif @endif>
							@if ($inscription->nota($test)!=null)
							<button class="btn btn-default" style="padding: 2px 3px 2px 2px;" type="button">{{$inscription->nota($test)['nota']}}</button>
							<?php $total = $total+intval($inscription->nota($test)['nota']); ?>
							<?php $divisor++; ?>
							@else
							<button class="btn btn-primary" style="padding: 2px 2px 2px 2px;" type="button"><i class="fa fa-plus fa-fw"></i></button>
							@endif
						</td>
						@endforeach
						@endforeach
						<?php if($divisor==0){$divisor=1;} ?>
						<?php $div_promedio++; ?>
						<td class="igual" @if ($ban!=1) style="background-color: #BABABA;"@endif>=</td>
						<td class="cont_add_nota" @if ($ban!=1) style="background-color: #BABABA;text-align:center;"@else style="text-align:center;"@endif>{{round( $total/$divisor, 1, PHP_ROUND_HALF_UP)}}</td>
						<?php $promedio = $promedio+round( $total/$divisor, 1, PHP_ROUND_HALF_UP); ?>
						@endforeach
						<td style="text-align: center;"> @if ($promedio!=0)
							<b>{{round( $promedio/$div_promedio, 1, PHP_ROUND_HALF_UP)}}</b>
							@endif
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>
@endforeach
</div>
<style>
	.vista_movil *{font-size: 12px;}
	.vista_movil td{padding: 4px !important;}
	.vista_movil td form{margin: 0 !important;}
	.switch{margin: 0;}
	.nota_contenedor_fechas{position:relative; height: 160px;}
	.nombre_modulo{
		position:absolute;font-size:14px;padding-left:5px;width:80px;z-index:10;top:0;left:0;
	}
	.nombre_materia{
		position:absolute;z-index:10;padding-left:5px;top:20;left:0;white-space: pre;background-color:inherit;cursor:pointer;
	}
	.nombre_materia:hover{
		z-index:100;border:black 1px solid;margin:-2px 0 0 -2px;padding-right:4px;border-radius:2px;-webkit-box-shadow: 2px 2px 5px 0px rgba(0,0,0,0.75);
		-moz-box-shadow: 2px 2px 5px 0px rgba(0,0,0,0.75);
		box-shadow: 2px 2px 5px 0px rgba(0,0,0,0.75);
	}
	.nombre_test_vrt{transform:rotate(-90deg);width:100px;position: absolute;left:-33px;bottom:50px;z-index:10;height:16px;overflow: hidden;
	}
</style>
@endsection