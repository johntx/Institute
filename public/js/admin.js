$('document').ready(function(){
	setTimeout(function() {
		$(".alert").fadeOut(1000);
	},7000);
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
	$('.tablaSearch').DataTable({
		paging: false,
		searching: true
	});
	$('#boton_fecha_income').click(function() {
		var href = $('#boton_fecha_income').attr('href');
		var fecha = $('#selec_fecha_income').val();
		var string = href.split("fecha").join(fecha);  
		$("#boton_fecha_income").attr('href',string);
	});
	numerar_modulo();
});
$('body').on('click','.tbn_clonar_nombre',function () {
	var clon = $(this).siblings('div.clonar').clone();
	$(clon).removeAttr('style').removeClass('clonar');
	$(clon).children().children('input').removeAttr('disabled');
	$(clon).insertBefore($(this));
	numerar_modulo();
});
$('body').on('click','.tbn_clonar_modulo',function () {
	var clon = $(this).siblings('div.panel_clonar').clone();
	$(clon).removeAttr('style').removeClass('panel_clonar');
	$(clon).children(".principal").children().children('input').removeAttr('disabled');
	$(clon).insertBefore($(this));
	numerar_modulo();
});
$('body').on('click','.tbn_clonar_pregunta',function () {
	var clon = $(this).siblings('div.panel_clonar').clone();
	$(clon).removeAttr('style').removeClass('panel_clonar');
	$(clon).children('.panel-body').addClass('cuerpo_numerador');
	$(clon).children().children().children('input').removeAttr('disabled');
	$(clon).children().children('input').removeAttr('disabled');
	$(clon).insertBefore($(this));
	numerar_modulo();
});
$('body').on('click','.del_name',function () {
	$(this).parent().parent().remove();
	numerar_modulo();
});
$('body').on('click','.check_uniq',function () {
	/*$(this).siblings('input.check_uniq').prop('checked', false);*/
	if ($(this).prop('checked')){
		$(this).siblings('input.check_uniq').attr('disabled','disabled');
	} else {
		$(this).siblings('input.check_uniq').removeAttr('disabled');
	}
});
function numerar_modulo() {
	$.each($("div.modulo_padre"), function( key, modulo ) {
		$(modulo).children().children().children('span.n_modulo').html(key+1);
		$(modulo).children().children().children('input.input_modulo').val(key+1);
		$.each($(modulo).children().children().children('input.orden'), function( key, orden ) {
			$(orden).val(key+1);
		});
	});
}
$('body').on('keyup','#comprador',function () {
	if ($(this).val()!='' && $(this).val()!=' ' && $(this).val().length >1) {
		$.get("/cien/public/admin/search/"+$(this).val()+"",function(peoples,response){
			$("#lista_compradores>ul").empty();
			$('#lista_compradores').removeClass('hide');
			for (var i = 0 ; i < peoples.length; i++) {
				$('#lista_compradores>ul').append(
					"<li class='comprador' people_id='"
					+peoples[i].id
					+"'><div>"
					+peoples[i].fullname
					+"</div></li>"
					);
			}
		});
	} else {
		$("#lista_compradores>ul").empty();
	}
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
		$(this).closest('.dropdown').find('input.inp_sel_turno')
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
$('body').on('click','.extra_edit',function () {
	var id = $(this).attr('inscription');
	var total = parseInt($('#'+id+' #totl').val())-parseInt($('#'+id+' #abon').attr('abono'));
	var mesrestante = parseInt(total / $('#'+id+' #monto').val());
	var precio = $(this).attr('precio');
	if ($(this).prop('checked')){
		var suma = parseInt(precio)+parseInt($('#'+id+' #monto').val());
		$('#'+id+' #monto').val(suma);
		var asumar = mesrestante*$(this).attr('precio');
		var suma_total = parseInt(asumar)+parseInt($('#'+id+' #totl').val());
		$('#'+id+' #totl').val(suma_total);
	} else {
		var resta = parseInt($('#'+id+' #monto').val())-parseInt(precio);
		$('#'+id+' #monto').val(resta);
		var arestar = mesrestante*$(this).attr('precio');
		var resta_total = parseInt($('#'+id+' #totl').val())-parseInt(arestar);
		$('#'+id+' #totl').val(resta_total);
	}
	$('#'+id+' #totl').val();
});
function justNumbers(e){
	var key = e.which || e.keyCode; 
	patron = /\d/;
	te = String.fromCharCode(key); 
	return (patron.test(te) || key == 9 || key == 8 || key == 46 || key == 13);
}
$('#select_buscador').change(function () {
	$("#ver_search").attr('href',$("#ver_search").attr('enlace')+$(this).val());
	$("#edit_search").attr('href',$("#edit_search").attr('enlace')+$(this).val()+'/edit');
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
$('body').on('change','#fecha_tickeos',function () {
	fecha = $(this).val();

	href = $('#btn_obt_tick').attr('href');
	array_href = href.split('/');
	var n = array_href.length - 1;
	array_href[n]=fecha;
	var nuevo = array_href.join('/');
	href = $('#btn_obt_tick').attr('href',nuevo);

	href2 = $('#btn_log_tick').attr('href');
	array_href2 = href2.split('/');
	var n = array_href2.length - 1;
	array_href2[n]=fecha;
	var nuevo2 = array_href2.join('/');
	href2 = $('#btn_log_tick').attr('href',nuevo2);
});
$('body').on('change','#my_fecha_tickeos',function () {
	fecha = $(this).val();
	href2 = $('#my_btn_log_tick').attr('href');
	array_href2 = href2.split('/');
	var n = array_href2.length - 1;
	array_href2[n]=fecha;
	var nuevo2 = array_href2.join('/');
	href2 = $('#my_btn_log_tick').attr('href',nuevo2);
});
$('.check_asistencia').click(function() {
	var data = $(this).parent().parent().serialize();
	console.log(data);
	var url = $(this).parent().parent().attr("action");
	$.ajaxSetup({
		header:$('meta[name="_token"]').attr('content')
	});
	$.ajax({
		type:"POST",
		url:url,
		data:data,
		dataType: 'json',
		success: function(payment){
			console.log('guardado');
		},
		error: function(ret){
			console.log('error: '+data);
		}
	});
});
$('.observar').click(function(e){
	e.preventDefault();
	var link = $(this);
	$.get($(this).attr('href'),function(tickeo,response){
		if (tickeo=='observado') {
			link.parent().html('observado');
		}
	});
});
$('.check_mediano').click(function () {
	var monto = 0;
	var user = $(this).attr('user');
	$.each($("input[user='"+user+"']:checked"), function( key, input ) {
		monto = monto+parseInt($(input).attr('monto'));
	});
	$('span.'+user).html('Recibir: '+monto);
});
$('body').on('click','.new_nota',function () {
	var inscription_id = $(this).attr('inscription_id');
	var test_id = $(this).attr('test_id');
	var group_id = $(this).attr('group_id');
	var subject_id = $(this).attr('subject_id');
	$(".inscription_id").val(inscription_id);
	$(".test_id").val(test_id);
	$(".group_id").val(group_id);
	$(".subject_id").val(subject_id);
	$('.modal_nota').addClass('nota_visible');
	$('.background_modal').addClass('nota_visible');
	$('.nota').focus();
});
$('body').on('click','.edit_nota',function () {
	var inscription_id = $(this).attr('inscription_id');
	var test_id = $(this).attr('test_id');
	var score_id = $(this).attr('score_id');
	var nota = $(this).attr('nota');
	var group_id = $(this).attr('group_id');
	var subject_id = $(this).attr('subject_id');
	$(".inscription_id").val(inscription_id);
	$(".test_id").val(test_id);
	$(".group_id").val(group_id);
	$(".subject_id").val(subject_id);
	$(".nota").val(nota);
	$(".score_id").val(score_id);
	$('.modal_nota').addClass('nota_visible');
	$('.background_modal').addClass('nota_visible');
	$('.nota').select();
	$('.nota').focus();
});
$('body').on('click','.modal_nota_close',function () {
	cerrar_modales();
});
$('body').on('click','.background_modal',function () {
	cerrar_modales();
});
function cerrar_modales() {
	$('.nota').val(null);
	$(".inscription_id").val(null);
	$(".test_id").val(null);
	$(".test_id").val(null);
	$(".test_id").val(null);
	$(".score_id").val(null);
	$(".group_id").val(null);
	$(".subject_id").val(null);
	$('.nota_visible').removeClass('nota_visible');
}
$('body').on('click','#env_wha',function () {
	$.get("/cien/public/admin/interestedsend/"+$(this).attr('int')+"",function(respuesta,response){
	}).done(function() {
		location.reload();
	});
});
$('body').on('change','.check_piscina',function () {
	if($(this).prop('checked')) {
		var ins = $(this).attr('insc');
		$('.check_piscina[insc="'+ins+'"]').prop('checked', false);
		$(this).prop('checked', true);
	}
});