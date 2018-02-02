$('document').ready(function(){
	$(".droppable").droppable({
		drop: function( evento, ui ) {
			if (!$(this).hasClass('ocupado')) {
				$(this).addClass('ocupado');
				$(evento.toElement).clone().appendTo(this);
				$(this).children().removeAttr('style');
				$(evento.toElement).remove();
			}
			recolor();
		},
		over: function( evento, ui ) {
			$(this).css({'background-color':'#FFF337','border':'dashed 2px black'});
		},
		out: function( evento, ui ) {
			$(this).removeAttr('style');
		}
	});
	$('.droppable').sortable();
	refresh();
	$.each($('div.sch_hour'), function( key, value ) {
		colorear_sch(value);
	});
	$('body').on('change','.periodo>select',function() {
		var s = $(this).parent().attr('pos');
		var x = $(this).parent().parent().attr('x');
		var y = $(this).parent().parent().parent().attr('y');
		y = y-s+1;
		$("div[x='"+x+"'][y='"+y+"']").attr('size',$(this).val());
		recolor();
	});
});
function colorear(element){
	$(element).removeAttr('style');
	var select = $(element).children('select');
	var size = $(element).attr('size');
	var color = $(element).attr('color');
	var texto = $(element).attr('texto');
	var carrera = $(element).attr('carrera');
	var asignatura = $(element).attr('asignatura');
	var fecha = $(element).attr('fecha');
	var group_id = $(element).attr('group_id');
	var career_id = $(element).attr('career_id');
	var subject_id = $(element).attr('subject_id');
	var x = $(element).parent().attr('x');
	var y = $(element).parent().parent().attr('y');
	var a = $(element).parent().attr('a');
	var p = $(element).parent().attr('p');
	var h1 = $(element).parent().parent().attr('h1');
	var dia = $(element).parent().parent().parent().parent().parent().attr('id');
	var sum = parseInt(size)+parseInt(y);
	$(element).attr('x',x);
	$(element).attr('y',y);
	var cont = 1;
	for (var i = y; i < sum; i++) {
		var td = $('div#'+dia+' tr[y='+i+']'+'>td[x='+x+']');
		$(td).addClass('ocupado');
		$(td).css({'background-color':color,'border-top':'1px solid '+color,'color':texto});
		$(td).empty();
		if (cont == 1) {
			$('div#'+dia+' tr[y='+i+']'+'>td[x='+x+'] div').html(carrera);
			$(element).clone().appendTo(td);
			$(select).clone().appendTo(element);
			$(td).css({'border-top':'3px solid black'});
		}
		if (cont == 2) {
			var date = fecha;
			date = date.substring(0,10).split('-');
			date = date[1] + '-' + date[2] + '-' + date[0];
			$(td).html($.datepicker.formatDate('dd M yy', new Date(date)));
		}
		if (cont == 3) {
			$(td).html('<b>'+carrera+'</b>');
		}
		if (i == sum-1) {
			var h2 = $(td).parent().attr('h2');
			$(select).clone().appendTo(td);
			$(td).children('select').removeAttr('disabled');
			$(td).children('select').removeAttr('hidden');
			$(td).css({'border-bottom':'3px solid black'});
			$(td).css({'border-top':'1px solid black'});
			var options = '';
			for (var k = 1; k <= 8; k++) {
				if (size==k) {
					options = options+"<option selected value='"+k+"'>"+k+"</option>"
				} else {
					options = options+"<option value='"+k+"'>"+k+"</option>"
				}
			}
			$(td).append(
				"<input type='hidden' name='aula[]' value='"+a+"' >"
				+"<input type='hidden' name='piso[]' value='"+p+"' >"
				+"<input type='hidden' name='hora_inicio[]' value='"+h1+"' >"
				+"<input type='hidden' name='hora_fin[]' value='"+h2+"' >"
				+"<input type='hidden' name='dia[]' value='"+dia+"' >"
				+"<input type='hidden' name='group_id[]' value='"+group_id+"' >"
				+"<input type='hidden' name='career_id[]' value='"+career_id+"' >"
				+"<input type='hidden' name='subject_id[]' value='"+subject_id+"' >"
				+"<div class='periodo' pos='"+size+"'><select style='background-color:"+color+";' name='periodos[]'>"+options+"</select></div>"
				);
		}
		cont++;
	}
}

function limpiar() {
	$('div.active td').removeAttr('style');
	$('div.active td>select').remove();
	$('div.active td>b').remove();
	$('div.active td input').remove();
	$('div.active .ocupado').removeClass('ocupado');
}
function recolor(){
	limpiar();
	$.each( $('div.tab-pane.active div.hour'), function( key, value ) {
		colorear($(value));
	});
	$.each( $('div.hour'), function( key, value ) {
		var color = $(value).attr('color');
		var texto = $(value).attr('texto');
		$(value).css({'background-color':color,'color':texto});
	});
}
function refresh(){
	limpiar();
	$.each( $('div.tab-pane'), function( key, panel ) {
		$.each( $(panel).children().children().children().children().children('div.hour'), function( key, value ) {
			colorear($(value));
		});
	});
	$.each( $('div.hour'), function( key, value ) {
		var color = $(value).attr('color');
		var texto = $(value).attr('texto');
		$(value).css({'background-color':color,'color':texto});
	});
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