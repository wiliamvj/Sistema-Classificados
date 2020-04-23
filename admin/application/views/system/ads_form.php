<div class="row">
	<div class="col-md-12">
		<h1>Editar Anúncio</h1>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<form action="<?=base_url('ads/save')?>" enctype="multipart/form-data" method="POST" accept-charset="utf-8">
			<input type="hidden" name="e" value="<?=(($e) ? $item->ad_id : '')?>">

			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Nome</label>
						<input type="text" class="form-control" name="name" required value="<?=(($e) ? $item->ad_name : '')?>">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Status</label>
						<select class="form-control" required name="status">
							<option <?=(($e && $item->ad_status == '0') ? 'selected' : '')?> value="0">Desativado</option>
							<option <?=(($e && $item->ad_status == '1') ? 'selected' : '')?> value="1">Aprovação Pendente</option>
							<option <?=(($e && $item->ad_status == '2') ? 'selected' : '')?> value="2">Ativado</option>
							<option <?=(($e && $item->ad_status == '3') ? 'selected' : '')?> value="3">Pausado</option>
							<option <?=(($e && $item->ad_status == '5') ? 'selected' : '')?> value="5">Excluído</option>
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Categoria Primária</label>
						<select class="form-control" required id="af-category-primary">
							<?php 
								foreach ($categories as $key => $cat) {
									echo '<option '.(($e && $category_primary->ads_cat_id == $cat->ads_cat_id) ? 'selected' : '').' value="'.$cat->ads_cat_id.'">'.$cat->ads_cat_name.'</option>';
								}
							?>
						</select>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Categoria Secundária</label>
                                                <select class="form-control" onchange="fields('<?php echo base_url();?>fields/campos/?categoria='+this.value,'fields');" required id="af-category-secondary" <?=(($e) ? 'data-category="'.$item->ads_cat_id.'"' : '')?> name="category"></select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>Descrição</label>
						<textarea class="form-control" name="desc" rows="4"><?=(($e) ? $item->ad_desc : '')?></textarea>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-8 col-lg-6">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Preço</label>
								<div class="input-group">
									<span class="input-group-addon">R$</span>
									<input type="text" class="form-control input-price" id="af-price" name="price" value="<?=(($e) ? $item->ad_price : '')?>">
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="checkbox" style="margin-top: 20px;">
								<label>
									<input type="checkbox" id="af-no-price" <?=(($e && $item->ad_service ) ? 'checked' : '')?> name="service"> Não tem preço, é um serviço
								</label>
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" id="af-yes-trade" name="trade"> Aceita troca
								</label>
							</div>
						</div>
					</div>
                                    
                                      
				</div>
			</div>
                        
                        
                         <div class="row">
                                            <div class="col-md-8 col-lg-12">
                                                    
                                                        <span id="janela_fields"></span>
                                                    

                                            </div>
                                    
                                    </div>
                        
                        
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>Imagens</label>
						<div class="images-box">
							<?php
								if($images){
									foreach ($images as $key => $img) {
										echo '
											<div class="ib-item">
												<button type="button" data-toggle="modal" data-modal="'.base_url('ads/images_delete/modal/'.$img->ads_img_id).'" data-target="#modal" class="btn btn-danger btn-xs"><i class="fa fa-fw fa-close"></i></button>

												<a data-lightbox="images" href="'.base_url('uploads/ads/'.$img->ads_img_file).'">
													<img src="'.thumbnail($img->ads_img_file, 'ads', 200, 200).'">
												</a>
											</div>
										';
									}
								}
							?>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label>Video</label>
						<input type="text" class="form-control" name="video" value="<?=(($e) ? $item->ad_video : '')?>">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>Elo7</label>
						<input type="text" class="form-control" name="elo7" value="<?=(($e) ? $item->ad_elo7 : '')?>">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>Mercado Livre</label>
						<input type="text" class="form-control" name="mercado_livre" value="<?=(($e) ? $item->ad_mercado_livre : '')?>">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label>CEP</label>
						<input type="text" class="form-control input-cep" id="af-cep" name="cep" value="<?=(($e) ? $item->ad_cep : '')?>">
					</div>
				</div>
				<div class="col-md-8">
					<div class="checkbox" style="margin-top: 30px;">
						<label>
							<input type="checkbox" name="user_info" id="af-use-info" <?=(($e && $item->ad_use_info ) ? 'checked' : '')?>> Usar informações do perfil
						</label>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 col-lg-4">
					<div class="form-group">
						<label>Estado</label>
						<select class="form-control" name="state" id="af-state" <?=(($e && $item->ad_use_info) ? 'disabled' : '')?> required>
							<?php
								foreach ($states as $key => $sta) {
									echo '<option '.(($e && $item->ad_state == $sta->sta_id) ? 'selected' : '').' value="'.$sta->sta_id.'">'.$sta->sta_name.'</option>';
								}
							?>
						</select>
					</div>
				</div>
				<div class="col-md-6 col-lg-4">
					<div class="form-group">
						<label>Região</label>
						<select class="form-control" name="region" id="af-region" <?=(($e && $item->ad_use_info) ? 'disabled' : '')?> required>
							<?php if($region): ?>
			                <option value="<?= (($region) ? $region : '') ?>" selected="selected"><?= $region ?></option>
			            	<?php endif; ?>
						</select>
					</div>
				</div>
				<div class="col-md-6 col-lg-4">
					<div class="form-group">
						<label>Cidade</label>
						<select class="form-control" id="af-city" name="city" <?=(($e && $item->ad_use_info) ? 'disabled' : '')?> required <?=(($e && $item->ad_city) ? 'data-city="'.$item->ad_city.'"' : '')?>></select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 col-lg-6">
					<div class="form-group">
						<label>Bairro</label>
						<select class="form-control" name="neighborhood" id="af-neighborhood" <?=(($e && $item->ad_use_info) ? 'disabled' : '')?>>
							<?php if($item->ad_neighborhood): ?>
			                <option value="<?= (($item->ad_neighborhood) ? $item->ad_neighborhood : '') ?>" selected="selected"><?= $item->ad_neighborhood ?></option>
			            	<?php endif; ?>
						</select>
					</div>
				</div>

				<div class="col-md-12 col-lg-6">
					<div class="form-group">
						<label>Endereço</label>
						<input type="text" class="form-control" id="af-address" name="address" value="<?=(($e) ? $item->ad_address : '')?>">
					</div>
				</div>
				
			</div>
			<div class="row">
				<div class="col-md-3">
					<a href="<?=base_url('ads')?>" class="btn btn-default btn-lg">Cancelar</a>
					<button type="submit" class="btn btn-primary btn-lg">Salvar</button>
				</div>
				<div class="col-md-3">
					<?php echo '
					<div class="btn-group" role="group">
						'.(($item->ad_status == 1) ? '<button type="button" data-toggle="modal" data-modal="'.base_url('ads/approve/modal/'.$item->ad_id).'" data-target="#modal" class="btn btn-success btn-lg">Aprovar</i></button>' : '').'
						<button type="button" data-toggle="modal" data-modal="'.base_url('ads/delete/modal/'.$item->ad_id).'" data-target="#modal" class="btn btn-danger btn-lg">Excluir</button>
					</div>
					'; ?>
				</div>

			</div>
		</form>
	</div>
