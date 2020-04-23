<script src="<?=base_url('assets/js/custom/cep.js')?>"></script>
<div class="simple-page announce-insert">
	<h1>Editar Anúncio</h1>
	<form enctype="multipart/form-data" method="POST" accept-charset="utf-8" action="<?=base_url('profile/ad_edit/save/'.$ad->ad_id)?>" id="ai-form"  class="form form-simple ai-form">
		<input type="hidden" name="hash" id="ai-hash" value="<?=$hash?>">
		<input type="hidden" id="ai-ads-code" value="<?=$ad->ad_id?>">
		<input type="hidden" id="ai-category-parent" value="<?=$category_parent->ads_cat_id?>">
		<input type="hidden" name="category" id="ai-category" value="<?=$ad->ads_cat_id?>">

		<div class="row" id="ai-f-category-required">
			<div class="medium-12 columns">
				<div class="alert alert-danger"><strong>Atenção!</strong> Selecione uma categoria para continuar...</div>
			</div>
		</div>

		<div class="row">
			<div class="hide-for-small-only medium-2 columns">
				<label class="text-right middle">Categoria:<span class="required">*</span></label>
			</div>
			<div class="small-12 medium-10 columns">
				<label class="show-for-small-only">Categoria:<span class="required">*</span></label>
				<div class="ai-f-categories">
					<div class="l" id="ai-f-c-parent">
						<ul>
							<?php
								foreach ($categories as $key => $cat) {
									echo '<li data-id="'.$cat->ads_cat_id.'"><i class="fa fa-fw '.$cat->ads_cat_icon.'"></i>'.$cat->ads_cat_name.'</li>';
								}
							?>
						</ul>
					</div>
					<div class="r" id="ai-f-c-sub">&nbsp;</div>
				</div>
			</div>
		</div>

		<div class="row">

                            <div class="hide-for-small-only medium-2 columns">
                                <label class="text-right middle">Título:<span class="required">*</span></label>
                            </div>
                            
                            <div class="small-12 medium-10 large-10 end columns">
                                <label class="show-for-small-only">Título:<span class="required">*</span></label>
                                
                                  <div id="msg_titulo" class="alert alert-subtitle" id="msgImg" style="display: none;">
                                    <ul><li><span style="font-size: 15px;"><i class="fa fa-info-circle"></i> Atenção:</span> <span style="color: orange; font-size: 14px;">	 	<strong>Não aceitamos venda de animais! Não compre, adote <i class="fa fa-heart"></i></strong></span></li></ul>
                                </div>
                                
       
                                <input type="text" required name="title" id="ai-title" placeholder="Título do Anúncio" maxlength="70">
                            </div>
                        </div>

		<div class="row">
			<div class="hide-for-small-only medium-2 columns">
				<label class="text-right middle">Descrição:<span class="required">*</span></label>
			</div>
			<div class="small-12 medium-10 large-10 end columns">
				<label class="show-for-small-only">Descrição:<span class="required">*</span></label>
				<textarea required name="desc" rows="6" placeholder="Descrição do Anúncio"><?=$ad->ad_desc?></textarea>
			</div>
		</div>

                <div id="desativa" <?php echo ($ad->ads_cat_id == 114) ? 'style="display:none;"':'';?> class="row">
			<div id="not_desktop_preco" <?php echo ($ad->adote) ? 'style="display:none;"':'';?> class="hide-for-small-only medium-2 columns">
				<label class="text-right middle">Preço:<span class="required">*</span></label>
			</div>
			<div id="not_preco" <?php echo ($ad->adote) ? 'style="display:none;"':'';?> class="small-12 medium-4 large-4 end columns">
				<label class="show-for-small-only">Preço:<span class="required">*</span></label>
				<div class="row collapse">
					<div class="small-3 large-2 columns">
						<span class="prefix">R$</span>
					</div>
					<div class="small-9 large-10 columns">
						<input type="text" required class="input-money" name="price" id="ai-price" value="<?=$ad->ad_price?>" placeholder="Preço do Anúncio">
					</div>
				</div>
			</div>
                    <div id="bloco"  <?php echo ($ad->adote) ? 'style="margin-left: 150px; padding-bottom: 60px;"':'class="small-12 medium-6 large-6 columns"';?>>
                        <div id="service" <?php echo ($ad->adote) ? 'style="display:none;"':'';?> class="checkbox-custom cc-m-bottom-xsmall" style="margin-top: -6px;">
				   <input type="checkbox" name="no-price" <?=(($ad->ad_service) ? 'checked' : '')?> id="ai-no-price">
				   <label for="ai-no-price">Não tem preço, é um serviço.</label>
				</div>
                        <div id="trade" <?php echo ($ad->adote) ? 'style="display:none;"':'';?> class="checkbox-custom cc-m-bottom-xsmall">
				   <input type="checkbox" name="yes-trade" <?=(($ad->ad_service) ? 'checked' : '')?> id="ai-yes-trade">
				   <label for="ai-yes-trade">Aceito troca.</label>
				</div>
                            <div id="adote" style=" <?=(($category_parent->ads_cat_id == 1) ? '' : 'display:none;')?> margin-left: -12px;" class="small-12 medium-4 large-10 end columns">
                                    <strong>Este anúncio trata-se de um Animal?</strong>
                                    <div id="ai-adote" class="checkbox-custom cc-m-bottom-xsmall">
                                        <input type="checkbox" name="adote"  <?=(($ad->adote) ? 'checked' : '')?>  id="ai-yes-adote" value="1">
                                        <label>Sim</label>
                                    </div>
                                </div>
				<div class="show-for-small-only"><br></div>
			</div>
		</div>

		<!-- custom fields - begin -->

		<div id="ai-custom-fields"></div>

		<!-- custom fields - end -->

		<div class="row">
			<div class="hide-for-small-only medium-2 columns">
				<label class="text-right middle">Imagens:<span class="required">*</span></label>
			</div>
			<div class="small-12 medium-10 large-10 end columns">
				<label class="show-for-small-only">Imagens:<span class="required">*</span></label>
	
				<div class="dropzone" id="images-upload">
					<?php
						if($images){
							foreach ($images as $key => $img) {
								echo '
									<div class="dz-preview dz-file-preview dz-image-db">
										<div class="dz-remove-file"><span title="Apagar Imagem" data-image="'.$img->ads_img_id.'"><i class="fa fa-fw fa-trash"></i></span></div>
										<div class="dz-image">
											<img src="'.thumbnail($img->ads_img_file, 'ads', 120, 120).'">
										</div>
									</div>
								';
							}
						}
					?>
				</div>

				<div id="image-preview-template" style="display: none">
					<div class="dz-preview dz-file-preview">
						<div class="dz-remove-file" style="display: none"><span title="Apagar Imagem" data-dz-remove><i class="fa fa-fw fa-trash"></i></span></div>
						<div class="dz-image">
							<img data-dz-thumbnail />
						</div>
						<div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
						<div class="dz-success-mark"><span><i class="fa fa-fw fa-check"></i></span></div>
						<div class="dz-error-mark"><span><i class="fa fa-fw fa-close"></i></span></div>
						<div class="dz-error-message"><span data-dz-errormessage></span></div>
					</div>
				</div>					
				<button type="button" class="btn btn-secondary btn-m-bottom-medium" id="images-upload-button">
					<i class="fa fa-picture-o"></i> Adicionar fotos
				</button>
				<div style="clear: both;"></div>
				<div class="alert alert-subtitle hide-for-small-only" id="msgImg" style="display: none;">
                                    <ul><li><span style="font-size: 15px;">Atenção:</span> <span style="color: red; font-size: 14px;"><strong>Altura e largura mínima:</strong> 350x260px</span></li></ul>
                                </div>
				<div class="alert alert-subtitle">
					<ul>
						<li><strong>Tamanho máximo:</strong> 8MB</li>
						<li><strong>Altura e largura mínima:</strong> 400px</li>
						<li><strong>Máximo de imagens permitidas:</strong> 10</li>
						<li><strong>Tipos arquivo permitido:</strong> JPG, JPEG e PNG</li>
						<li><strong>A primeira imagem será usada como a principal</strong></li>
					</ul>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="hide-for-small-only medium-2 columns">
				<label class="text-right middle">Vídeo:</label>
			</div>
			<div class="small-12 medium-6 large-6 end columns">
				<label class="show-for-small-only">Vídeo:</label>
				<input type="text" name="video" placeholder="Link Vídeo do Produto" value="<?=$ad->ad_video?>" data-original-title="Só aceitamos videos do Youtube, caso coloque de outro site, não garantimos o funcionamento." data-toggle="tooltip" data-placement="top" title="">
				
			</div>
		</div>

		<div class="row">
			<div class="hide-for-small-only medium-2 columns">
				<label class="text-right middle">Mercado Livre:</label>
			</div>
			<div class="small-12 medium-6 large-6 end columns">
				<label class="show-for-small-only">Mercado Livre:</label>
				<input type="text" name="mercado_livre" value="<?=$ad->ad_mercado_livre?>" placeholder="Link do seu anúncio no Mercado Livre" data-original-title="Caso tenha um anúncio no Mercado Livre do mesmo produto, coloque o link e venda mais rápido." data-toggle="tooltip" data-placement="top" title="">
			</div>
		</div>

		<div class="row">
			<div class="hide-for-small-only medium-2 columns">
				<label class="text-right middle">Elo7:</label>
			</div>
			<div class="small-12 medium-6 large-6 end columns">
				<label class="show-for-small-only">Elo7:</label>
				<input type="text" name="elo7" value="<?=$ad->ad_elo7?>" placeholder="Link do seu anúncio no Elo7" data-original-title="Caso tenha um anúncio no Elo7 do mesmo produto, coloque o link e venda mais rápido." data-toggle="tooltip" data-placement="top" title="">
			</div>
		</div>
		
		
		<div class="row">
			<div class="medium-10 medium-offset-2 columns">
				<div class="ad_address">
					<div class="row">
				        <div class="hide-for-small-only medium-2 end columns">
				            <label class="text-right middle">CEP:<span class="required">*</span></label>
				        </div>
				        <div class="small-12 medium-5 large-5 end columns">
				            <label class="show-for-small-only">CEP:<span class="required">*</span></label>
				            <input type="text" required class="input-cep" name="cep" id="ai-cep" value="<?= (($ad->ad_cep) ? $ad->ad_cep : $ad->use_cep) ?>" placeholder="Digite o CEP">
				        </div>
				        <div class="small-12 medium-5 columns">
				        	<a href="http://www.buscacep.correios.com.br/sistemas/buscacep/" class="cep_link" target="_blank">
					            <span class="btn btn-help hidden-xs">
	                                <i class="fa fa-question"></i>
	                            </span>
				                Não sei meu CEP
				            </a>
				        </div>
				    </div>

				    <!-- Estado -->
				    <div class="row">
				        <div class="hide-for-small-only medium-2 columns">
				            <label class="text-right middle">Estado:<span class="required">*</span></label>
				        </div>
				        <div class="small-12 medium-8 large-8 end columns">
				            <label class="show-for-small-only">Estado:<span class="required">*</span></label>
				            <select name="state" id="ai-state" required >
			                    <option>Selecione seu Estado</option>
			                    <?php if($state): ?>
				                <option value="<?= (($ad->ad_state) ? $ad->ad_state : $ad->use_state) ?>" selected="selected"><?= $state ?></option>
				            	<?php endif; ?>
				            </select>
				        </div>
				    </div>

				    <!-- Região -->
				    <div class="row">
				        <div class="hide-for-small-only medium-2 columns">
				            <label class="text-right middle">Região:<span class="required">*</span></label>
				        </div>
				        <div class="small-12 medium-8 large-8 end columns">
				            <label class="show-for-small-only">Região:<span class="required">*</span></label>
				            <select name="region" id="ai-region" required>
				                <option value="">Região da Cidade</option>
				                <?php if($region): ?>
				                <option value="<?= (($ad->ad_region) ? $ad->ad_region : $ad->use_region) ?>" selected="selected"><?= $region ?></option>
				            	<?php endif; ?>
				            </select>
				        </div>
				    </div>
				    
				    <!-- Cidade -->
				    <div class="row">
				        <div class="hide-for-small-only medium-2 columns">
				            <label class="text-right middle">Município:<span class="required">*</span></label>
				        </div>
				        <div class="small-12 medium-8 large-8 end columns">
				            <label class="show-for-small-only">Município:<span class="required">*</span></label>
				            <select name="city" id="ai-city" required>
				                <option value="">Selecione um município</option>
				                <?php if($city): ?>
				                <option value="<?= (($ad->ad_city) ? $ad->ad_city : $ad->use_city) ?>" selected="selected"><?= $city ?></option>
				            	<?php endif; ?>
				            </select>
				        </div>
				    </div>

				    <!-- Bairro -->
				    <div class="row" id="box-neighborhood" <?= (($neighborhood) ? '' : 'style="display:none;"') ?>>
				        <div class="small-12 medium-10 medium-offset-2 end columns">
				            <div id="label-neighborhood" style="margin-bottom: 10px;"><b>Bairro:</b><br><?= $neighborhood ?></div>
				            <input type="hidden" name="neighborhood" id="ai-neighborhood" value="<?= $neighborhood ?>">
				        </div>
				    </div>

				    <!-- Endereço -->
				    <div class="row" id="box-address" <?= (($address) ? '' : 'style="display:none;"') ?>>
				        <div class="small-12 medium-10 medium-offset-2 end columns">
				            <div id="label-address" style="margin-bottom: 10px;"><b>Endereço:</b><br><?= $address ?></div>
				            <input type="hidden" name="address" id="ai-address" value="<?= $address ?>">
				        </div>
				    </div>


				    <div class="row">
				        <div class="small-12 medium-10 medium-offset-2 columns">
				            <div class="checkbox-custom cc-m-bottom-xsmall" style="margin-top: 5px">
				                <input type="checkbox" name="use-info" id="ai-use-info" >
				                <label for="ai-use-info">Usar informações do meu perfil</label>
				            </div>
				        </div>
				    </div>
 

				</div>
			</div>
		</div>

        


		<div class="row">
			<div class="small-12 columns" align="center">
				<div class="ai-f-actions">
					<button type="button" onclick="window.location.href = '<?=base_url('cliente/painel')?>'" class="btn btn-default">Cancelar</button>
                                        <button type="submit" id="publish-button"  class="btn btn-primary"><i class="fa fa-floppy-o"></i>Salvar</button>
				</div>
			</div>
		</div>
	</form>
