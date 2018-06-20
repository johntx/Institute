$('document').ready(function(){
	$('li.cont_drop>div>div.cabeza').draggable({
		stop: function() {
			$(this).addClass('uso');
		},
		helper: "clone",
		appendTo: 'body' });
	$(".droppable").droppable({
		drop: function( e, ui ) {
			if($(this).attr('id')=='trash'){
				var contenedor = $(e.toElement).parent();
				var dia = $(e.toElement).parent().parent().attr('dia');
				eliminar_cont_alterior($(e.toElement),contenedor,dia);
				$(e.toElement).remove();
			}
			if (!$(this).children().hasClass('cuerpo')/* && !choca($(e.toElement),$(this))*/) {
				var contenedor = $(e.toElement).parent();
				var dia = $(this).parent().attr('dia');
				eliminar_cont_alterior($(e.toElement),contenedor,dia);
				crear_contenido($(e.toElement),$(this));
			}
			$(this).removeAttr('style');
		},
		over: function( evento, ui ) {
			$(this).css({'background-color':'#FFF337','border':'dashed 2px black'});
		},
		out: function( evento, ui ) {
			$(this).removeAttr('style');
		}
	});
	$('.droppable').sortable();
	$.each($('div.sch_hour'), function( key, value ) {
		colorear_sch(value);
	});
	$('div.cabeza').parent('div').parent('td').addClass('cabeza');
	$('div.cubo').parent('div').parent('td').addClass('cubo');
	$('div.pie').parent('div').parent('td').addClass('pie');
	$.each($('div.cubo'), function() {
		$(this).parent('div').parent('td').attr('career',$(this).attr('career'));
	});
	$('body').on('change','select.periodo',function() {
		var uni = $(this).parent().attr('uni');
		var p_last = parseInt($(this).parent().attr('p'));
		var p = parseInt($(this).val());
		var x = $(this).parent().parent().parent().attr('x');
		var h = parseInt($(this).parent().parent().parent().attr('h'));
		var dia = $(this).parent().parent().parent().attr('dia');
		var i = h-p_last+1;
		var element = $("#"+dia+" td[h='"+i+"'][x='"+x+"']>div>div[uni='"+uni+"']");
		var contenedor = element.parent();
		eliminar_cont_alterior(element,contenedor,dia);
		element.attr('p',p);
		crear_contenido(element,contenedor);
	});
	$('body').on('change','select.people',function() {
		var uni = $(this).parent().attr('uni');
		var p_last = parseInt($(this).parent().attr('p'));
		var x = $(this).parent().parent().parent().attr('x');
		var h = parseInt($(this).parent().parent().parent().attr('h'));
		var dia = $(this).parent().parent().parent().attr('dia');
		var i = h-p_last+1;
		var element = $("#"+dia+" td[h='"+i+"'][x='"+x+"']>div>div[uni='"+uni+"']");
		var v = $(this).val();
		element.attr('people_id',v);
		$(this).children('option[selected="selected"]').removeAttr('selected');
		$(this).children("option[value='"+v+"']").attr('selected','selected');
		var select = this.outerHTML;
		element.attr('people',select);
		/*cambios en el input*/
		var strg = $(this).siblings('input.datos').val();
		var cadena = strg.split("-");
		var n_strg=v;
		for (var j = 1; j < cadena.length; j++) {
			n_strg = n_strg+"-"+cadena[j];
		}
		$(this).siblings('input.datos').attr('value',n_strg);
	});
	$("li>div>div.cabeza").hover(function() {
		var group_id = $(this).attr('group_id');
		var subject_id = $(this).attr('subject_id');
		$.each($(".panel-body div.cabeza[group_id='"+group_id+"'][subject_id='"+subject_id+"']"), function() {
			$(this).addClass('ligther');
			var dia = $(this).parent().parent().attr('dia');
			var uni = $(this).attr('uni');
			$("a[href='#"+dia+"']").addClass('ligther');
			$("a[href='#"+dia+"']").parent().addClass('ligther');
		});
	},function () {
		$.each($(".ligther"), function() {
			$(this).removeClass('ligther');
		});
	});
});

