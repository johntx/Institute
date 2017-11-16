@if(Session::has('status'))
<div class="alert alert-success alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	{{Session::get('status')}}
</div>
@endif
<script>
	setTimeout(function() {
		$(".alert").fadeOut(1000);
	},7000);
</script>