</div>
<script>
    $(function() {
        $("#ai-adote").click(function() {

            if ($('#ai-yes-adote').is(':checked')) {
                $('#ai-price').prop('disabled', false);
                $('#ai-yes-adote').prop('checked', false);
                $('#not_preco').show();
                $('#not_desktop_preco').show();
                $('#service').show();
                $('#trade').show();
                $('#bloco').addClass('small-12 medium-6 large-6 columns');
                $('#bloco').removeAttr('style');
            } else {
                $('#bloco').removeClass('small-12 medium-6 large-6 columns');
                $('#bloco').css({"margin-left":"150px", "padding-bottom":"60px"});
                $('#service').hide();
                $('#trade').hide();
                $('#not_preco').hide();
                $('#not_desktop_preco').hide();
                $('#ai-price').prop('disabled', true);
                $('#ai-yes-adote').prop('checked', true);
            }
        });
    });

    $("#ai-f-c-parent").on('click', 'li', function(event) {
        var btn = $(this);
        var cat = btn.attr('data-id');
        event.preventDefault();
        if (cat == 1) {
            $('#msg_titulo').show();
            $('#adote').show();

        } else {
            $('#msg_titulo').hide();
            $('#adote').hide();
        }
        
        if (cat == 114) {
            $('#ai-price').prop('disabled', true);
            $('#desativa').hide();

        } else {
            $('#ai-price').prop('disabled', false);
            $('#desativa').show();
        }
    });
</script>
<script>
    var total_img = $('.dz-image').length;
    if(total_img == 1){
        $('#publish-button').prop('disabled', true);
    }else{
        $('#publish-button').prop('disabled', false);
    }
</script>
<script src="<?=base_url('assets/js/vendor/dropzone.js')?>"></script>
<script src="<?=base_url('assets/js/custom/announce.js')?>"></script>
<script src="<?=base_url('assets/js/custom/profile_ad_edit.js')?>"></script>