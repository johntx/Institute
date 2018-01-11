<div class="alert_cli">
	<button type="button" onclick="close_alert()"><span aria-hidden="true">&times;</span></button>
	<div class="result">Error</div>
</div>
<script type="text/javascript">
</script>
<style>
	.alert_cli {
		position: fixed;
		top: 50px;
		right: 20px;
		z-index: 5000;
		background-color: rgba(200,53,93,0.5);
		min-width: 300px;
		min-height: 60px;
		border-radius: 10px;
		padding: 25px;
		font-size: 20px;
		color: white;
		font-family: arial !important;
		display: none;
	}
	.alert_cli>button{
		position: absolute;
		top: 10px;
		right: 10px;
		border-radius: 50%;
		width: 20px;
		height: 20px;
		border: none;
		background-color: #FFFFFF;
	}
	.alert_cli>button>span{
		color: #191919;
		position: absolute;
		top: -4px;
		left: 4.5px;
	}
	.result{
		font-size: 18px;
		text-align: left;
	}
</style>