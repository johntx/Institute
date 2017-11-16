@extends('layouts.header')
@section('body')
<div id="background">
	<img src="{!!URL::to('pictures/web/background.png')!!}">
</div>
<div id="div_paso">
	<div><img src="{!!URL::to('icons/craft.svg')!!}"></div>
	<div><span>PASO A PASO</span></div>
</div>
<div id="video_content">
	<div>
		<div><iframe src=""></iframe></div>
		<div>
			<ul>
				@foreach($crafts as $craft)
				<li class="video" link='{{str_replace('watch?v=','embed/',$craft->link)}}' name='{{$craft->name}}' description='{{$craft->description}}' date='{{$craft->date}}'>
				<div class="l">
						<img src="{{$craft->photo}}">
						<img class="icoplay" src="{!!URL::to('icons/play.svg')!!}">
					</div>
					<div class="r">
						<span class="title">{{$craft->name}}</span><br>
						<span class="description">{{$craft->description}}</span>
					</div>
				</li>
				@endforeach
			</ul>
		</div>
	</div>
</div>
<div id="description">
	<img class="slider" src="{!!URL::to('pictures/web/description.jpg')!!}">
	<div class="content">
		<div>
			<div id="n_v">Nombre Video</div>
			<div id="d_v">Descripcion del video</div>
			<div id="f_v">Fecha del video</div>
		</div>
	</div>
</div>
@include('layouts.footer2')
@include('layouts.footer')
@endsection
@section('css')
{!!Html::style('css/craft.css')!!}
@endsection
@section('js')
{!!Html::script('js/craft.js')!!}
@endsection