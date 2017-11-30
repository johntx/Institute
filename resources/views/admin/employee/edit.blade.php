@extends('layouts.admin')
@section('content')
@include('alerts.request')
{!! Form::model($employee,['route' => ['admin.employee.update',$employee->id],'method'=>'put']) !!}
@include('admin.employee.forms.edit')
<div class="col-md-1">
	{!! Form::submit('Guardar',['class'=>'btn btn-primary']) !!}
	{!! Form::close() !!}
</div>
@endsection