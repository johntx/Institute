<div id="logmodal" class="">
<img id="close_logmodal" src="{!!URL::to('icons/close.svg')!!}">
	<p>Log In</p>
	{!!Form::open(['route'=>'log.store', 'method'=>'POST', 'class'=>'form'])!!}
	{!!Form::text('user',null,['placeholder'=>'User', 'required', 'maxlength'=>100])!!}
	{!!Form::password('password',['placeholder'=>'Password', 'required', 'maxlength'=>60])!!}
	{!!Form::submit('LogIn',['class'=>'btn btn-primary'])!!}
	{!!Form::close()!!}
</div>