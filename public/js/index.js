$('.log').click(function() {
	$('#logmodal').addClass('modal');
});
$('#close_logmodal').click(function() {
	$('#logmodal').removeClass('modal');
});

function resizer() {
	$("#banner").css({'height': $(window).height()});
	$("#imgbann").css({'left':'calc(('+$("#imgbann").width()+'px - '+$(window).width()+'px) / -2 )'});
}
$( document ).ready(function() {
	resizer();
});
$(window).resize(function() {	
	resizer();
});