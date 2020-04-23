function passwordStrength(password)
{
	var desc = new Array();
	desc[0] = "Muito Fraca";
	desc[1] = "Fraca";
	desc[2] = "Média";
	desc[3] = "Boa";
	desc[4] = "Forte";
	desc[5] = "Muito Forte";

	var score   = 0;
	//if password bigger than 6 give 1 point
	if (password.length > 6) score++;

	//if password has both lower and uppercase characters give 1 point	
	if ( ( password.match(/[a-z]/) ) && ( password.match(/[A-Z]/) ) ) score++;

	//if password has at least one number give 1 point
	if (password.match(/\d+/)) score++;

	//if password has at least one special caracther give 1 point
	if ( password.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/) )	score++;

	//if password bigger than 12 give another 1 point
	if (password.length > 12) score++;

	$(".passwordForce > div").attr('class', "strength_" + score).html(desc[score]);
}

$(document).ready(function() {
	$("#form-register").on('click', "button[type='submit']", function(event) {
		
		if($("#form-register")[0].checkValidity() === false) {
			return true;
		}

		event.preventDefault();

		var submit = $("#form-register button[type='submit']");
		var submit_text = submit.html();
		var email = $("#input-email").val();

		submit.html('<i class="fa fa-fw fa-cog fa-spin"></i>').attr('disabled', '');

		$.post(base_url+'/register/emailVerify', {email: email}, function(data, textStatus, xhr) {
			/* nothing */
		}).done(function(data){
			if(data == "email_registered"){
				$("#register-return").html('<div class="row"><div class="medium-12 columns"><div class="alert alert-warning alert-center alert-small">Esse e-mail já está cadastrado.<br>Tente novamente com outro e-mail ou <a href="#" data-modal="'+base_url+'/login" class="modal-open">acesse sua conta clicando aqui</a>.</div></div></div>');

				setTimeout(function() {
					$("#register-return").html('');
				}, 5000);		

				return false;		
			}

			if(data == "email_free"){
				$("#form-register").submit();
			}
		}).error(function() {
			return false;
		}).always(function() {
			submit.html(submit_text).removeAttr('disabled', '');

			console.clear();
		});
	});
});