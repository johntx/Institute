@extends('layouts.admin')
@section('content')
@include('alerts.succes')
<div class="table-responsive">
	<table class="table table-hover">
		<thead>
			<th>Id</th>
			<th>Name</th>
			<th>Email</th>
			<th>Phone</th>
			<th>Client</th>
			<th>Text</th>
			<th>Operation</th>
		</thead>
		@foreach($mailboxes as $mailbox)
		<tbody>
			<td>{{$mailbox->id}}</td>
			<td>{{$mailbox->name}}</td>
			<td>{{$mailbox->email}}</td>
			<td>{{$mailbox->phone}}</td>
			<td>
				@if ($mailbox->client)
				[ id: {{$mailbox->client->id}} ]<br>
				{{$mailbox->client->people->firstname}}<br>
				{{$mailbox->client->people->lastname}}
				@endif
			</td>
			<td>{{$mailbox->text}}</td>
			@foreach(Auth::user()->role->functionalities as $func)
			@if ($func->code=='EMAL')
			<td>
				{!!link_to_route('admin.mailbox.edit', $title = 'Editar', $parameters = $mailbox->id, $attributes = ['class'=>'btn btn-primary'])!!}
			</td>
			@endif
			@if ($func->code=='DMAL')
			<td>
				{!!link_to_route('admin.mailbox.show', $title = 'Borrar', $parameters = $mailbox->id, $attributes = ['class'=>'btn btn-danger'])!!}
			</td>
			@endif
			@endforeach
		</tbody>
		@endforeach
	</table>
</div>
{!!$mailboxes->render()!!}
@endsection