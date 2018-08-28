@extends('layouts.admin')
@section('content')
<br>
@foreach ($career->subjects as $sub)
<a href="{{url('admin/test/create/career/'.$career->id.'/'.$sub->nombre)}}" class="btn" style="@if ($subject->nombre==$sub->nombre) font-weight:bold; border: 2px solid black !important; -webkit-box-shadow: 1px 2px 14px -2px rgba(0,0,0,0.75);-moz-box-shadow: 1px 2px 14px -2px rgba(0,0,0,0.75);box-shadow: 1px 2px 14px -2px rgba(0,0,0,0.75); @endif">{{$sub->nombre}}</a>
@endforeach
<br>
<br>
{!! Form::model($test,['route' => ['admin.test.update',$career->id],'method'=>'put']) !!}
@include('admin.test.forms.form')
{!! Form::submit('Guardar',['class'=>'btn btn-primary']) !!}
{!! Form::close() !!}
@endsection