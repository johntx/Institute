@extends('layouts.header')
@section('css')
{!!Html::style('css/account.css')!!}
{!!Html::style('css/admin.css')!!}
@endsection
@section('body')
<div id="background">
	<img src="{!!URL::to('pictures/web/background.png')!!}">
</div>
<div id="body">
	<div>
		<div id="left">
			<div class="editable selector selected" data='account'>
				<span>MI CUENTA</span>
				<img src="{!!URL::to('icons/edit.svg')!!}">
			</div>
			<div class="editable selector" data='business'>
				<span>MI NEGOCIO</span>
				<img src="{!!URL::to('icons/edit.svg')!!}">
			</div>
			<div><span>MIS PEDIDOS</span></div>
			<div><span>MIS COMPRAS</span></div>
			<div><span>OFERTAS</span></div>
		</div>
		<div id="right">
			<div class="content active" id="account">
				<div class="top"><img src="{!!URL::to('icons/usuario.svg')!!}"></div>
				<div class="info">
					<div id="lavel">
						<span>Email:</span>
						<span>Password:</span>
						<span>Nombres:</span>
						<span>Apellidos:</span>
						<span>Teléfono:</span>
					</div>
					<div id="data">
						<div>
							<span id="email">{{ $user->email }}</span>
						</div>
						<div>
							<span>*************</span>
						</div>
						<div>
							<span>{{ $user->client->people->firstname }}</span>
						</div>
						<div>
							<span>{{ $user->client->people->lastname }}</span>
						</div>
						<div>
							<span>{{ $user->client->people->phone }}</span>
						</div>
					</div>
				</div>
			</div>
			<div class="content" id="business">
				<div class="top"><img src="{!!URL::to('icons/business.svg')!!}"></div>
				@if (Auth::user()->client->business != null)
				<div class="info">
					<div id="lavel">
						<span>Nombre:</span>
						<span>Nit:</span>
						<span>Teléfono:</span>
						<span>Dirección:</span>
						<span>Número de Cuenta/Tarjeta:</span>
						<span>Púntos acumulados:</span>
						<span>Mapa:</span>
					</div>
					<div id="data">
						<div>
							<span>{{$user->client->business->name}}</span>
						</div>
						<div>
							<span>{{$user->client->business->nit}}</span>
						</div>
						<div>
							<span>{{$user->client->business->business_phone}}</span>
						</div>
						<div>
							<span>{{$user->client->business->address}}</span>
						</div>
						<div>
							<span>{{$user->client->business->account}}</span>
						</div>
						<div>
							<span>{{$user->client->business->points}}</span>
						</div>
						<div>
							<span>Mapa</span>
						</div>
					</div>
				</div>
				@else
				<div class="bot">
					<div id="reg_bus">
						{!! Form::open(['route' => 'admin.business.store','method'=>'post']) !!}
						{!! Form::text('name',null,['placeholder'=>'Nombre del negocio *','required','maxlength'=>50]) !!}
						{!! Form::text('nit',null,['placeholder'=>'NIT *','maxlength'=>30,'required']) !!}
						{!! Form::text('business_phone',null,['placeholder'=>'Teléfono *','maxlength'=>30,'onkeypress'=>"return justNumbers(event);",'required']) !!}
						{!! Form::text('address',null,['placeholder'=>'Dirección *','required', 'maxlength'=>255]) !!}
						{!! Form::text('account',null,['placeholder'=>'Número de cuenta o targeta', 'maxlength'=>50]) !!}
						{!! Form::submit('Registrar',['class'=>'btn btn-primary']) !!}
						{!! Form::close() !!}
					</div>
					<button id="but_reg_bus">Registra tu negocio!</button>
				</div>
				@endif
			</div>
		</div>
	</div>
</div>
@include('layouts.footer2')
@include('layouts.footer')
@endsection
@section('js')
{!!Html::script('js/account.js')!!}
@endsection