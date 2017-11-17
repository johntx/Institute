@extends('layouts.header')
@section('body')
<div id="banner">
	<img id="imgbann" src="{!!URL::to('images/ban.png')!!}">
</div>
<div id="careers">
	
</div>
@endsection
@section('css')
{!!Html::style('css/index.css')!!}
@endsection
@section('js')
{!!Html::script('js/index.js')!!}
@endsection