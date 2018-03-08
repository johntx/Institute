$('#ingresos').on('submit',function(e){
	$.ajaxSetup({
		header:$('meta[name="_token"]').attr('content')
	});
	e.preventDefault(e);
	$('#ingresos input[type=submit]').attr("disabled", true);
	$.ajax({
		type:"POST",
		url:window.location.origin+'/cien/public/admin/income',
		data:$(this).serialize(),
		dataType: 'json',
		success: function(income){
			window.open(window.location.origin+'/cien/public/admin/income/pdf/'+income);
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

$('body').on('keyup','input.quant',function () {
	let max= parseInt(this.max);
	let min= parseInt(this.min);
	let valor = parseInt(this.value);
	if(valor>max){ this.value = max; }
	if(valor<min){ this.value = min; }
});
$('#pedido').on('submit',function(e){
	$.ajaxSetup({
		header:$('meta[name="_token"]').attr('content')
	});
	e.preventDefault(e);
	$('#pedido input[type=submit]').attr("disabled", true);
	$.ajax({
		type:"POST",
		url:window.location.origin+'/cien/public/admin/order',
		data:$(this).serialize(),
		dataType: 'json',
		success: function(order){
			window.open(window.location.origin+'/cien/public/admin/order/pdf/'+order);
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
$('body').on('change','select.sel_itm',function () {
	var tbody = $(this).parent().parent().parent().parent();
	var id = $(this).children('option:selected').attr('code');
	if (!same(this)) {
		$(tbody).attr('id',id);
		$('#'+id+' .price').html($(this).children('option:selected').attr('price'));
		$('#'+id+' .quant').attr('max',$(this).children('option:selected').attr('stock'));
		$('#'+id+' .remove>button').addClass('remove_btn');
		$('#'+id+' .remove>button').removeAttr('disabled');
		$('#'+id+' .quantity>input').removeAttr('disabled');
		$('#'+id+' .quantity>input').attr('tbody',id);
		$('#'+id+' .quantity>input').focus();
		change_subtotal(id);
	}
});
$('body').on('change','select.last_sel',function () {
	$('.last_sel').removeClass('last_sel');
	$('select.last_sel').removeClass('last_sel');
	var clon = $('#new_item').clone();
	$(clon).removeAttr('id');
	$('.last_body').removeClass('last_body');
	$(clon).addClass('last_body');
	$(clon).removeAttr('style');
	$(clon).insertBefore('.total_body');
	$('.last_body select').addClass('last_sel');
	$('.last_body select').addClass('selectpicker');
	$('.last_body select').selectpicker('refresh');

});
function same(select) {
	var id = $(select).children('option:selected').attr('code');
	var element =  document.getElementById(id);
	if (typeof(element) != 'undefined' && element != null){
		$(select).prev().children('div').children('input').val('');
		$(select).val('default');
		$(select).selectpicker('refresh');
		$(select).selectpicker('reset');
		$(select).blur();
		$('#alert_same').show();
		setTimeout(function() {
			$(".alert").fadeOut(1000);
		},5000);
		return true;
	} else {
		return false;
	}
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
$('body').on('click','.comprador',function () {
	$('#comprador').val($(this).children('div').html());
	$('#people_id').val($(this).attr('people_id'));
	$('#lista_compradores').addClass('hide');
});
$('body').on('keyup','.quant',function () {
	var id = $(this).attr('tbody');
	change_subtotal(id);

	total_global();
});
$('body').on('change','.quant',function () {
	var id = $(this).attr('tbody');
	change_subtotal(id);

	total_global();
});
$('body').on('keyup','#global_discount',function () {
	total_global();
});
$('body').on('change','#global_discount',function () {
	total_global();
});
$('body').on('click','.remove_btn',function () {
	$(this).parent().parent().parent().remove();
	change_total();
	total_global();
});
function total_global() {
	var discount = $('#global_discount').val();
	var total = parseFloat($('#total').html())-discount;
	if (discount!=0) {
		$('#total_global').html(total.toFixed(2));
		$('#showtot').removeAttr('style');
		$('#total').css({'text-decoration':'line-through'});
	} else {
		$('#total_global').html('');
		$('#total').removeAttr('style');
		$('#showtot').css({'display':'none'});
	}
}
function change_subtotal(id) {
	var price = $('#'+id+' .price').html();
	var quant = $('#'+id+' .quant').val();
	if (!isNaN(quant)) {
		var sub = parseFloat(quant)*parseFloat(price);
		$('#'+id+' .subtotal').html(sub);
	}
	change_total();

	total_global();
}
function change_total() {
	var total= parseFloat(0);
	$('.subtotal').each(function() {
		if (!isNaN($(this).html()) && $(this).html()!= '') {
			var v = parseFloat($(this).html());
			total = total + v;
		}
	});
	$('#total').html(total.toFixed(2));

	total_global();
}