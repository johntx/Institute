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
	$('.tablaOrder').DataTable({
		paging: false,
		searching: false,
		info: false
	});
	$('.tablaNoOrder').DataTable({
		paging: false,
		ordering: false
	});
	$('#boton_fecha_income').click(function() {
		var href = $('#boton_fecha_income').attr('href');
		var fecha = $('#selec_fecha_income').val();
		var string = href.split("fecha").join(fecha);  
		$("#boton_fecha_income").attr('href',string);
	});
});
function close_alert() {
	$('.alert_cli').fadeOut();
}
$('#inscribir').on('submit',function(e){
	$.ajaxSetup({
		header:$('meta[name="_token"]').attr('content')
	});
	e.preventDefault(e);
	$('#inscribir input[type=submit]').attr("disabled", true);
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
		error: function(data){
			$('.result').html(data.statusText);
			$('.alert_cli').show();
			setTimeout(function() {
				$(".alert_cli").fadeOut(600);
			},5000);
		}
	});
});
$('#reinscribir').on('submit',function(e){
	$.ajaxSetup({
		header:$('meta[name="_token"]').attr('content')
	});
	e.preventDefault(e);
	$('#reinscribir input[type=submit]').attr("disabled", true);
	$.ajax({
		type:"POST",
		url:window.location.origin+'/cien/public/admin/inscription',
		data:$(this).serialize(),
		dataType: 'json',
		success: function(payment){
			document.getElementById("reinscribir").reset();
			$('#student_select').selectpicker('refresh');
			$('#career_select').selectpicker('refresh');
			$('#group_id option').empty();
			window.open(window.location.origin+'/cien/public/admin/payment/pdf/'+payment);
		},
		error: function(data){
			$('.result').html(data.statusText);
			$('.alert_cli').show();
			setTimeout(function() {
				$(".alert_cli").fadeOut(600);
			},5000);
		}
	});
});
$('#paymentForm').on('submit',function(e){
	$.ajaxSetup({
		header:$('meta[name="_token"]').attr('content')
	});
	e.preventDefault(e);
	$('#paymentForm input[type=submit]').attr("disabled", true);
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
			$('.result').html(data.statusText);
			$('.alert_cli').show();
			setTimeout(function() {
				$(".alert_cli").fadeOut(600);
			},5000);
		}
	});
});
$('.pdfbtn').click(function() {
	$("#pdfModal iframe").attr('src',$(this).attr('href'));
	$("#pdfModal .modal-title").html('PDF ID: '+$(this).attr('code'));
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
	yearRange: '1990:'+(new Date).getFullYear(),
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
/*payments*/
$(document).ready(function(){
	$('#career_select').change(function(){
		$.get("/cien/public/admin/groups/"+event.target.value+"",function(group,response){
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
		var career = $(this).children('option:selected').attr('carrera');
		if (career=='MILITARES' || career=='POLICIAS') {
			$('#div_extra').css('display','block')
		} else {
			$('#div_extra').css('display','none')
		}
	});
	$('#payments_estudiante').change(function(){
		$.get("/cien/public/admin/inscriptions/"+event.target.value+"",function(inscription,response){
			$("#payments_carrera").empty();
			var deuda = inscription[0].total-inscription[0].abono;
			if (deuda==0) {
				deuda=' ';
			} else {
				deuda=': '+deuda;
			}
			$('#colegiatura').html(inscription[0].colegiatura+deuda);
			var fecha_ingreso = inscription[0].fecha_ingreso;
			fecha_ingreso = fecha_ingreso.substring(0,10).split('-');
			fecha_ingreso = fecha_ingreso[1] + '-' + fecha_ingreso[2] + '-' + fecha_ingreso[0];
			$('#fecha_ingreso').html($.datepicker.formatDate('dd M yy', new Date(fecha_ingreso)));
			cargarpagos(inscription[0].id);
			for (var i = 0 ; i < inscription.length; i++) {
				var date = inscription[i].fecha_inicio;
				date = date.substring(0,10).split('-');
				date = date[1] + '-' + date[2] + '-' + date[0];
				var deuda2 = inscription[i].total-inscription[i].abono;
				if (deuda2==0) {
					deuda2=' ';
				} else {
					deuda2=': '+deuda2;
				}
				$('#payments_carrera').append(
					"<option value='"+inscription[i].id
					+"' colegiatura='"+inscription[i].colegiatura+deuda2+"' fecha_inicio='"+inscription[i].colegiatura+"' >"+inscription[i].carrera
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
		$(this).closest('.dropdown').find('input.turno')
		.val($(this).attr('data-value'));
	});
});
function cargarpagos(inscription_id){
	$.get("/cien/public/admin/payments/"+inscription_id+"",function(payments,response){
		
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
		
		$("#ingresos").empty();
		var total = []; 
		var egreso = []; 
		var ingreso = []; 
		var meses = []; 
		for (var i = 0; i < Object.keys(listaIngresos).length; i++) {
			$('#ingresos').append(
				"<tr><td>"
				+$.datepicker.formatDate('MM', new Date(listaIngresos[i]['fecha']+"T11:22:33+0000"))
				+"</td><td>"
				+listaIngresos[i]['ingreso'].toFixed(2)
				+"</td><td>"
				+listaIngresos[i]['egreso'].toFixed(2)
				+"</td><td>"
				+listaIngresos[i]['total'].toFixed(2)
				+"</td></tr>"
				);
			egreso.push(listaIngresos[i]['egreso'].toFixed(2));
			total.push(listaIngresos[i]['total'].toFixed(2));
			ingreso.push(listaIngresos[i]['ingreso'].toFixed(2));
			meses.push($.datepicker.formatDate('MM', new Date(listaIngresos[i]['fecha']+"T11:22:33+0000")));
		}
		var ctxL = document.getElementById("lineChart").getContext('2d');
		var myLineChart = new Chart(ctxL, {
			type: 'line',
			data: {
				labels: meses,
				datasets: [{
					label: "Totales",
					borderColor: "#1FDD00",
					fillColor: "rgba(0,0,255,0.2)",
					data: total
				},
				{
					label: "Ingresos",
					borderColor: "#93C4BF",
					fillColor: "rgba(139,231,221,0.3)",
					data: ingreso
				},
				{
					label: "Egresos",
					borderColor: "#B63838",
					fillColor: "rgba(182,56,56,0.2)",
					data: egreso
				}
				]
			},
			options: {
				responsive: true,
				title: {
					display: true,
					text: 'Ingresos y Egresos económicos globales'
				}
			}    
		});
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
$('body').on('click','.extra',function () {
	extra_simple(this);
});
function extra_simple(element) {
	var precio = $(element).attr('precio');
	if ($(element).prop('checked')){
		var suma = parseInt(precio)+parseInt($('#monto').val());
		$('#monto').val(suma);
	} else {
		var resta = parseInt($('#monto').val())-parseInt(precio);
		$('#monto').val(resta);
	}
	change_total();
}
$('body').on('click','.extra2',function () {
	var total = parseInt($('#totl').val())-parseInt($('#abon').attr('abono'));
	var mesrestante = parseInt(total / $('#monto').val());
	var precio = $(this).attr('precio');
	if ($(this).prop('checked')){
		var suma = parseInt(precio)+parseInt($('#monto').val());
		$('#monto').val(suma);
		var asumar = mesrestante*$(this).attr('precio');
		var suma_total = parseInt(asumar)+parseInt($('#totl').val());
		$('#totl').val(suma_total);
	} else {
		var resta = parseInt($('#monto').val())-parseInt(precio);
		$('#monto').val(resta);
		var arestar = mesrestante*$(this).attr('precio');
		var resta_total = parseInt($('#totl').val())-parseInt(arestar);
		$('#totl').val(resta_total);
	}
	$('#totl').val();
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
					+"' class='atxt'>"
					+peoples[i].fullname
					+"</a><a href='"+window.location.origin+"/cien/public/admin/student/"
					+peoples[i].id
					+"/edit' class='btn bedit btn-warning'><i class='fa fa-edit fa-fw'></i></a></li>"
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
$('body').on('click','.space_destroy',function () {
	$(this).parent().parent().parent().remove();
});
$('body').on('click','.btn_quitar_subject',function () {
	$(this).parent().remove();
});
$('body').on('click','.add_subject_form_career',function () {
	$('#list_subject_form_career').append(
		"<li class='list-group-item list-group-item-success'>"
		+$(this).attr('name_subject')
		+"<button class='btn btn-danger btn_quitar_subject' type='button'><i class='fa fa-close fa-fw'></i></button><input type='hidden' name='subjects[]' value='"
		+$(this).attr('id_subject')
		+"' ></li>"
		);
});
$('.btn_expand').click(function(){
	var convocatoria = $(this).attr('convocatoria');
	var active = $('#'+convocatoria).attr('active');
	if (active == 'no') {
		$('#'+convocatoria).attr('active','active');
		$(this).html('-');
	} else {
		$('#'+convocatoria).attr('active','no');
		$(this).html('+');
	}
});
$('#get_tickeos').click(function() {
	
});