</div>
<style>.show-for-small-only{ display: none;}</style>
<?php if($e and $item->ad_id > 0){?>
<script>
    fields('<?php echo base_url();?>fields/campos/?categoria=<?php echo $item->ads_cat_id;?>&ad_id=<?php echo $item->ad_id;?>','fields');
</script>
<?php } ?>

<script type="text/javascript">
    
	$(document).ready(function() {
            

	$("#af-state").change(function() {
		var state_code = $(this).val();

		$.getJSON(base_url+'/address/getbycep/'+state_code+'/regions', function(data) {

    		if(data.regions != null){
    			$("#af-region").empty();
    			$('#af-region').append('<option>Região da cidade</option>');
        		$.each(data.regions, function (index, value) {
        			if(value.region_id == data.region_id) {
        				$('#af-region').append('<option value="'+value.region_id+'" selected="selected">'+value.name+'</option>');
        			}else {
        				$('#af-region').append('<option value="'+value.region_id+'">'+value.name+'</option>');
        			}
        		});
    		}	
		});
		
	});

	$("#af-region").change(function() {
		var state_code = $(this).val();

		$.getJSON(base_url+'/address/getbycep/'+state_code+'/city', function(data) {

    		if(data.cities != null){
    			$("#af-city").empty();
    			$('#af-city').append('<option>Selecione um município</option>');
        		$.each(data.cities, function (index, value) {
        			if(value.city_id == data.city_id) {
        				$('#af-city').append('<option value="'+value.city_id+'" selected="selected">'+value.name+'</option>');
        			}else {
        				$('#af-city').append('<option value="'+value.city_id+'">'+value.name+'</option>');
        			}
        		});
    		}	
		});
		
	});

	$("#af-city").change(function() {
		var str_code = $(this).val();
		$.getJSON(base_url+'/address/getbycep/'+str_code+'/neighborhood', function(data) {

    		if(data.neighborhoods != null){
    			$("#af-neighborhood").empty();
    			$('#af-neighborhood').append('<option>Selecione um bairro</option>');
        		$.each(data.neighborhoods, function (index, value) {
        			if(value.neighborhoods_id == data.neighborhoods_id) {
        				$('#af-neighborhood').append('<option value="'+value.name+'" selected="selected">'+value.name+'</option>');
        			}else {
        				$('#af-neighborhood').append('<option value="'+value.name+'">'+value.name+'</option>');
        			}
        		});
    		}
		});
	});

	$("#af-cep").keyup(function() {
	  	var cep_code = $(this).val();
        if( cep_code.length == 9 ) {
        	$.getJSON(base_url+'/address/getbycep/'+cep_code, function(data) {
        		;

        		if(data.states != null){
        			$("#af-state").empty()
        			$('#af-state').append('<option>Selecione seu estado</option>');
	        		$.each(data.states, function (index, value) {
	        			if(value.state_id == data.state_id) {
	        				$('#af-state').append('<option value="'+value.state_id+'" selected="selected">'+value.name+'</option>');
	        			}else {
	        				$('#af-state').append('<option value="'+value.state_id+'">'+value.name+'</option>');
	        			}
	        		});
        		}

        		if(data.cities != null){
	    			$("#af-city").empty();
	    			$('#af-city').append('<option>Selecione um município</option>');
	        		$.each(data.cities, function (index, value) {
	        			if(value.city_id == data.city_id) {
	        				$('#af-city').append('<option value="'+value.city_id+'" selected="selected">'+value.name+'</option>');
	        			}else {
	        				$('#af-city').append('<option value="'+value.city_id+'">'+value.name+'</option>');
	        			}
        			});
    			}	

    			if(data.neighborhoods != null){
	    			$("#af-neighborhood").empty();
	    			$('#af-neighborhood').append('<option>Selecione um bairro</option>');
	        		$.each(data.neighborhoods, function (index, value) {
	        			if(value.neighborhoods_id == data.neighborhoods_id) {
	        				$('#af-neighborhood').append('<option value="'+value.name+'" selected="selected">'+value.name+'</option>');
	        			}else {
	        				$('#af-neighborhood').append('<option value="'+value.name+'">'+value.name+'</option>');
	        			}
	        		});
	    		}
        		

        		if(data.regions != null){
        			$("#af-region").empty();
        			$('#af-region').append('<option>Região da Cidade</option>');
	        		$.each(data.regions, function (index, value) {
	        			if(value.region_id == data.region_id) {
	        				$('#af-region').append('<option value="'+value.region_id+'" selected="selected">'+value.name+'</option>');
	        			}else {
	        				$('#af-region').append('<option value="'+value.region_id+'">'+value.name+'</option>');
	        			}
	        		});
        		}

        		if(data.addressText != null) {
        			$("#af-address").val(data.addressText);	
        		}
        		
			});
        }
	});
	});