function choca(element,contenedor) {
	var p = parseInt(element.attr('p'));
	var x = contenedor.parent().attr('x');
	var h = parseInt(contenedor.parent().attr('h'));
	var dia = contenedor.parent().attr('dia');
	if (contenedor.children().hasClass('cabeza')) { return false; }
	for (var i = h+1; i < h+p; i++) {
		var td = $("#"+dia+" td[h='"+i+"'][x='"+x+"']");
		if (td.children('div').children().length>0) {
			return true;
		}
	}
	return false;
}
function crear_contenido(elemento,n_contenedor){
	var contenedor = elemento.parent();
	var p = parseInt(elemento.attr('p'));
	var career = elemento.attr('career');
	var fecha = elemento.attr('fecha');
	var materia = elemento.attr('materia');
	var subject_id = elemento.attr('subject_id');
	var turno = elemento.attr('turno');
	var inscritos = elemento.attr('inscritos');
	var people = elemento.attr('people');
	var uni = elemento.attr('uni');
	var dia = n_contenedor.parent().attr('dia');
	var x = n_contenedor.parent().attr('x');
	var aula = n_contenedor.parent().attr('aula');
	var piso = n_contenedor.parent().attr('piso');
	var hora = n_contenedor.parent().attr('hora');
	var h = parseInt(n_contenedor.parent().attr('h'));
	var pos_hora2 = h+p;
	var hora_2 = $("#"+dia+" td[h='"+pos_hora2+"'][x='"+x+"']").attr('hora');
	var datos = elemento.attr('people_id')+"-"+aula+"-"+piso+"-"+hora+"-"+hora_2+"-"+dia+"-"+elemento.attr('group_id')+"-"+subject_id+"-"+h+"-"+p;
	elemento.text(career);

	for (var i = h; i < h+p; i++) {
		var n_cont = $("#"+dia+" td[h='"+i+"'][x='"+x+"']>div");
		n_cont.parent('td').attr('career',career);
		if (i==h) {
			elemento.clone().appendTo(n_cont);
			elemento.remove();
			n_cont.parent('td').attr('class','cabeza cubo');
		} else if (i==h+1 && i<h+p-1) {
			n_cont.append("<div uni='"+uni+"' career='"+career+"' class='cuerpo cubo cont_turno'>"+fecha+"<div class='turno'>"+turno+"</div><div class='inscritos'>"+inscritos+"</div></div>");
			n_cont.parent('td').attr('class','cuerpo cubo cont_turno');
		} else if (i==h+2 && i<h+p-1) {
			n_cont.append("<div uni='"+uni+"' career='"+career+"' class='cuerpo cubo'>"+materia+"</div>");
			n_cont.parent('td').attr('class','cuerpo cubo');
		} else if (i==h+p-1) {
			var options = '';
			for (var k = 2; k <= 8; k++) {
				if (p==k) { options = options+"<option selected value='"+k+"'>"+k+"</option>"; } else { options = options+"<option value='"+k+"'>"+k+"</option>"; }
			}
			n_cont.append("<div uni='"+uni+"' career='"+career+"' class='cuerpo cubo pie cont_periodo' p='"+p+"'>"+people+"<select class='periodo'>"+options+"</select><input type='text' class='datos' name='datos[]' value='"+datos+"'></div>");
			n_cont.parent('td').attr('class','cuerpo cubo pie');
		} else {
			n_cont.append("<div uni='"+uni+"' career='"+career+"' class='cuerpo cubo'>&emsp;</div>");
			n_cont.parent('td').attr('class','cuerpo cubo');

		}
		n_cont.parent('td').attr('career',career);
	}
	n_contenedor.children().removeAttr('style');
}
function eliminar_cont_alterior(elemento,contenedor,dia){
	var x = contenedor.parent().attr('x');
	var h = parseInt(contenedor.parent().attr('h'));
	var uni = elemento.attr('uni');
	var p = parseInt(elemento.attr('p'));
	for (var i = h+1; i < h+p; i++) {
		var td = $("#"+dia+" td[h='"+i+"'][x='"+x+"']");
		var element = $("td[h='"+i+"'][x='"+x+"']>div>div[uni='"+uni+"']");
		element.remove();
		if (td.children().children().length<1) {
			td.removeAttr('class');
			td.removeAttr('career');
		}
	}
	if (contenedor.children().length<3) {
		contenedor.parent('td').removeAttr('class');
		contenedor.parent('td').removeAttr('career');
	}
}
function colorear_sch(element) {
	var hora = $(element).attr('hora');
	var size = $(element).attr('size');
	var carrera = $(element).attr('carrera');
	var fecha = $(element).attr('fecha');
	var asignatura = $(element).attr('asignatura');
	var aula = $(element).attr('aula');
	var h = $(element).parent().parent().attr('h');
	var x = $(element).parent().attr('x');
	var sum = parseInt(size)+parseInt(h);
	var cont = 1;
	for (var i = h; i < sum; i++) {
		var td = $('tr[h='+i+']'+'>td[x='+x+']');
		td.css({'border-left':'3px solid black','border-right':'3px solid black'});
		if (cont == 1) {
			$('tr[h='+i+']'+'>td[x='+x+'] div').html(carrera);
			$(td).css({'border-top':'3px solid black'});
		}
		if (cont == 2) {
			$(td).html(fecha);
		}
		if (cont == 3) {
			$(td).html('<span style="padding:10px;">'+asignatura+'</span>');
		}
		if (i == sum-1) {
			$(td).html(aula);
			$(td).css({'border-bottom':'3px solid black'});
		}
		cont++;
	}
}