$('document').ready(function(){
	$(".checkall").change(function () {
		$("input:checkbox."+$(this).attr('id')).prop('checked', $(this).prop("checked"));
	});
	$('.tablab3').DataTable({
		paging: false,
		searching: false,
		ordering: false,
		info: false
	});
	$('.tablaNoOrder').DataTable({
		paging: false,
		ordering: false
	});
	//cargaringresos($('#date_ingresos_inicio').val(),$('#date_ingresos_fin').val());
});
function close_alert() {
	$('.alert_cli').fadeOut();
}
$('#inscribir').on('submit',function(e){
	$.ajaxSetup({
		header:$('meta[name="_token"]').attr('content')
	});
	e.preventDefault(e);
	$.ajax({

		type:"POST",
		url:window.location.origin+'/cien/public/admin/student',
		data:$(this).serialize(),
		dataType: 'json',
		success: function(payment){
			document.getElementById("inscribir").reset();
			$('#career_select').selectpicker('refresh');
			$('#group_id option').empty();
			window.open(window.location.origin+'/cien/public/admin/payment/pdf/'+payment);
		},
		error: function(){
			location.reload();
		}
	});
});
$('#paymentForm').on('submit',function(e){
	$.ajaxSetup({
		header:$('meta[name="_token"]').attr('content')
	});
	e.preventDefault(e);
	$.ajax({
		type:"POST",
		url:window.location.origin+'/cien/public/admin/payment',
		data:$(this).serialize(),
		dataType: 'json',
		success: function(payment){
			window.open(window.location.origin+'/cien/public/admin/payment/pdf/'+payment);
			location.reload();
		},
		error: function(data){
			$('#result').html(data.statusText);
			$('.alert_cli').show();
			setTimeout(function() {
				$(".alert_cli").fadeOut(600);
			},5000);
		}
	});
});
$('.pdfbtn').click(function() {
	$("#pdfModal iframe").attr('src',$(this).attr('href'));
	$("#pdfModal .modal-title").html('RECIBO '+$(this).attr('code'));
	$("#pdfModal").modal();
	return false;
});
$('#pdfModal').on('hidden.bs.modal', function () {
	$("#pdfModal iframe").attr('src','');
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
	yearRange: '1995:'+(new Date).getFullYear(),
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
			$("#payments_carrera").empty();
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
	$('.date_ingresos').change(function(){
		cargaringresos();
	});
});
$(function() {
	$('.dropdown-menu a').click(function() {
		console.log($(this).attr('data-value'));
		$(this).closest('.dropdown').find('input.turno')
		.val($(this).attr('data-value'));
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
function cargaringresos(){
	var inicio = $('#date_ingresos_inicio').val();
	var fin = $('#date_ingresos_fin').val();
	$.get("/cien/public/admin/report/chart/"+inicio+"/"+fin+"",function(listaIngresos,response){
		console.log(listaIngresos);
		$("#ingresos").empty();
		var ctxL = document.getElementById("lineChart").getContext('2d');
		var myLineChart = new Chart(ctxL, {
			type: 'line',
			data: {
				labels: Object.keys(listaIngresos),
				datasets: [
				{
					label: "Ingresos por mes",
					fillColor: "rgba(220,220,220,0.2)",
					strokeColor: "rgba(220,220,220,1)",
					pointColor: "rgba(220,220,220,1)",
					pointStrokeColor: "#fff",
					pointHighlightFill: "#fff",
					pointHighlightStroke: "rgba(220,220,220,1)",
					data: Object.values(listaIngresos)
				}
				]
			},
			options: {
				responsive: true
			}    
		});
		for (var i = 0; i < Object.keys(listaIngresos).length; i++) {
			$('#ingresos').append(
				"<tr><td>"
				+Object.keys(listaIngresos)[i]
				+"</td><td>"
				+Object.values(listaIngresos)[i].toFixed(2)
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
$('body').on('keyup','#buscador',function () {
	if ($(this).val()!='' && $(this).val()!=' ' && $(this).val().length >1) {
		$.get("/cien/public/admin/search/"+$(this).val()+"",function(peoples,response){
			$("#ebuscados>ul").empty();
			$('#ebuscados').removeClass('hide');
			for (var i = 0 ; i < peoples.length; i++) {
				$('#ebuscados>ul').append(
					"<li><a href='"+window.location.origin+"/cien/public/admin/student/search/"+
					+peoples[i].id
					+"'>"
					+peoples[i].fullname
					+"</a></li>"
					);
			}
		});
	} else {
		$("#ebuscados>ul").empty();
	}
});
$('#buscador').focusin(function(){
	$('#ebuscados').removeClass('hide');
});
$('#close_searcher').click(function(){
	$('#ebuscados').addClass('hide');
});