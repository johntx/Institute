$('document').ready(function(){
	$(".droppable").droppable({
		drop: function( evento, ui ) {
			if (!$(this).hasClass('ocupado')) {
				$(this).empty();
				$(this).addClass('ocupado');
				$(evento.toElement).clone().appendTo(this);
				$(this).children().removeAttr('style');
				$(evento.toElement).remove();
			} else if($(this).hasClass('header')) {
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
		console.log('cambio');
		var s = $(this).parent().attr('pos');
		var x = $(this).parent().parent().parent().attr('x');
		var y = $(this).parent().parent().parent().parent().attr('y');
		var deleter = $(this).parent().parent();
		y = y-s+1;
		var div = $("div[x='"+x+"'][y='"+y+"']");
		div.attr('size',$(this).val());
		deleter.remove();
		recolor();
	});
	$('body').on('change','select.teacher_select',function() {
		var s = $(this).parent().children('div.periodo').children('select').children('option:selected').attr('value');
		var x = $(this).parent().parent().attr('x');
		var y = $(this).parent().parent().parent().attr('y');
		y = y-s+1;
		var div = $("div[x='"+x+"'][y='"+y+"']");
		var value = $(this).children('option:selected').attr('value');
		div.children('select').children('option[selected="selected"]').removeAttr('selected');
		div.children('select').children('option[value="'+value+'"]').attr('selected','selected');
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
		var td = $('div#'+dia+' tr[y='+i+']'+'>td[x='+x+']');		//$(td).empty();
		if (cont == 1) {
			$(td).addClass('header');
			//$('div#'+dia+' tr[y='+i+']'+'>td[x='+x+'] div').html(carrera);
			//$(element).clone().appendTo(td);
			//$(select).clone().appendTo(element);
			$(td).css({'border-top':'3px solid black'});
			/*$(element).css({'border':'1px solid '+color});
			$(td).children('div').css({'border':'1px solid '+color});*/
		}
		if (cont == 2) {
			var date = fecha;
			date = date.substring(0,10).split('-');
			date = date[1] + '-' + date[2] + '-' + date[0];
			if ($(td).hasClass('ocupado')) {
				$(td).children('div').append("<div style='background-color:"+color+";'>"+$.datepicker.formatDate('dd M yy', new Date(date))+"</div>");
			} else {
				$(td).empty();
				$(td).html("<div><div style='background-color:"+color+";'>"+$.datepicker.formatDate('dd M yy', new Date(date))+"</div></div>");
			}
			$(td).css({'border-top':'1px solid '+color});
		}
		if (cont == 3) {
			if ($(td).hasClass('ocupado')) {
				$(td).children('div').append("<div style='padding:5px; background-color:"+color+";'><b>"+carrera+'</b></div>');
			} else {
				$(td).empty();
				$(td).html("<div><div style='padding:5px; background-color:"+color+";'><b>"+carrera+'</b></div></div>');
			}
			$(td).css({'border-top':'1px solid '+color});
		}
		if (i == sum-1) {
			if ($(td).hasClass('ocupado')) {
				var h2 = $(td).parent().attr('h2');
				$(select).clone().appendTo(td.children('div'));
				$(td).children('div').children('select').removeAttr('disabled');
				$(td).children('div').children('select').removeAttr('hidden');
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
				$(td).children('div').append(
					"<input type='hidden' name='datos[]' value='"+a+"-"+p+"-"+h1+"-"+h2+"-"+dia+"-"+group_id+"-"+subject_id+"' >"
					+"<div class='periodo' pos='"+size+"'><select style='background-color:"+color+";' name='periodos[]'>"+options+"</select></div>"
					);
			} else {
				$(td).empty();
				$(td).append("<div></div>");
				var h2 = $(td).parent().attr('h2');
				$(select).clone().appendTo(td.children('div'));
				$(td).children('div').children('select').removeAttr('disabled');
				$(td).children('div').children('select').removeAttr('hidden');
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
				$(td).children('div').append(
					"<input type='hidden' name='datos[]' value='"+a+"-"+p+"-"+h1+"-"+h2+"-"+dia+"-"+group_id+"-"+subject_id+"' >"
					+"<div class='periodo' pos='"+size+"'><select style='background-color:"+color+";' name='periodos[]'>"+options+"</select></div>"
					);
			}
		}
		$(td).children('div').children('div').last().css({color,'color':texto});
		$(td).css({'background-color':color});
		cont++;
		$(td).addClass('ocupado');
	}
	$.each($('td.header.ocupado'), function( key, value ) {
		if ($(value).children('div').length==1) {
			$(value).children('div').addClass('solo');
		} else {
			$(value).children('div').removeClass('solo');
		}
	});
	
}

function limpiar() {
	$('div.active td').removeAttr('style');
	$('div.active td>select').remove();
	$('div.active td>div.periodo>select').remove();
	$('div.active td>b').remove();
	$('div.active td input').remove();
	$('div.active .ocupado').removeClass('ocupado');
	$('div.active .header').removeClass('header');
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
	$('div.active td.droppable:not(.ocupado)>div').remove();
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