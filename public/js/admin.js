$('document').ready(function(){
	$(".checkall").change(function () {
		$("input:checkbox."+$(this).attr('id')).prop('checked', $(this).prop("checked"));
	});
});
$.datepicker.regional['es'] = {
	closeText: 'Cerrar',
	prevText: '< Ant',
	nextText: 'Sig >',
	currentText: 'Hoy',
	monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
	monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
	dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
	dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
	dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
	weekHeader: 'Sm',
	dateFormat: 'dd/mm/yy',
	yearRange: '1990:2018',
	firstDay: 1,
	isRTL: false,
	showMonthAfterYear: false,
	yearSuffix: ''
};
$.datepicker.setDefaults($.datepicker.regional['es']);
$('document').on('click','li.active',function() {
	$(this).removeClass('active');
	$(this).addClass('active');
});
$('body').on('focus','input.datepicker',function () {
	//$(this).removeClass('hasDatepicker');
	$(this).datepicker({
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		changeYear: true
	}).focus();
});
$('body').on('keyup','.mes',function () {
	if ($(this).val()=='' || $(this).val()=='0') {
		$('.duracion').css('background-color','#fff');
	} else {
		$('.duracion').css('background-color','#eee');
		$('.mes').css('background-color','#fff');
		$('.duracion').val('');
	}
});
$('body').on('keyup','.duracion',function () {
	if ($(this).val()=='' || $(this).val()=='0') {
		$('.mes').css('background-color','#fff');
	} else {
		$('.duracion').css('background-color','#fff');
		$('.mes').css('background-color','#eee');
		$('.mes').val('');
	}
});
$(document).ready(function(){
	$('#career_select').change(function(){
		$.get("/cien/public/admin/groups/"+event.target.value+"",function(group,response){
			/*console.log(group);*/
			$("#group_id").empty();
			for (var i = 0 ; i < group.length; i++) {
				$('#group_id').append("<option value='"
					+group[i].id+"'>"+group[i].nombre+" "
					+group[i].turno+" ("+group[i].inscritos+" inscritos)"
					+"</option>");
			}
		});
		$('#monto').val($(this).children('option:selected').attr('costo'));
		
		$('#meses').html($(this).children('option:selected').attr('duracion'));
		change_total();
	});
	$('#payments_estudiante').change(function(){
		$.get("/cien/public/admin/inscriptions/"+event.target.value+"",function(inscription,response){
			/*console.log(inscription);*/
			$("#payments_carrera").empty();
			/*$('#payments_carrera').append(
			"<option selected disabled> Elija una carrera </option>");*/
		$('#colegiatura').html(inscription[0].colegiatura);
			cargarpagos(inscription[0].id);
			for (var i = 0 ; i < inscription.length; i++) {
				var date = inscription[i].fecha_inicio;
				date = date.substring(0,10).split('-');
				date = date[1] + '-' + date[2] + '-' + date[0];

				
				$('#payments_carrera').append(
					"<option value='"+inscription[i].id
					+"' colegiatura='"+inscription[i].colegiatura+"' >"+inscription[i].carrera
					+" - ("+$.datepicker.formatDate('dd M yy', new Date(date))
					+") - "+inscription[i].turno
					+" - "+inscription[i].estado
					+"</option>");
			}
		});
	});
	$('#payments_carrera').change(function(){
		cargarpagos(event.target.value);
		$('#colegiatura').html($(this).children('option:selected').attr('colegiatura'));
	});
});
function cargarpagos(inscription_id){
	$.get("/cien/public/admin/payments/"+inscription_id+"",function(payments,response){
		/*console.log(payments);*/
		$("#payments_pagos").empty();
		for (var i = 0 ; i < payments.length; i++) {
			if (payments[i].fecha_pago == null) {
				var fecha_pago = '';
			} else {
				var date = payments[i].fecha_pago;
				date = date.substring(0,10).split('-');
				date = date[1] + '-' + date[2] + '-' + date[0];
				var fecha_pago = $.datepicker.formatDate('dd M yy', new Date(date));
			}
			if (payments[i].observacion == null) {
				var observacion = '';
			} else {
				var observacion = payments[i].observacion;
			}
			if (payments[i].abono == 0) {
				var abono = '';
			} else {
				var abono = payments[i].abono;
			}

			var date2 = payments[i].fecha_pagar;
			date2 = date2.substring(0,10).split('-');
			date2 = date2[1] + '-' + date2[2] + '-' + date2[0];
			var fecha_pagar = $.datepicker.formatDate('dd M yy', new Date(date2));

			$('#payments_pagos').append(
				"<tr><td>"
				+payments[i].id
				+"</td><td>"
				+fecha_pagar
				+"</td><td>"
				+fecha_pago
				+"</td><td>"
				+abono
				+"</td><td>"
				+payments[i].saldo
				+"</td><td>"
				+payments[i].estado
				+"</td><td>"
				+observacion
				+"</td></tr>"
			);
		}
	});
}
function change_total(){
	var total = 0;
	total = parseInt($('#meses').html())*parseInt($('#monto').val());
	$('.total').val(total);
}
$('body').on('keyup','#monto',function () {
	change_total();
});
function justNumbers(e){
	var key = e.which || e.keyCode; 
	patron = /\d/;
	te = String.fromCharCode(key); 
	return (patron.test(te) || key == 9 || key == 8 || key == 46 || key == 13);
}