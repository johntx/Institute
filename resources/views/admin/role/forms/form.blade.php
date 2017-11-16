<div class="form-group">
	{!! Form::label('Code*') !!}
	{!! Form::text('code',null,['class'=>'form-control','placeholder'=>'Insert Code','required', 'maxlength'=>20,'style'=>'text-transform: uppercase;']) !!}
</div>
<div class="form-group">
	{!! Form::label('Name*') !!}
	{!! Form::text('name',null,['class'=>'form-control','placeholder'=>'Insert Name','required', 'maxlength'=>20]) !!}
</div>

<br>

		@foreach($menus as $menu)
		<div class="col-md-3">
			<div class="panel panel-default">
				<div class="panel-heading"><label for="{{ $menu->code }}"><i class="fa fa-{{ $menu->icon }} fa-fw"></i> {{ $menu->label }}</label> <input type="checkbox" class="checkall" id={{ $menu->code }} > </div>
				<div class="panel-body">
					@foreach($menu->functionalities as $functionality)
					<div class="form-group">
						{!! Form::checkbox('functionalities[]',$functionality->id,null,[ 'id'=>$functionality->code , 'class'=>$menu->code]) !!}
						{!! Form::label($functionality->code,$functionality->label) !!}
					</div>
					@endforeach
				</div>
			</div>
		</div>
		@endforeach

<div class="col-md-12"></div>