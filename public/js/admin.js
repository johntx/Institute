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

$(document).ready(function(){
		$('#career_select').change(function(){
			console.log($(this).val());
			$.get("{{ url('dropdown')}}",
			{ option: $(this).val() },
			function(data) {
				$('#group_id').empty();
				$.each(data, function(key, element) {
					$('#group_id').append("<option value='" + key + "'>" + element + "</option>");
				});
			});
		});
	});