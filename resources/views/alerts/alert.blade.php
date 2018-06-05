@if(Session::has('alert'))
<div class="alert alert-warning alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	{{Session::get('alert')}}
</div>
@endif
<script>
	setTimeout(function() {
		$(".alert").fadeOut(1000);
	},7000);
</script>