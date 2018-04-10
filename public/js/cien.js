$('.log').click(function() {
	$('#logmodal').addClass('modal');
	$(".navbar-toggler" ).click();
	console.log('click');
});
$('#close_logmodal').click(function() {
	$('#logmodal').removeClass('modal');
});
$( document ).ready(function() {
	facebook();
});
$(window).resize(function() {
	facebook();
});
function facebook(){
	var ancho = $('.fb-page').parent().width();
	$('.fb-page').attr('data-width',ancho);
	(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = 'https://connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v2.12';
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
}