
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



// $(function() {
// 	$("#datepickerdelivery").datepicker({
// 		minDate: 0,
// 		dayNamesMin: ["S", "M", "T", "W", "T", "F", "S"],
// 		todayHighlight: !1,
// 		onSelect: function(e, i) {
// 			$("#calendarValuedelivery").val(e)
// 		}
// 	})

// })


function myFunction(e) {
	$("#timerValuedelivery").val(e.target.value)
}

function myFunctionpickup(e) {
	$("#timerValuepickup").val(e.target.value)
}



// $(function() {
// 	$("#datepickerpickup").datepicker({
// 		minDate: 0,
// 		dayNamesMin: ["S", "M", "T", "W", "T", "F", "S"],
// 		todayHighlight: !1,
// 		onSelect: function(e, i) {
// 			$("#calendarValuepickup").val(e)
// 		}
// 	})

// })


$( function() {
	$( "#slider-range" ).slider({
		range: true,
		min: 0,
		max: 1000,
		values: [ 75, 300 ],
		slide: function( event, ui ) {
			$( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );

			$("#price").val(ui.values[ 0 ] + "," + ui.values[ 1 ]);
			var $form = $(this).closest('form');
			$form.find('input[type=submit]').click();
			
		}
	});
	$( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) +
		" - $" + $( "#slider-range" ).slider( "values", 1 ) );

} );
