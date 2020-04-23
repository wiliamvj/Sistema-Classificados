$(document).ready(function() {
	$("#open-shop").on('click', function(event) {
		$("#first-step").hide();
		$("#second-step").show();
	});

$('#sc-slug').keyup(function(){
    var slug = $("#sc-slug").val();

		$.ajax({ url: 'https://www.panamerico.com.br/shops/slug_verify', type: 'POST', data: { string: slug, code: 0 } }).done(function(data) {
			if(data == "slug_yes"){
                                alert("Essa URL já está sendo usada. Por favor, tente novamente outra URL para sua loja.");
				$('#sc-bt').hide();
			}		
			console.clear();
		}).fail(function() {
			console.log("slug verify: error");
		});
});

});