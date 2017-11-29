@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::model($subject,['route' => ['admin.subject.update',$subject->id],'method'=>'put']) !!}
@include('admin.subject.forms.form')
<div class="col-md-1">
	{!! Form::submit('Guardar',['class'=>'btn btn-primary']) !!}
	{!! Form::close() !!}
</div>
@endsection