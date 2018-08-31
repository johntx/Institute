@extends('layouts.admin')
@section('content')
@include('alerts.request')
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
			@foreach (\Institute\Test::where('subject_id',$subject->id)->where('career_id',$career->id)->groupBy('modulo')->orderBy('modulo','asc')->get() as $ttsm)
			<div class="panel panel-default modulo_padre">
				<div class="panel-heading"><b><span>Módulo: </span><span class="n_modulo"></span></b></div>

				@foreach (\Institute\Test::where('subject_id',$subject->id)->where('career_id',$career->id)->where('modulo',$ttsm->modulo)->orderBy('orden','asc')->get() as $ord=>$test)
				<div class="panel-body">
					<div class="col-md-11" style="padding: 0;">
						{{$test->nombre}}
					</div>
					<div class="col-md-1"></div>
				</div>
				@endforeach
			</div>
			@endforeach
		</div>
		@endforeach
	</div>
</div>
@endsection
@section('adminjs')
<script>
	$('document').ready(function(){
		numerar_modulo2();
	});
	function numerar_modulo2() {
		$.each($("div.subject_modulo"), function( key, sub ) {
			$.each($(sub).children(), function( key, modulo ) {
				$(modulo).children().children().children('span.n_modulo').html(key+1);
				$(modulo).children().children().children('input.input_modulo').val(key+1);
				$.each($(modulo).children().children().children('input.orden'), function( key, orden ) {
					$(orden).val(key+1);
				});
			});
		});
	}
</script>
@endsection