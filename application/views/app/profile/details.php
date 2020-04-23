<div class="profile-details">
	<form method="POST" action="<?=base_url('profile/details/save')?>" id="pd-form" class="form form-simple pd-form">
		<h1> <?= first_name($user->use_name) ?> Esse são seus dados | Seu ID é <?=$user->use_id?></h1>

		<div class="row">
			<div class="hide-for-small-only medium-2 columns">
				<label class="text-right middle">Nome:<span class="required">*</span></label>
			</div>
			<div class="small-12 medium-10 columns">
				<label class="show-for-small-only">Nome:<span class="required">*</span></label>
				<input type="text" required name="name" placeholder="Nome Completo" value="<?=$user->use_name?>">
			</div>
		</div>

		<div class="row">
			<div class="hide-for-small-only medium-2 columns">
				<label class="text-right middle">E-mail:<span class="required">*</span></label>
			</div>
			<div class="small-12 medium-10 columns">
				<label class="show-for-small-only">E-mail:<span class="required">*</span></label>
				<input type="email" disabled name="email" value="<?=$user->use_email?>">
			</div>
		</div>

		<div class="row">
			<div class="hide-for-small-only medium-2 columns">
				<label class="text-right middle">Senha:<span class="required">*</span></label>
			</div>
			<div class="small-12 medium-3 columns">
				<label class="show-for-small-only">Senha:<span class="required">*</span></label>
				<input type="password" disabled required name="password" id="pd-password" placeholder="Digite uma senha forte">
			</div>
			<div class="small-12 medium-7 columns">
				<div class="checkbox-custom cc-m-bottom-xsmall" style="margin-top: 5px;">
				   <input type="checkbox" id="pd-pass-check">
				   <label for="pd-pass-check">Alterar Senha</label>
				</div>
			</div>
		</div>

		<br>

		<h1>Dados para contato</h1>
		<h6><i class="fa fa-info-circle" aria-hidden="true"></i> Essas informações servem para loja também, caso você ative.</h6>
		<br>
		<div class="row">
			<div class="hide-for-small-only medium-2 columns">
				<label class="text-right middle">Telefone:</label>
			</div>
			<div class="small-12 medium-3 end columns">
				<label class="show-for-small-only">Telefone:</label>
				<input type="text" name="phone" class="input-phone" placeholder="(__) ____-____" value="<?=$user->use_phone?>">
			</div>
		</div>

		<div class="row">
			<div class="hide-for-small-only medium-2 columns">
				<label class="text-right middle">Celular:<span class="required">*</span></span></label>
			</div>
			<div class="small-12 medium-3 end columns">
				<label class="show-for-small-only">Celular:<span class="required">*</span></label>
				<input type="text" name="celular" required class="input-phone" placeholder="(__) ____-____" value="<?=$user->use_celular?>">
			</div>
		</div>

		<div class="row">
			<div class="hide-for-small-only medium-2 columns">
				<label class="text-right middle">WhatsApp:</label>
			</div>
			<div class="small-12 medium-3 end columns">
				<small>Não use espaços ou traços</small>
				<label class="show-for-small-only">WhatsApp:<span class="required">*</span></label>
				<input type="text" name="whatsapp" class="wpp" placeholder="EX: 48900000000" value="<?=$user->use_whatsapp?>">
			</div>
		</div>

		<div class="row">
			<div class="hide-for-small-only medium-2 columns">
				<label class="text-right middle">Site Pessoal:</label>
			</div>
			<div class="small-12 medium-5 end columns">
				<label class="show-for-small-only">Site Pessoal:</label>
				<input type="text" name="website" placeholder="Informe seu site pessoal" value="<?=$user->use_website?>">
			</div>
		</div>

		<div class="row">
			<div class="hide-for-small-only medium-2 columns">
				<label class="text-right middle">Facebook:</label>
			</div>
			<div class="small-12 medium-5 end columns">
				<label class="show-for-small-only">Facebook:</label>
				<div class="row collapse">
					<div class="small-6 large-5 columns">
						<span class="prefix">facebook.com/</span>
					</div>
					<div class="small-6 large-7 columns">
						<input type="text" name="facebook" placeholder="Seu perfil" value="<?=$user->use_facebook?>">
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="hide-for-small-only medium-2 columns">
				<label class="text-right middle">Instagram:</label>
			</div>
			<div class="small-12 medium-5 end columns">
				<label class="show-for-small-only">Instagram:</label>
				<div class="row collapse">
					<div class="small-6 large-5 columns">
						<span class="prefix">instagram.com/</span>
					</div>
					<div class="small-6 large-7 columns">
						<input type="text" name="instagram" placeholder="Seu perfil" value="<?=$user->use_instagram?>">
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="hide-for-small-only medium-2 columns">
				<label class="text-right middle">Elo7:</label>
			</div>
			<div class="small-12 medium-5 end columns">
				<label class="show-for-small-only">Elo7:</label>
				<div class="row collapse">
					<div class="small-6 large-5 columns">
						<span class="prefix">elo7.com.br/</span>
					</div>
					<div class="small-6 large-7 columns">
						<input type="text" name="elo7" placeholder="Seu perfil" value="<?=$user->use_elo7?>" data-original-title="Insira aqui o link do seu perfil no elo7" data-toggle="tooltip" data-placement="top" title="">
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="hide-for-small-only medium-2 columns">
				<label class="text-right middle">Mercado Livre:</label>
			</div>
			<div class="small-12 medium-5 end columns">
				<label class="show-for-small-only">Mercado Livre:</label>
				<input type="text" name="mercado_livre" placeholder="Informe o link do seus anúncios no ML" value="<?=$user->use_mercado_livre?>" data-original-title="Insira aqui o link da listagem de seus anúncios EX:http://lista.mercadolivre.com.br/_CustId_000000000" data-toggle="tooltip" data-placement="top" title="">
			</div>
		</div>

		<br>

		<h1>Endereço</h1>
		
		<div class="row">
			<div class="medium-10 medium-offset-2 columns">
				<div class="ad_address">
					<div class="row">
				        <div class="hide-for-small-only medium-2 end columns">
				            <label class="text-right middle">CEP:<span class="required">*</span></label>
				        </div>
				        <div class="small-12 medium-5 large-5 end columns">
				            <label class="show-for-small-only">CEP:<span class="required">*</span></label>
				            <input type="text" required class="input-cep" name="cep" id="ai-cep" value="<?=$user->use_cep?>" placeholder="Digite o CEP">
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
			                    <?php
									foreach ($states as $key => $state) {
										echo '<option '.(($user->use_state == $state->sta_id) ? 'selected' : '').' value="'.$state->sta_id.'">'.$state->sta_name.'</option>';
									}
								?>
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
				                <option value="<?=$user->use_region?>" selected="selected"><?= $region ?></option>
				            	<?php endif; ?>
				            </select>
				        </div>
				    </div>
				    
				    <!-- Cidade -->
				    <div class="row">
				        <div class="hide-for-small-only medium-2 columns">
				            <label class="text-right middle">Cidade:<span class="required">*</span></label>
				        </div>
				        <div class="small-12 medium-8 large-8 end columns">
				            <label class="show-for-small-only">Município:<span class="required">*</span></label>
				            <select name="city" id="ai-city" required>
				                <option value="">Selecione uma cidade</option>
				                <?php
								if($user->use_city){
									$cities = $this->main_model->cities($user->use_state);
									foreach ($cities as $key => $city) {
										echo '<option '.(($user->use_city == $city->cit_id) ? 'selected' : '').' value="'.$city->cit_id.'">'.$city->cit_name.'</option>';
									}
								}
							?>
				            </select>
				        </div>
				    </div>

					<!-- Bairro -->
					<div class="row">
				        <div class="hide-for-small-only medium-2 columns">
				            <label class="text-right middle">Bairro:<span class="required">*</span></label>
				        </div>
				        <div class="small-12 medium-8 large-8 end columns">
				            <label class="show-for-small-only">Bairro:<span class="required">*</span></label>
				            <select name="neighborhood" id="ai-neighborhood" required>
				                <option>Selecione um bairro</option>
				                <?php
								echo '<option value="'.$user->use_neighborhood.'" selected>'.$user->use_neighborhood.'</option>';
								?>
				            </select>
				        </div>
				    </div>

				    <!-- Endereço -->
				    <div class="row" id="box-address" <?= (($user->use_address) ? '' : 'style="display:none;"') ?>>
				        <div class="small-12 medium-10 medium-offset-2 end columns">
				            <div id="label-address" style="margin-bottom: 10px;"><b>Endereço:</b><br><?= $user->use_address ?></div>
				            <input type="hidden" name="address" id="ai-address" value="<?=$user->use_address?>">
				        </div>
				    </div>


				</div>
			</div>
		</div>
		
		<br>


		<div class="row">
			<div class="hide-for-small-only medium-2 columns">&nbsp;</div>
			<div class="small-12 medium-10 columns">
				<button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i>Salvar</button>
			</div>
		</div>
	</form>
</div>

<script src="<?=base_url('assets/js/custom/profile_details.js')?>"></script>