$('document').ready(function(){
	$.each($('.span_res'), function( key, span ) {
		var pos = $(span).attr('r_pos');
		var entrada = $("td[e_pos='"+pos+"']").html();
		var salida = $("td[s_pos='"+pos+"']").html();
		var he = entrada.split(":")[0];
		var me = entrada.split(":")[1];
		var hs = salida.split(":")[0];
		var ms = salida.split(":")[1];
		var horas = ((hs - he)*60 + (ms - me))/60;
		horas = horas.toFixed(2);
		var txt = String(horas);
		horas = parseInt(horas);
		var minutos = txt.split(".")[1];
		minutos = parseInt(minutos*0.6);
		if (minutos<15) {
			minutos = 0;
		} else if (minutos>30 && minutos<45) {
			minutos = 30;
		} else if (minutos>=55) {
			horas++;
			minutos = 00;
		}
		if (minutos<10) {
			minutos = "0"+minutos;
		}
		$("span[r_pos='"+pos+"']").html(parseInt(horas)+":"+minutos);
	});
});
function ocultar() {
	$('#modal_pagar_overall').fadeOut();
}
$('.check').click(function() {
	if ($(this).prop('checked')) {
		$('#modal_pagar_overall').fadeIn();
	}
	var suma_hora = 0;
	var suma_minuto = 0;
	$.each($("input[name='cancelado']:checked"), function( key, input ) {
		var fecha = $(input).val();
		$.each($("span[hora_fecha='"+fecha+"']"), function( key, span ) {
			suma_hora += parseFloat($(span).html().split(":")[0]);
			suma_minuto += parseFloat($(span).html().split(":")[1]);
		});
	});
	suma_hora = suma_hora.toFixed(2);
	var txt = String(suma_hora);
	var hora = parseInt(suma_hora);
	while (suma_minuto>=60) {
		hora++;
		suma_minuto -= 60;
	}
	if (hora>1) {
		var texto = " Horas y ";
	} else {
		var texto = " Hora y ";
	}
	$("#horas_pagar").html(hora+texto+suma_minuto+" Minutos ");
	$("#i_horas_pagar").val(hora+":"+suma_minuto);
	var monto = 0;
	if ($("#pxh").html()!=null) {
		monto = parseFloat($("#pxh").html());
	}
	var	pago = ((suma_minuto/60)+hora)*monto;
	pago = pago.toFixed(2);
	$("#monto_pagar").html(pago+" Bs.");
	$("#i_monto_pagar").val(pago);
	
});
function editar_hora(e){
	var pos = $(e).attr('ed_pos');
	var hora = $("span[r_pos='"+pos+"']").html();
	$('#input_hora').val(hora);
	$('#input_hora').attr("t_pos",pos);
};
$("#edit_ok").on("click",function(){
	var n_hora = $('#input_hora').val();
	var pos = $('#input_hora').attr('t_pos');
	$("span[r_pos='"+pos+"']").html(n_hora);
	clean();
});
function clean() {
	$('#input_hora').attr('t_pos','');
	$('#input_hora').attr('value','');
}
$('#form_pagar').on('submit',function(e) {
	e.preventDefault(e);
	var data = $(this).serialize();
	$.each($("input[name='cancelado']:checked"), function( key, input ) {
		var fecha = $(input).val();
		data = data+"&fecha%5B"+key+"%5D="+fecha;
	});
	var url = $(this).attr("action");
	$.ajaxSetup({
		header:$('meta[name="_token"]').attr('content')
	});
	$.ajax({
		type:"POST",
		url:url,
		data:data,
		dataType: 'json',
		success: function(payment){
			console.log('guardado:'+payment);
			location.reload();
		},
		error: function(ret){
			console.log('error: '+ret);
		}
	});
});