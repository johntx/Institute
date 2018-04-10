<div class="panel panel-primary">
<div class="panel-heading">DOCENTE: {{$teacher->nombrecompleto()}} {{$teacher->id}}</div>
	<div class="panel-body">
		<div class="form-group">
			{!! Form::label('¿Inicia sus clases con puntualidad?') !!}&emsp;
			1: {!! Form::radio('p1','1',false,['required']) !!}&ensp;
			2: {!! Form::radio('p1','2',false,['required']) !!}&ensp;
			3: {!! Form::radio('p1','3',false,['required']) !!}&ensp;
			4: {!! Form::radio('p1','4',false,['required']) !!}&ensp;
			5: {!! Form::radio('p1','5',false,['required']) !!}&ensp;
		</div>
		<div class="form-group">
			{!! Form::label('¿Describe y explica los temas de forma ordenada y entendible?') !!}&emsp;
			1: {!! Form::radio('p2','1',false,['required']) !!}&ensp;
			2: {!! Form::radio('p2','2',false,['required']) !!}&ensp;
			3: {!! Form::radio('p2','3',false,['required']) !!}&ensp;
			4: {!! Form::radio('p2','4',false,['required']) !!}&ensp;
			5: {!! Form::radio('p2','5',false,['required']) !!}&ensp;
		</div>
		<div class="form-group">
			{!! Form::label('¿Escucha y responde con amabilidad las preguntas o dudas?') !!}&emsp;
			1: {!! Form::radio('p3','1',false,['required']) !!}&ensp;
			2: {!! Form::radio('p3','2',false,['required']) !!}&ensp;
			3: {!! Form::radio('p3','3',false,['required']) !!}&ensp;
			4: {!! Form::radio('p3','4',false,['required']) !!}&ensp;
			5: {!! Form::radio('p3','5',false,['required']) !!}&ensp;
		</div>
		<div class="form-group">
			{!! Form::label('¿Estumila tus respuestas correctas en clases?') !!}&emsp;
			1: {!! Form::radio('p4','1',false,['required']) !!}&ensp;
			2: {!! Form::radio('p4','2',false,['required']) !!}&ensp;
			3: {!! Form::radio('p4','3',false,['required']) !!}&ensp;
			4: {!! Form::radio('p4','4',false,['required']) !!}&ensp;
			5: {!! Form::radio('p4','5',false,['required']) !!}&ensp;
		</div>
		<br>
		{!! Form::label('C1EN:') !!}
		<br>
		<div class="form-group">
			{!! Form::label('¿Cuál es su satisfacción con C1EN?') !!}&emsp;
			1: {!! Form::radio('p5','1',false,['required']) !!}&ensp;
			2: {!! Form::radio('p5','2',false,['required']) !!}&ensp;
			3: {!! Form::radio('p5','3',false,['required']) !!}&ensp;
			4: {!! Form::radio('p5','4',false,['required']) !!}&ensp;
			5: {!! Form::radio('p5','5',false,['required']) !!}&ensp;
		</div>
		<div class="form-group">
			{!! Form::label('¿En que se necesita mejorar?') !!}
			{!! Form::textarea('p6','',['class'=>'form-control','maxlength'=>255,'rows'=>3]) !!}
			{!! Form::hidden('people_id',$teacher->id) !!}
			{!! Form::hidden('inscription_id',$inscription->id) !!}
		</div>
	</div>
</div>