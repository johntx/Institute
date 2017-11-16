@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::model($mailbox,['route' => ['admin.mailbox.update',$mailbox->id],'method'=>'put']) !!}
@include('admin.mailbox.forms.form')
<div class="col-md-1">
	{!! Form::submit('Guardar',['class'=>'btn btn-primary']) !!}
	{!! Form::close() !!}
</div>
@endsection