</script>

<script type="text/javascript">
	function categoriesSecondary(primary){
		$.ajax({
			url: base_url+'/ads/categoriesSecondary/'+primary,
			type: 'GET'
		})
		.done(function(data) {
			$("#af-category-secondary").html(data);
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			var categorySecondary = $("#af-category-secondary").attr('data-category');

			$("#af-category-secondary").val(categorySecondary);
		});
	}

	function settingPrice(obj, type){
		if(type == 'service'){
			if(obj.is(':checked')) {
				$("#af-price").attr('disabled', 'disabled');
				$("#af-yes-trade").attr('checked', false);
			}else{
				$("#af-price").removeAttr('disabled');
			}	
		}

		if(type == 'trade'){
			if(obj.is(':checked')) {
				$("#af-no-price").attr('checked', false);
				$("#af-price").removeAttr('disabled');
			}	
		}
	}

	function settingAddress(obj){
		if(obj.is(':checked')) {
			$("#af-cep, #af-address, #af-neighborhood, #af-region, #af-city, #af-state").attr('disabled', 'disabled');
		}else{
			$("#af-cep, #af-address, #af-neighborhood, #af-region, #af-city, #af-state").removeAttr('disabled');
		}
	}

	$(document).ready(function() {
		/* categories - begin */
		var categoryPrimary = $("#af-category-primary").val();
		
		categoriesSecondary(categoryPrimary);

		$("#af-category-primary").on('change', function(event) {
			var categoryPrimary = $(this).val();

			categoriesSecondary(categoryPrimary);
		});
		/* categories - end */

		/* price - begin */
		$("#af-no-price").on('change', function(event) {
			var obj = $(this);

			event.preventDefault();

			settingPrice(obj, 'service');	
		});

		$("#af-yes-trade").on('change', function(event) {
			var obj = $(this);

			event.preventDefault();

			settingPrice(obj, 'trade');	
		});
		/* price - end */

		/* complete price - begin */
		settingPrice($("#af-no-price"), 'service');
		/* complete price - end */

		/* address - begin */
		$("#af-use-info").on('change', function(event) {
			var obj = $(this);

			event.preventDefault();

			settingAddress(obj);		
		});
		/* address - end */

		/* complete user info - begin */
		settingAddress($("#af-use-info"));
		/* complete user info - end */
	});
</script>

<script type="text/javascript">
	function cities(state){
		$.ajax({
			url: base_url+'/ads/cities/'+state,
			type: 'GET'
		})
		.done(function(data) {
			$("#af-city").html(data);
		})
		.fail(function() {
			console.log("cities: error");
		})
		.always(function() {
			var city = $("#af-city").attr('data-city');

			$("#af-city").val(city);
		});
	}

	$(document).ready(function() {
		/* geo - begin */
		var state = $("#af-state").val();
		
		cities(state);

		$("#af-state").on('change', function(event) {
			var state = $(this).val();

			cities(state);
		});
		/* geo - end */
	});
</script>