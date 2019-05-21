
var data = $("input[name='quantity']");

$('#add').click(function () {
	
	if (data.val() < 100) {

		data.val(+data.val() + 1);
	}
});
$('#sub').click(function () {
	if (data.val() > 1) {
		if (data.val() > 1) data.val(+data.val() - 1);
	}
});



$(function() {
	$("#datepickerdelivery").datepicker({
		minDate: 0,
		dayNamesMin: ["S", "M", "T", "W", "T", "F", "S"],
		todayHighlight: !1,
		onSelect: function(e, i) {
			$("#calendarValuedelivery").val(e)
		}
	})

})

function myFunction(e) {
	$("#timerValuedelivery").val(e.target.value)
}

function myFunctionpickup(e) {
	$("#timerValuepickup").val(e.target.value)
}



$(function() {
	$("#datepickerpickup").datepicker({
		minDate: 0,
		dayNamesMin: ["S", "M", "T", "W", "T", "F", "S"],
		todayHighlight: !1,
		onSelect: function(e, i) {
			$("#calendarValuepickup").val(e)
		}
	})

})