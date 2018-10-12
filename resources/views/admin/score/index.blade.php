@extends('layouts.admin')
@section('adminjs')
{!!Html::script('js/score.js')!!}
<link href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css" rel="stylesheet"/>
<script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/3.2.2/js/dataTables.fixedColumns.min.js"></script>
<link href="https://cdn.datatables.net/fixedcolumns/3.2.2/css/fixedColumns.dataTables.min.css" rel="stylesheet"/>
@endsection
@section('content')
@foreach ($hours as $h)
<h4>({{Jenssegers\Date\Date::parse($h->group->startclass->fecha_inicio)->format('j M Y')}}) - <b>{{$h->group->startclass->career->nombre}}</b> - {{$h->group->turno}}</h4>
<div class="table-responsive vista_movil tabla_score_ver">
	<table class="table table-hover table-condensed">
		<thead>
			<th class="sobre">Nombre</th>
			<?php $rec_partial=0; $igual=true; $ban=1;?>
			@foreach (\Institute\Test::where('career_id',$h->group->startclass->career_id)->where('subject_id',$h->subject_id)->groupBy('modulo')->orderBy('modulo','asc')->get() as $k=>$test_modulo)
			@foreach (\Institute\Test::where('career_id',$h->group->startclass->career_id)->where('subject_id',$h->subject_id)->where('modulo',$test_modulo->modulo)->orderBy('orden','asc')->get() as $k=>$test)
			<?php if ($rec_partial!=$test_modulo->id){$igual=false;$ban=$ban*-1;}
			else{$igual=true;}
			$rec_partial=$test_modulo->id; ?>
			<th class="nota_contenedor_fechas" @if ($ban!=1) style="background-color: #BABABA;"@endif>
				@if (!$igual)
				<div class="nombre_modulo">{{' MODULO '.$test_modulo->modulo}}</div>
				@endif
				<p class="nombre_test_vrt">{{$test->nombre}}</p>
			</th>
			@endforeach
			<th class="igual" @if ($ban!=1) style="background-color: #BABABA;"@endif></th>
			<th @if ($ban!=1) style="background-color: #BABABA;"@endif><p class="dia_inicial">Total</p></th>
			@endforeach
		</thead>
		@foreach(\Institute\Inscription::leftjoin('scores','scores.inscription_id','=','inscriptions.id')->join('peoples','inscriptions.people_id','=','peoples.id')->select('inscriptions.*','scores.nota as nota')->where('inscriptions.group_id',$h->group_id)->groupBy('inscriptions.id')->orderBy('peoples.nombre','asc')->get() as $i=>$inscription)
		<tr @if ($inscription->estado == 'Retirado') style="background-color:#A460B8;" @endif @if ($inscription->debit()) style="background-color: #FF7878;"@elseif ($inscription->debitNext()) style="background-color: #FFF961;"@else style="background-color: #91F47E;"@endif>
			<td>{{$inscription->people->nombrecompleto()}}</td>
			<?php $rec_partial=0; $ban=1;?>
			@foreach (\Institute\Test::where('career_id',$h->group->startclass->career_id)->where('subject_id',$h->subject_id)->groupBy('modulo')->orderBy('modulo','asc')->get() as $k=>$test_modulo)
			<?php $total = 0; $divisor = 0; ?>
			<?php if ($rec_partial!=$test_modulo->id){$ban=$ban*-1;}?>
			@foreach (\Institute\Test::where('career_id',$h->group->startclass->career_id)->where('subject_id',$h->subject_id)->where('modulo',$test_modulo->modulo)->orderBy('orden','asc')->get() as $k=>$test)
			<td @if ($ban!=1) style="background-color: #BABABA;" @else style="background-color:white;"@endif>
				@if ($inscription->nota($test)!=null)
				<button class="edit_nota btn btn-default" style="padding: 2px 3px 2px 2px;" type="button" inscription_id="{{$inscription->id}}" group_id="{{"$h->group_id"}}" test_id="{{$test->id}}" nota="{{$inscription->nota($test)['nota']}}" score_id="{{$inscription->nota($test)['id']}}" class="btn btn-default" aria-label="Left Align">{{$inscription->nota($test)['nota']}}</button>
				<?php $total = $total+intval($inscription->nota($test)['nota']); ?>
				<?php $divisor++; ?>
				@else
				<button class="new_nota btn btn-primary" style="padding: 2px 2px 2px 2px;" type="button" inscription_id="{{$inscription->id}}" group_id="{{$h->group_id}}" subject_id="{{"$h->subject_id"}}" test_id="{{$test->id}}" class="btn btn-default" aria-label="Left Align"><i class="fa fa-plus fa-fw"></i></button>
				@endif
			</td>
			@endforeach
			<?php if($divisor==0){$divisor=1;} ?>
			<td class="igual" @if ($ban!=1) style="background-color: #BABABA;"@endif>=</td>
			<td class="cont_add_nota" @if ($ban!=1) style="background-color: #BABABA;"@endif>{{round( $total/$divisor, 1, PHP_ROUND_HALF_UP)}}</td>
			@endforeach
		</tr>
		@endforeach
	</table>
</div>
@endforeach
<div class="modal_nota">
	<span class="modal_nota_close">&times;</span>
	{!! Form::open(['route' => 'admin.score.store', 'id'=>'asig_nota']) !!}
	<input type="text" name="nota" class="nota" placeholder="Nota" onkeypress="return justNumbers(event);" autofocus autocomplete="off">
	<input type="hidden" name="inscription_id" class="inscription_id" value="">
	<input type="hidden" name="test_id" value="{{null}}" class="test_id">
	<input type="hidden" name="score_id" value="{{null}}" class="score_id">
	<input type="hidden" name="group_id" value="{{null}}" class="group_id">
	<input type="hidden" name="subject_id" value="{{null}}" class="subject_id">
	<input type="hidden" name="piso" value="{{$piso}}">
	<input type="hidden" name="aula" value="{{$aula}}">
	<input type="hidden" name="dia" value="{{$dia}}">
	<button class="btn btn-primary">Guardar</button>
	{!! Form::close() !!}
</div>
<style>
	.vista_movil *{font-size: 12px;}
	.vista_movil td{padding: 4px !important;}
	.vista_movil td form{margin: 0 !important;}
	.switch{margin: 0;}
	.nota_contenedor_fechas{position:relative; height: 220px;}
	.sobre{
		z-index: 10;position: relative;background-color:#FFFFFF;
	}
	.nombre_modulo{
		position:absolute;font-size:14px;padding-left:5px;width:100px;z-index:10;bottom:200px;left:0;
	}
	.nombre_test_vrt{transform:rotate(-90deg);width:170px;position: absolute;left:-70px;bottom:85px;z-index:10;height:16px;overflow: hidden;
	}
</style>
<div class="background_modal">
	<span>Nombre: </span><span class="nombre_mod_nota"></span><br>
	<span>Parcial: </span><span class="parcial"></span>
</div>
@endsection