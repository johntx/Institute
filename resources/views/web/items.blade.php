@extends('layouts.header')
@section('body')
<div id="background">
	<img src="{!!URL::to('pictures/web/background.png')!!}">
</div>
<div id="menu" class="menu">
	@foreach($groups as $group)
	<a href="{!!URL::to('group/'.$group->code)!!}">
		<span>{{ $group->name }}</span>
		<img src="{!!str_replace('banana','almacen',URL::to($group->photo))!!}">
	</a>
	@endforeach
</div>
<div id="items">
	<div id="title"><p>ITEMS</p></div>
	<div id="content">
		@foreach($items as $item)
		<div class="itm">
			<div class="background_item">
				<div>{{$item->name}}</div>
				<div>{{$item->code}}</div>
				<div class="detail" idt="{{$item->id}}" namet="{{$item->name}}" pricet="{{$item->price}}" detailst="{{$item->details}}" sizet="{{$item->size}}" photot="{!!str_replace('banana','almacen',URL::to($item->images->first()['photo']))!!}"><img src="{!!URL::to('icons/flecha.svg')!!}">DETALLES</div>
			</div>
			<div class="itm_photo">
				<img src="{{ str_replace('banana','almacen',str_replace("items", "thumbnails", URL::to($item->images->first()['photo']))) }}">
			</div>
			<div class="itm_name">
				<div>{{$item->name}}</div>
				<div>{{$item->code}}</div>
			</div>
		</div>
		@endforeach
	</div>
</div>
<div id="paginate">
	{!!$items->render()!!}
</div>
@include('layouts.footer2')
@include('layouts.footer')
<div id="plus"></div>
<div id="zoom">
	<div id="menu2" class="menu">
		@foreach($groups as $group)
		<a href="{!!URL::to('group/'.$group->code)!!}">
			<img src="{!!str_replace('banana','almacen',URL::to($group->photo))!!}">
			<span>{{ $group->name }}</span>
		</a>
		@endforeach
	</div>
	<div id="zoom_itm">
		<img id="close" src="{!!URL::to('icons/close.svg')!!}">
		<div>
			<div id="lft">
				<img src="" />
			</div>
			<div id="rgt">
				<div id="nm_itm"></div>
				<div id="price"><span></span><span>.00 Bs</span></div>
				<div id="add"><button><img src="{!!URL::to('icons/add.svg')!!}"/><span>AÑADIR</span></button><input type="number" min="1" value="1"></div>
				<div id="ftr"><span>Características</span><br>
					<span id="caract_itm"></span>
				</div>
				<div id="sz"><span>Medidas en cm</span><br>
					<span id="sz_itm"></span>
				</div>
			</div>
		</div>
	</div>
	<div id="sel_itm">
		<div id="scr">
			@foreach($items as $item)
			<div class="min_itm" idt="{{$item->id}}" namet="{{$item->name}}" pricet="{{$item->price}}" detailst="{{$item->details}}" sizet="{{$item->size}}" photot="{!!str_replace('banana','almacen',URL::to($item->images->first()['photo']))!!}">
				<span>{{$item->name}}</span>
				<img src="{{ str_replace('banana','almacen',str_replace("items", "thumbnails", URL::to($item->images->first()['photo']))) }}">
			</div>
			@endforeach
		</div>
	</div>
</div>
@endsection
@section('css')
{!!Html::style('css/items.css')!!}
@endsection
@section('js')
{!!Html::script('js/item.js')!!}
@endsection