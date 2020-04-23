<div class="row">
	<div class="col-md-12">
		<h1>Editar Loja</h1>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<form action="<?=base_url('shops/save')?>" enctype="multipart/form-data" method="POST" accept-charset="utf-8">
			<input type="hidden" name="e" value="<?=(($e) ? $item->shop_id : '')?>">

			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Nome</label>
						<input type="text" class="form-control" name="name" required value="<?=(($e) ? $item->shop_name : '')?>">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Status</label>
						<select class="form-control" name="status" required>
							<option <?=(($e && $item->shop_status == '1') ? 'selected' : '')?> value="1">Ativado</option>
							<option <?=(($e && $item->shop_status == '0') ? 'selected' : '')?> value="0">Desativado</option>
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>Descrição</label>
						<textarea class="form-control" name="desc" rows="4"><?=(($e) ? $item->shop_desc : '')?></textarea>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Telefone</label>
						<input type="text" class="form-control input-phone" name="phone" value="<?=(($e) ? $item->shop_phone : '')?>">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>URL Amigável</label>
						<div class="input-group">
							<span class="input-group-addon">seusite.com.br/loja/</span>
							<input type="text" class="form-control" name="slug" value="<?=(($e) ? $item->shop_slug : '')?>">
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Categoria</label>
						<select class="form-control" required name="category">
							<?php
								foreach ($categories as $key => $category) {
									echo '<option '.(($e && $item->ads_cat_id == $category->ads_cat_id) ? 'selected' : '').' value="'.$category->ads_cat_id.'">'.$category->ads_cat_name.'</option>';
								}
							?>
						</select>
					</div>
				</div>
				<div class="col-md-6">
					<div class="row">
						<div class="col-md-8">
							<label>Imagem</label>
							<input type="file" class="form-control" name="image" <?=(($e && $item->shop_img_file) ? '' : 'required')?>>
						</div>
						<div class="col-md-4" align="center">
							<?php
								if($e && $item->shop_img_file){
									echo '
										<a data-lightbox="images" href="'.base_url('/uploads/shops/'.$item->shop_img_file).'">
											<img src="'.thumbnail($item->shop_img_file, 'shops', 250, 250, 2).'">
										</a>
									';
								}
							?>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label>CEP</label>
						<input type="text" class="form-control input-cep" id="sf-cep" name="cep" value="<?=(($e) ? $item->shop_cep : '')?>">
					</div>
				</div>
				<div class="col-md-8">
					<div class="checkbox" style="margin-top: 30px;">
						<label>
							<input type="checkbox" id="sf-user-info" name="user_info" <?=(($e && $item->shop_user_info) ? 'checked' : '')?>> Pegar informações do perfil
						</label>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 col-lg-4">
					<div class="form-group">
						<label>Estado</label>
						<select class="form-control" name="state" id="sf-state" <?=(($e && $item->ad_use_info) ? 'disabled' : '')?>>
							<?php
								foreach ($states as $key => $sta) {
									echo '<option '.(($e && $item->shop_state == $sta->sta_id) ? 'selected' : '').' value="'.$sta->sta_id.'">'.$sta->sta_name.'</option>';
								}
							?>
						</select>
					</div>
				</div>
				<div class="col-md-6 col-lg-4">
					<div class="form-group">
						<label>Região</label>
						<select class="form-control" name="region" id="sf-region" <?=(($e && $item->shop_use_info) ? 'disabled' : '')?>>
							<?php if($region): ?>
			                <option value="<?= (($region) ? $region : '') ?>" selected="selected"><?= $region ?></option>
			            	<?php endif; ?>
						</select>
					</div>
				</div>
				<div class="col-md-6 col-lg-4">
					<div class="form-group">
						<label>Cidade</label>
						<select class="form-control" id="sf-city" name="city" <?=(($e && $item->shop_use_info) ? 'disabled' : '')?> <?=(($e && $item->shop_city) ? 'data-city="'.$item->shop_city.'"' : '')?>></select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 col-lg-6">
					<div class="form-group">
						<label>Bairro</label>
						<select class="form-control" name="neighborhood" id="sf-neighborhood" <?=(($e && $item->ad_use_info) ? 'disabled' : '')?>>
							<?php if($item->shop_neighborhood): ?>
			                <option value="<?= (($item->shop_neighborhood) ? $item->shop_neighborhood : '') ?>" selected="selected"><?= $item->shop_neighborhood ?></option>
			            	<?php endif; ?>
						</select>
					</div>
				</div>

				<div class="col-md-12 col-lg-6">
					<div class="form-group">
						<label>Endereço</label>
						<input type="text" class="form-control" id="sf-address" name="address" value="<?=(($e) ? $item->shop_address : '')?>">
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<a href="<?=base_url('shops')?>" class="btn btn-default btn-lg">Cancelar</a>
					<button type="submit" class="btn btn-primary btn-lg">Salvar</button>
				</div>
			</div>
		</form>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {

	$("#sf-state").change(function() {
		var state_code = $(this).val();

		$.getJSON(base_url+'/address/getbycep/'+state_code+'/regions', function(data) {

    		if(data.regions != null){
    			$("#sf-region").empty();
    			$('#sf-region').append('<option>Região da cidade</option>');
        		$.each(data.regions, function (index, value) {
        			if(value.region_id == data.region_id) {
        				$('#sf-region').append('<option value="'+value.region_id+'" selected="selected">'+value.name+'</option>');
        			}else {
        				$('#sf-region').append('<option value="'+value.region_id+'">'+value.name+'</option>');
        			}
        		});
    		}	
		});
		
	});

	$("#sf-region").change(function() {
		var state_code = $(this).val();

		$.getJSON(base_url+'/address/getbycep/'+state_code+'/city', function(data) {

    		if(data.cities != null){
    			$("#sf-city").empty();
    			$('#sf-city').append('<option>Selecione um município</option>');
        		$.each(data.cities, function (index, value) {
        			if(value.city_id == data.city_id) {
        				$('#sf-city').append('<option value="'+value.city_id+'" selected="selected">'+value.name+'</option>');
        			}else {
        				$('#sf-city').append('<option value="'+value.city_id+'">'+value.name+'</option>');
        			}
        		});
    		}	
		});
		
	});

	$("#sf-city").change(function() {
		var str_code = $(this).val();
		$.getJSON(base_url+'/address/getbycep/'+str_code+'/neighborhood', function(data) {

    		if(data.neighborhoods != null){
    			$("#sf-neighborhood").empty();
    			$('#sf-neighborhood').append('<option>Selecione um bairro</option>');
        		$.each(data.neighborhoods, function (index, value) {
        			if(value.neighborhoods_id == data.neighborhoods_id) {
        				$('#sf-neighborhood').append('<option value="'+value.name+'" selected="selected">'+value.name+'</option>');
        			}else {
        				$('#sf-neighborhood').append('<option value="'+value.name+'">'+value.name+'</option>');
        			}
        		});
    		}
		});
	});

	$("#sf-cep").keyup(function() {
	  	var cep_code = $(this).val();
        if( cep_code.length == 9 ) {
        	$.getJSON(base_url+'/address/getbycep/'+cep_code, function(data) {
        		;

        		if(data.states != null){
        			$("#sf-state").empty()
        			$('#sf-state').append('<option>Selecione seu estado</option>');
	        		$.each(data.states, function (index, value) {
	        			if(value.state_id == data.state_id) {
	        				$('#sf-state').append('<option value="'+value.state_id+'" selected="selected">'+value.name+'</option>');
	        			}else {
	        				$('#sf-state').append('<option value="'+value.state_id+'">'+value.name+'</option>');
	        			}
	        		});
        		}

        		if(data.cities != null){
	    			$("#sf-city").empty();
	    			$('#sf-city').append('<option>Selecione um município</option>');
	        		$.each(data.cities, function (index, value) {
	        			if(value.city_id == data.city_id) {
	        				$('#sf-city').append('<option value="'+value.city_id+'" selected="selected">'+value.name+'</option>');
	        			}else {
	        				$('#sf-city').append('<option value="'+value.city_id+'">'+value.name+'</option>');
	        			}
        			});
    			}	

    			if(data.neighborhoods != null){
	    			$("#sf-neighborhood").empty();
	    			$('#sf-neighborhood').append('<option>Selecione um bairro</option>');
	        		$.each(data.neighborhoods, function (index, value) {
	        			if(value.neighborhoods_id == data.neighborhoods_id) {
	        				$('#sf-neighborhood').append('<option value="'+value.name+'" selected="selected">'+value.name+'</option>');
	        			}else {
	        				$('#sf-neighborhood').append('<option value="'+value.name+'">'+value.name+'</option>');
	        			}
	        		});
	    		}
        		

        		if(data.regions != null){
        			$("#sf-region").empty();
        			$('#sf-region').append('<option>Região da Cidade</option>');
	        		$.each(data.regions, function (index, value) {
	        			if(value.region_id == data.region_id) {
	        				$('#sf-region').append('<option value="'+value.region_id+'" selected="selected">'+value.name+'</option>');
	        			}else {
	        				$('#sf-region').append('<option value="'+value.region_id+'">'+value.name+'</option>');
	        			}
	        		});
        		}

        		if(data.addressText != null) {
        			$("#sf-address").val(data.addressText);	
        		}
        		
			});
        }
	});
	});
</script>

<script type="text/javascript">
	$(document).ready(function() {
		$("#sf-user-info").on('change', function(event) {
			var obj = $(this);

			event.preventDefault();

			if(obj.is(':checked')) {
				$("#sf-address, #sf-address-add, #sf-region, #sf-neighborhood, #sf-city, #sf-state").attr('disabled', 'disabled');
			}else{
				$("#sf-address, #sf-address-add, #sf-region, #sf-neighborhood, #sf-city, #sf-state").removeAttr('disabled');
			}	
		});
	});
</script>

<script type="text/javascript">
	function cities(state){
		$.ajax({
			url: base_url+'/shops/cities/'+state,
			type: 'GET'
		})
		.done(function(data) {
			$("#sf-city").html(data);
		})
		.fail(function() {
			console.log("cities: error");
		})
		.always(function() {
			var city = $("#sf-city").attr('data-city');

			$("#sf-city").val(city);
		});
	}

	$(document).ready(function() {
		/* geo - begin */
		var state = $("#sf-state").val();
		
		cities(state);

		$("#sf-state").on('change', function(event) {
			var state = $(this).val();

			cities(state);
		});
		/* geo - end */
	});
</script>