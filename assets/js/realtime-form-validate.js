var validate = function() {

	$('#subject').on('input', function() {
		var input = $(this);
		var is_name = input.val();

		if(is_name){input.removeClass("has-warning").addClass("has-success");}
		else{input.removeClass("has-success").addClass("has-warning");}
	});
}

$(document).ready(validate);