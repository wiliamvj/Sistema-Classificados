$(document).ready(function() {
	$("#password-form").on('click', 'button[type="submit"]', function(event) {

		if($("#password-form")[0].checkValidity() === false) {
			return true;
		}

		event.preventDefault();

		var new_pass = $("#input-new-pass").val();
		var repeat_pass = $("#input-repeat-pass").val();

		if(new_pass != repeat_pass){
			$("#password-return").html('<div class="row"><div class="medium-12 columns"><div class="alert alert-warning alert-center alert-small">As senhas não coicidem.<br>Tente novamente.</div></div></div>');

			return false;
		}else{
			$("#password-form").submit();
		}
	});
});