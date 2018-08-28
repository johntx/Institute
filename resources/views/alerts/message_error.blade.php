@if(Session::has('message_error'))
<div class="alert_msg">
	<button type="button" onclick="close_alert_msg()"><span aria-hidden="true">&times;</span></button>
	{!!Session::get('message_error')!!}
</div>
@endif
<script type="text/javascript">
	setTimeout(function() {
		close_alert_msg();
	},8000);
	function close_alert_msg() {
		$(".alert_msg").fadeOut(1000);
	}
</script>
<style>
	.alert_msg {
		position: absolute;
		top: 20px;
		right: 20px;
		z-index: 5000;
		background-color: rgba(200,53,93,0.6);
		min-width: 300px;
		min-height: 60px;
		border-radius: 10px;
		padding: 25px;
		font-size: 20px;
		color: white;
		font-family: arial !important;
	}
	.alert_msg>button{
		position: absolute;
		top: 10px;
		right: 10px;
		border-radius: 50%;
		width: 20px;
		height: 20px;
		border: none;
	}
	.alert_msg>button>span{
		color: #191919;
		position: absolute;
		top: -5px;
		left: 4px;
	}
</style>