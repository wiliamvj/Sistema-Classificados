$(document).ready(function() {
	$("#sc-state").change(function() {
		var state_code = $(this).val();

		$.getJSON(base_url+'/address/getbycep/'+state_code+'/regions', function(data) {

    		if(data.regions != null){
    			$("#sc-region").empty();
    			$('#sc-region').append('<option>Região da Cidade</option>');
        		$.each(data.regions, function (index, value) {
        			if(value.region_id == data.region_id) {
        				$('#sc-region').append('<option value="'+value.region_id+'" selected="selected">'+value.name+'</option>');
        			}else {
        				$('#sc-region').append('<option value="'+value.region_id+'">'+value.name+'</option>');
        			}
        		});
    		}	
		});
		
	});

	$("#sc-region").change(function() {
		var state_code = $(this).val();

		$.getJSON(base_url+'/address/getbycep/'+state_code+'/city', function(data) {

    		if(data.cities != null){
    			$("#sc-city").empty();
    			$('#sc-city').append('<option>Selecione um município</option>');
        		$.each(data.cities, function (index, value) {
        			if(value.city_id == data.city_id) {
        				$('#sc-city').append('<option value="'+value.city_id+'" selected="selected">'+value.name+'</option>');
        			}else {
        				$('#sc-city').append('<option value="'+value.city_id+'">'+value.name+'</option>');
        			}
        		});
    		}	
		});
		
	});

	$("#sc-cep").keyup(function() {
	  	var cep_code = $(this).val();
        if( cep_code.length == 9 ) {
        	$.getJSON(base_url+'/address/getbycep/'+cep_code, function(data) {
        		;

        		if(data.states != null){
        			$("#sc-state").empty()
        			$('#sc-state').append('<option>Selecione seu Estado</option>');
	        		$.each(data.states, function (index, value) {
	        			if(value.state_id == data.state_id) {
	        				$('#sc-state').append('<option value="'+value.state_id+'" selected="selected">'+value.name+'</option>');
	        			}else {
	        				$('#sc-state').append('<option value="'+value.state_id+'">'+value.name+'</option>');
	        			}
	        		});
        		}

        		if(data.cities != null){
	    			$("#sc-city").empty();
	    			$('#sc-city').append('<option>Selecione um município</option>');
	        		$.each(data.cities, function (index, value) {
	        			if(value.city_id == data.city_id) {
	        				$('#sc-city').append('<option value="'+value.city_id+'" selected="selected">'+value.name+'</option>');
	        			}else {
	        				$('#sc-city').append('<option value="'+value.city_id+'">'+value.name+'</option>');
	        			}
        			});
    			}	

        		if(data.regions != null){
        			$("#sc-region").empty();
        			$('#sc-region').append('<option>Região da Cidade</option>');
	        		$.each(data.regions, function (index, value) {
	        			if(value.region_id == data.region_id) {
	        				$('#sc-region').append('<option value="'+value.region_id+'" selected="selected">'+value.name+'</option>');
	        			}else {
	        				$('#sc-region').append('<option value="'+value.region_id+'">'+value.name+'</option>');
	        			}
	        		});
        		}


        		if(data.neighborhoods != null){
	        		$.each(data.neighborhoods, function (index, value) {
	        			if(value.neighborhood_id == data.neighborhood_id) {
	        				$('#sc-neighborhood').val(value.name);
	        			}
	        		});
        		}

        		if(data.addressText != null) {
					$("#sc-address").val(data.addressText);	
        		}
        		
			});
        }
	});

	/* tabs - begin */
	$(".profile-shop").on('click', '.ps-tabs > div', function(event) {
		var tab = $(this).attr('data-tab');
		
		$(".ps-tabs > div").removeClass('active');
		$(this).addClass('active');

		$(".ps-content > div").removeClass('active');
		$(".ps-content > div[data-tab='"+tab+"']").addClass('active');
	});
	/* tabs - end */

	/* images upload - begin */
	$("#sc-f-images-input").on('change', function(event) {
		var obj = $(this)[0];
		var files = obj.files;
		var files_qty = files.length;
		var box = $('#sc-f-images-box');

		/* config */
		var max_size = 1048576 * 2; //1048576 * 2
		var max_width = 400;
		var max_height = 400;
		 
		var file = files[0];
		var file_name = file.name;

		console.log(file);

		if(file.size >= max_size){
			alert("A imagem selecionada está acima do tamanho máximo.");

			return false;
		}

		var img = new Image;
		img.src = URL.createObjectURL(file);

		img.onload = function() {
			/* img data */
			var picWidth = this.width;
 			var picHeight = this.height;
 			var wdthHghtRatio = picHeight/picWidth;

 			/* width/height validation */
 			if(picWidth > max_width || picWidth > max_height){
 				alert("A largura e/ou a altura da imagem selecionada está acima do permitido.");

				return false;
 			}

 			/* adjust height */
			if (Number(picWidth) > 200) {
				var newHeight = Math.round(Number(200) * wdthHghtRatio);
			} else {
				return false;
			};

			box.html('');

 			var cnvs_html = '<canvas id="cnvs_'+0+'" width="200" height="200"></canvas>';

			box.prepend('<div class="item">'+cnvs_html+'</div>');

			var cnvs = document.getElementById("cnvs_"+0);
			var ctx = cnvs.getContext("2d");

			ctx.drawImage(img, 0, ((200/2)-(newHeight/2)), 200, newHeight);
		};
	});
	/* images upload - end */

	/* user info - begin */
	$("#sc-user-info").on('change', function(event) {
		var obj = $(this);

		event.preventDefault();

		if(obj.is(':checked')) {
			$("#sc-phone, #sc-address, #sc-neighborhood, #sc-region, #sc-cep, #sc-address-add, #sc-city, #sc-state").attr('disabled', 'disabled');
		}else{
			$("#sc-phone, #sc-address, #sc-neighborhood, #sc-region, #sc-cep, #sc-address-add, #sc-city, #sc-state").removeAttr('disabled');
		}		
	});
	/* user info - end */

	/* cities - begin */
	$("#sc-state").on('change', function(event) {
		var value = $(this).val();
		var citiesBox = $("#sc-city");

		event.preventDefault();

		citiesBox.attr('disabled', '').html('<option hidden value="">Carregando...</option>');

		$.post(base_url+'/main/cities', {state: value, type: 'options'}, function(data, textStatus, xhr) {
			/* nothing */
		}).done(function(data){
			citiesBox.removeAttr('disabled').html(data);
		}).error(function(){
			citiesBox.attr('disabled', '').html('<option hidden value="">Selecione sua cidade</option>');
		}).always(function(){
			console.clear();
		});
	});
	/* cities - end */

	/* form validation - begin */
	$("#sc-submit").on('click', function(event) {
		var submit = $("#sc-submit");
		var submit_text = submit.html();

		var code = $("#sc-code").val();
		var slug = $("#sc-slug").val();

		submit.html('<i class="fa fa-spin fa-cog"></i>Enviado...').attr('disabled', 'disabled');

		$.ajax({ url: base_url+'/shops/slug_verify', type: 'POST', data: { string: slug, code: code } }).done(function(data) {
			if(data == "slug_no"){
				$("#sc-form").submit();
			}else{
				submit.html(submit_text).removeAttr('disabled');

				alert("Essa URL já está sendo usada. Por favor, tente novamente outra URL para sua loja.");

				$("#sc-slug").focus();
			}		

			console.clear();
		}).fail(function() {
			console.log("slug verify: error");
		});		
	});
	/* form validation - end */
});