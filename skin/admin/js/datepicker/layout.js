(function($){
	var initLayout = function() {
		$('.inputDate').DatePicker({
			format:'m/d/Y',
			date: $('#inputDate').val(),
			current: $('#inputDate').val(),
			starts: 1,
			position: 'right',
			onBeforeShow: function(){
				$('#inputDate').DatePickerSetDate($('#inputDate').val(), true);
			},
			onChange: function(formated, dates){
				$('#inputDate').val(formated);
				$('#inputDate').DatePickerHide();
			}
		});
		
	};
	EYE.register(initLayout, 'init');
})(jQuery)