<div class="form-group">
	{!! Form::label('Glosa') !!}
	{!! Form::text('glosa',null,['class'=>'form-control','placeholder'=>'Inserte Glosa', 'maxlength'=>200]) !!}
</div>
<div class="form-group">
	{!! Form::label('monto en bs.') !!}
	{!! Form::text('monto',null,['class'=>'form-control','placeholder'=>'Inserte Monto','onkeypress'=>"return justNumbers(event);"]) !!}
</div>
<div class="form-group">
	{!! Form::label('Codigo') !!}
	{!! Form::text('codigo',null,['class'=>'form-control','placeholder'=>'Inserte Codigo', 'maxlength'=>20]) !!}
</div>
<div class="form-group">
	{!! Form::label('Tipo') !!}
	{!! Form::text('tipo',null,['class'=>'form-control dropdown-toggle tipo','placeholder'=>'Pago de alquiler, Compra de items, Reposición económica, etc.', 'maxlength'=>30]) !!}
</div>
<style>
	#lista_compradores{
		width: auto;
		border: 1px solid #D1D1D1;
	}
	#lista_compradores ul{
		list-style-type: none;
		padding: 0; margin: 0;
	}
	#lista_compradores ul li{
		height: 40px;
	}
	#lista_compradores ul li:hover{
		background-color: #E8E8E8;
		cursor: pointer;
	}
	#lista_compradores ul li div{
		padding: 8px 0 0 10px;
	}
</style>