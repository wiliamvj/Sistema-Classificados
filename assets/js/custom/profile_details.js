$(document).ready(function() {

	$("#ai-city, #ai-state, #ai-region, #ai-neighborhood ").change(function() {
		$("#box-address").hide();
		$("#ai-address").val('');
	});

	$("#ai-state").change(function() {
		var str_code = $(this).val();
		$.getJSON(base_url+'/address/getbycep/'+str_code+'/regions', function(data) {

    		if(data.regions != null){
    			$("#ai-region").empty();
    			$('#ai-region').append('<option>Região da Cidade</option>');
        		$.each(data.regions, function (index, value) {
        			if(value.region_id == data.region_id) {
        				$('#ai-region').append('<option value="'+value.region_id+'" selected="selected">'+value.name+'</option>');
        			}else {
        				$('#ai-region').append('<option value="'+value.region_id+'">'+value.name+'</option>');
        			}
        		});
    		}	
		});
	});

	$("#ai-region").change(function() {
		var str_code = $(this).val();
		$.getJSON(base_url+'/address/getbycep/'+str_code+'/city', function(data) {

    		if(data.cities != null){
    			$("#ai-city").empty();
    			$('#ai-city').append('<option>Selecione um município</option>');
        		$.each(data.cities, function (index, value) {
        			if(value.city_id == data.city_id) {
        				$('#ai-city').append('<option value="'+value.city_id+'" selected="selected">'+value.name+'</option>');
        			}else {
        				$('#ai-city').append('<option value="'+value.city_id+'">'+value.name+'</option>');
        			}
        		});
    		}	
		});
	});

	$("#ai-city").change(function() {
		var str_code = $(this).val();
		$.getJSON(base_url+'/address/getbycep/'+str_code+'/neighborhood', function(data) {

    		if(data.neighborhood != null){
    			$("#ai-neighborhood").empty();
    			$('#ai-neighborhood').append('<option>Selecione um bairro</option>');
        		$.each(data.neighborhood, function (index, value) {
        			if(value.neighborhood_id == data.neighborhood_id) {
        				$('#ai-neighborhood').append('<option value="'+value.name+'" selected="selected">'+value.name+'</option>');
        			}else {
        				$('#ai-neighborhood').append('<option value="'+value.name+'">'+value.name+'</option>');
        			}
        		});
    		}	
		});
	});

	$("#ai-cep").keyup(function() {
	  	var cep_code = $(this).val();
        if( cep_code.length == 9 ) {
        	$.getJSON(base_url+'/address/getbycep/'+cep_code, function(data) {

        		if(data.states != null){
        			$("#ai-state").empty()
        			$('#ai-state').append('<option>Selecione seu Estado</option>');
	        		$.each(data.states, function (index, value) {
	        			if(value.state_id == data.state_id) {
	        				$('#ai-state').append('<option value="'+value.state_id+'" selected="selected">'+value.name+'</option>');
	        			}else {
	        				$('#ai-state').append('<option value="'+value.state_id+'">'+value.name+'</option>');
	        			}
	        		});
        		}

        		if(data.cities != null){
	    			$("#ai-city").empty();
	    			$('#ai-city').append('<option>Selecione um município</option>');
	        		$.each(data.cities, function (index, value) {
	        			if(value.city_id == data.city_id) {
	        				$('#ai-city').append('<option value="'+value.city_id+'" selected="selected">'+value.name+'</option>');
	        			}else {
	        				$('#ai-city').append('<option value="'+value.city_id+'">'+value.name+'</option>');
	        			}
        			});
    			}	

        		if(data.regions != null){
        			$("#ai-region").empty();
        			$('#ai-region').append('<option>Região da Cidade</option>');
	        		$.each(data.regions, function (index, value) {
	        			if(value.region_id == data.region_id) {
	        				$('#ai-region').append('<option value="'+value.region_id+'" selected="selected">'+value.name+'</option>');
	        			}else {
	        				$('#ai-region').append('<option value="'+value.region_id+'">'+value.name+'</option>');
	        			}
	        		});
        		}

        		if(data.neighborhoods != null){
        			$("#ai-neighborhood").empty();
        			$('#ai-neighborhood').append('<option>Selecione Bairro</option>');
	        		$.each(data.neighborhoods, function (index, value) {
	        			if(value.neighborhoods_id == data.neighborhoods_id) {
	        				$('#ai-neighborhood').append('<option value="'+value.name+'" selected="selected">'+value.name+'</option>');
	        			}else {
	        				$('#ai-neighborhood').append('<option value="'+value.name+'">'+value.name+'</option>');
	        			}
	        		});
        		}

        		if(data.addressText != null) {
					$("#box-address").show();
        			$("#label-address").html('<b>Endereço:</b><br>'+data.addressText);
        			$("#ai-address").val(data.addressText);	
        		}
        		
        		
			});
        }
	});

	/* password - begin */
	$("#pd-pass-check").on('change', function(event) {
		var obj = $(this);

		event.preventDefault();

		if(obj.is(':checked')) {
			$("#pd-password").removeAttr('disabled');
		}else{
			$("#pd-password").attr('disabled', 'disabled');
		}		
	});
	/* password - end */

	/* cities - begin */
	$("#pd-state").on('change', function(event) {
		var value = $(this).val();
		var citiesBox = $("#pd-city");

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
});