<div class="row">
	<div class="col-md-12">
		<h1>Editar Usuário</h1>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<form action="<?=base_url('users/save')?>" enctype="multipart/form-data" method="POST" accept-charset="utf-8">
			<input type="hidden" name="e" value="<?=(($e) ? $item->use_id : '')?>">


			<div class="row">
				<div class="col-md-12">
					<h3>Informações Básicas</h3>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Nome</label>
						<input type="text" class="form-control" required name="name" value="<?=(($e) ? $item->use_name : '')?>">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Status</label>
						<select class="form-control" name="status">
							<option <?=(($e && $item->use_status == '1') ? 'selected' : '')?> value="1">Ativado</option>
							<option <?=(($e && $item->use_status == '0') ? 'selected' : '')?> value="0">Desativado</option>
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>E-mail</label>
						<input type="email" class="form-control" required name="email" value="<?=(($e) ? $item->use_email : '')?>">
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<h3>Informações de Contato</h3>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Telefone</label>
						<input type="text" class="form-control" name="phone" value="<?=(($e) ? $item->use_phone : '')?>">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Celular</label>
						<input type="text" class="form-control" name="celular" value="<?=(($e) ? $item->use_celular : '')?>">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>WhatsApp</label>
						<input type="text" class="form-control" name="whatsapp" value="<?=(($e) ? $item->use_whatsapp : '')?>">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>WebSite</label>
						<input type="text" class="form-control" name="website" value="<?=(($e) ? $item->use_website : '')?>">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Facebook</label>
						<div class="input-group">
							<span class="input-group-addon">facebook.com/</span>
							<input type="text" class="form-control" name="facebook" value="<?=(($e) ? $item->use_facebook : '')?>">
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Instagram</label>
						<div class="input-group">
							<span class="input-group-addon">instagram.com/</span>
							<input type="text" class="form-control" name="instagram" value="<?=(($e) ? $item->use_instagram : '')?>">
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Elo7</label>
						<div class="input-group">
							<span class="input-group-addon">elo7.com.br/</span>
							<input type="text" class="form-control" name="elo7" value="<?=(($e) ? $item->use_elo7 : '')?>">
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Mercado Livre</label>
						<input type="text" class="form-control" name="mercado_livre" value="<?=(($e) ? $item->use_mercado_livre : '')?>">
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label>CEP</label>
						<input type="text" class="form-control input-cep" id="uf-cep" name="cep" value="<?=(($e) ? $item->use_cep : '')?>">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 col-lg-4">
					<div class="form-group">
						<label>Estado</label>
						<select class="form-control" name="state" id="uf-state" required>
							<?php
								foreach ($states as $key => $sta) {
									echo '<option '.(($e && $item->use_state == $sta->sta_id) ? 'selected' : '').' value="'.$sta->sta_id.'">'.$sta->sta_name.'</option>';
								}
							?>
						</select>
					</div>
				</div>
				<div class="col-md-6 col-lg-4">
					<div class="form-group">
						<label>Região</label>
						<select class="form-control" name="region" id="uf-region" required>
							<?php if($region): ?>
			                <option value="<?= (($region) ? $region : '') ?>" selected="selected"><?= $region ?></option>
			            	<?php endif; ?>
						</select>
					</div>
				</div>
				<div class="col-md-6 col-lg-4">
					<div class="form-group">
						<label>Cidade</label>
						<select class="form-control" id="uf-city" name="city" required <?=(($e && $item->use_city) ? 'data-city="'.$item->use_city.'"' : '')?>></select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 col-lg-6">
					<div class="form-group">
						<label>Bairro</label>
						<select class="form-control" name="neighborhood" id="uf-neighborhood">
							<?php if($item->use_neighborhood): ?>
			                <option value="<?= (($item->use_neighborhood) ? $item->use_neighborhood : '') ?>" selected="selected"><?= $item->use_neighborhood ?></option>
			            	<?php endif; ?>
						</select>
					</div>
				</div>

				<div class="col-md-12 col-lg-6">
					<div class="form-group">
						<label>Endereço</label>
						<input type="text" class="form-control" id="uf-address" name="address" value="<?=(($e) ? $item->use_address : '')?>">
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<a href="<?=base_url('users')?>" class="btn btn-default btn-lg">Cancelar</a>
					<button type="submit" class="btn btn-primary btn-lg">Salvar</button>
				</div>
			</div>
		</form>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {

	$("#uf-state").change(function() {
		var state_code = $(this).val();

		$.getJSON(base_url+'/address/getbycep/'+state_code+'/regions', function(data) {

    		if(data.regions != null){
    			$("#uf-region").empty();
    			$('#uf-region').append('<option>Região da cidade</option>');
        		$.each(data.regions, function (index, value) {
        			if(value.region_id == data.region_id) {
        				$('#uf-region').append('<option value="'+value.region_id+'" selected="selected">'+value.name+'</option>');
        			}else {
        				$('#uf-region').append('<option value="'+value.region_id+'">'+value.name+'</option>');
        			}
        		});
    		}	
		});
		
	});

	$("#uf-region").change(function() {
		var state_code = $(this).val();

		$.getJSON(base_url+'/address/getbycep/'+state_code+'/city', function(data) {

    		if(data.cities != null){
    			$("#uf-city").empty();
    			$('#uf-city').append('<option>Selecione um município</option>');
        		$.each(data.cities, function (index, value) {
        			if(value.city_id == data.city_id) {
        				$('#uf-city').append('<option value="'+value.city_id+'" selected="selected">'+value.name+'</option>');
        			}else {
        				$('#uf-city').append('<option value="'+value.city_id+'">'+value.name+'</option>');
        			}
        		});
    		}	
		});
		
	});

	$("#uf-city").change(function() {
		var str_code = $(this).val();
		$.getJSON(base_url+'/address/getbycep/'+str_code+'/neighborhood', function(data) {

    		if(data.neighborhoods != null){
    			$("#uf-neighborhood").empty();
    			$('#uf-neighborhood').append('<option>Selecione um bairro</option>');
        		$.each(data.neighborhoods, function (index, value) {
        			if(value.neighborhoods_id == data.neighborhoods_id) {
        				$('#uf-neighborhood').append('<option value="'+value.name+'" selected="selected">'+value.name+'</option>');
        			}else {
        				$('#uf-neighborhood').append('<option value="'+value.name+'">'+value.name+'</option>');
        			}
        		});
    		}
		});
	});

	$("#uf-cep").keyup(function() {
	  	var cep_code = $(this).val();
        if( cep_code.length == 9 ) {
        	$.getJSON(base_url+'/address/getbycep/'+cep_code, function(data) {
        		;

        		if(data.states != null){
        			$("#uf-state").empty()
        			$('#uf-state').append('<option>Selecione seu estado</option>');
	        		$.each(data.states, function (index, value) {
	        			if(value.state_id == data.state_id) {
	        				$('#uf-state').append('<option value="'+value.state_id+'" selected="selected">'+value.name+'</option>');
	        			}else {
	        				$('#uf-state').append('<option value="'+value.state_id+'">'+value.name+'</option>');
	        			}
	        		});
        		}

        		if(data.cities != null){
	    			$("#uf-city").empty();
	    			$('#uf-city').append('<option>Selecione um município</option>');
	        		$.each(data.cities, function (index, value) {
	        			if(value.city_id == data.city_id) {
	        				$('#uf-city').append('<option value="'+value.city_id+'" selected="selected">'+value.name+'</option>');
	        			}else {
	        				$('#uf-city').append('<option value="'+value.city_id+'">'+value.name+'</option>');
	        			}
        			});
    			}	

    			if(data.neighborhoods != null){
	    			$("#uf-neighborhood").empty();
	    			$('#uf-neighborhood').append('<option>Selecione um bairro</option>');
	        		$.each(data.neighborhoods, function (index, value) {
	        			if(value.neighborhoods_id == data.neighborhoods_id) {
	        				$('#uf-neighborhood').append('<option value="'+value.name+'" selected="selected">'+value.name+'</option>');
	        			}else {
	        				$('#uf-neighborhood').append('<option value="'+value.name+'">'+value.name+'</option>');
	        			}
	        		});
	    		}
        		

        		if(data.regions != null){
        			$("#uf-region").empty();
        			$('#uf-region').append('<option>Região da Cidade</option>');
	        		$.each(data.regions, function (index, value) {
	        			if(value.region_id == data.region_id) {
	        				$('#uf-region').append('<option value="'+value.region_id+'" selected="selected">'+value.name+'</option>');
	        			}else {
	        				$('#uf-region').append('<option value="'+value.region_id+'">'+value.name+'</option>');
	        			}
	        		});
        		}

        		if(data.addressText != null) {
        			$("#uf-address").val(data.addressText);	
        		}
        		
			});
        }
	});
	});
</script>
<script type="text/javascript">
	function cities(state){
		$.ajax({
			url: base_url+'/users/cities/'+state,
			type: 'GET'
		})
		.done(function(data) {
			$("#uf-city").html(data);
		})
		.fail(function() {
			console.log("cities: error");
		})
		.always(function() {
			var city = $("#uf-city").attr('data-city');

			$("#uf-city").val(city);
		});
	}

	$(document).ready(function() {
		/* geo - begin */
		var state = $("#uf-state").val();
		
		cities(state);

		$("#uf-state").on('change', function(event) {
			var state = $(this).val();

			cities(state);
		});
		/* geo - end */
	});
</script>