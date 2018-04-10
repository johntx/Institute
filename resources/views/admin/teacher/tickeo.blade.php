@extends('layouts.admin')
@section('content')
@include('alerts.succes')
<div>
	<div class="form-group">
		{!! Form::label('Desde') !!}
		{!! Form::text('fecha',Carbon\Carbon::now()->subMonth()->format('Y-m-d'),['class'=>'form-control datepicker','id'=>'fecha_tickeos','placeholder'=>'yyyy-mm-dd']) !!}
	</div>
	{!!link_to_action('TickeoController@tickeoEmpleado', $title = 'Obtener Tickeos', $parameters = $biometric_id.'/'.Carbon\Carbon::now()->subMonth()->format('Y-m-d'), $attributes = ['class'=>'btn btn-info pdftickeo','code'=>$biometric_id])!!}
</div>
<div class="modal fade" id="pdfModal" tabindex="0" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document" style="z-index: 2000">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Tickeos</h4>
			</div>
			<div style="text-align: center;">
				<iframe src="" style="width:100%; height:80%;" frameborder="0"></iframe>
			</div>
		</div>
	</div>
</div>
@endsection