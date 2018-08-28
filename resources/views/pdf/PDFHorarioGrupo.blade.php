<!DOCTYPE html>
<html lang="es" ondragstart="return false">
<!-- oncontextmenu="return false"  onselectstart="return false" -->
<head>
	<title>Horario: {{Jenssegers\Date\Date::parse($group->startclass->fecha)->format('j M Y')}} Turno: {{$group->turno}}</title>
	<meta charset="utf-8">
	<meta name = "format-detection" content = "telephone=no" />
	<link rel="icon" type="image/png" href="{!!URL::to('icons/logomin.png')!!}" />
	<style>
		body { font-family: DejaVu Sans; margin-top: -25px; }
		table {
			width: 100%;
			border-spacing: 0;
			border-collapse: collapse;
		}
		table *{
			font-size: 11px;
			padding: 0;
		}
		th{
			padding: 5px !important;
			font-size: 13px !important;
		}
		table.sch *{
			text-align: center;
		}
		table.sch tr{
			height: 10px;
		}
		table.sch th{
			padding: 8px;
		}
		table.sch th[dia="dia"]{
			background-color: #5D5D5D;
			color: white;
		}
		table.sch td[x="0"]{
			position: relative;
			font-size: 10px;
		}
		table.sch tr[hmas="hmas"] td[x="0"]{
			height: 20px;
			font-size: 13px;
		}
		table.sch td[x="0"]>div{
			height: 20px;
			width: 50px;
			position: absolute;
			padding: 1px;
			top: -10px;
			border-radius: 5px;
			left: 5px;
		}
		table.sch tr[hmas="hmas"] td[x="0"]{
			border-top: 3px solid black;
		}
		table.sch td[x="0"]{
			border-right: 3px solid black;
		}
		table.sch tr[hmas="hmas"] td[x="0"]>div{
			height: 18px;
			width: 50px;
			position: absolute;
			color: white;
			background-color: black;
			padding: 1px;
			top: -10px;
			border-radius: 5px;
			left: 5px;
		}
		table.sch tr[mid="mid"]{
			background-color: #B0E7E9;
		}
		.agua{
			position: absolute;
			width: 450px;
			left: 150px;
			top: 60px;
		}
	</style>
</head>
<body>
	<table class="sch">
		<tbody>
			<tr>
				<th colspan="7">HORARIO {{$group->startclass->career->nombre}} {{$group->turno}}</th>
			</tr>
			<tr>
				@foreach ($semana as $dia)
				<th dia="dia">{{strtoupper($dia)}}</th>
				@endforeach
			</tr>
			@foreach ($horario as $key=>$hora)
			<?php $h=$key+1; ?>
			<tr h="{{$key+1}}" @if ($key%2!=0 && $key<11) hmas="hmas" @elseif ($key%2==0 && $key>13 && $key<23) hmas="hmas" @endif @if ($key>8 && $key<14 || $key>21)  mid="mid" @endif>
				@foreach ($semana as $x=>$dia)
				@if ($dia == 'hora')
				<td x="{{$x}}"><div>{{$hora}}</div></td>
				@else
				<?php
				$hour = $group->hours()->join('schedules','hours.schedule_id','=','schedules.id')->join('subjects','hours.subject_id','=','subjects.id')->join('groups','hours.group_id','=','groups.id')->join('peoples','hours.people_id','=','peoples.id')->join('startclasses','groups.startclass_id','=','startclasses.id')->join('careers','startclasses.career_id','=','careers.id')->select('hours.*','subjects.nombre as asignatura','careers.nombre as carrera','startclasses.fecha_inicio as fecha','peoples.nombre as profesor')->where('schedules.vigente','si')->where('hours.dia',$dia)->where('hours.hora_inicio',$hora)->first();
				?>
				<td x="{{$x}}">
					<div class="sch_hour" hora='{{$hour['id']}}' size="{{$hour['periodos']}}" carrera="<b>{{$hour['asignatura']}}</b>" fecha="" asignatura="{{$hour['profesor']}}" aula="{{$hour['piso']}} {{$hour['aula']}}">
						@if ($hour['asignatura'])
						<?php $sum = $h + $hour['periodos'];
						?>
						<style>
							@for ($i = $h; $i < $sum; $i++) tr[h="{{$i}}"]>td[x="{{$x}}"]{ border-left:3px solid black; border-right:3px solid black; @if ($i == $h) border-top:3px solid black; font-size: 13px !important; padding: 0 !important; @endif @if ($i == $sum-1) border-bottom:3px solid black; @endif @if ($i == $h+1) } tr[h="{{$i}}"]>td[x="{{$x}}"]>div:after{ content: "{{$hour['profesor']}}"; @endif @if ($i == $sum-1) } tr[h="{{$i}}"]>td[x="{{$x}}"]>div:after{ content: "{{$hour['piso']}} {{$hour['aula']}}"; @endif } @endfor
						</style>
						@endif
						<b>{{$hour['asignatura']}}</b>
					</div>
				</td>
				@endif
				@endforeach
			</tr>
			@endforeach
		</tbody>
	</table>
	<img class="agua" src="{!!URL::to('icons/agua.svg')!!}">
</body>
</html>