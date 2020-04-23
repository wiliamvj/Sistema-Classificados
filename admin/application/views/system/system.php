<div class="row">

	<div class="col-md-12">

		<h1>Sistema</h1>

	</div>

</div>



<div class="row">

	<div class="col-md-12">

		<form method="POST" action="<?=base_url('system/update')?>">

			<div class="row">

				<div class="col-md-12">

					<h3>Configurações Básicas</h3>

				</div>

			</div>

			<div class="row">

				<div class="col-md-6">

					<div class="form-group">

						<label>Título do Site</label>

						<input type="text" class="form-control" name="seo_title" required value="<?=$system->cfg_seo_title?>">

					</div>

				</div>

				<div class="col-md-6">

					<div class="form-group">

						<label>Palavras-Chave</label>

						<input type="text" class="form-control" name="seo_keywords" value="<?=$system->cfg_seo_keywords?>">

					</div>

				</div>

			</div>

			<div class="row">

				<div class="col-md-12">

					<div class="form-group">

						<label>Descrição do Site</label>

						<textarea class="form-control" name="seo_desc" rows="3"><?=$system->cfg_seo_desc?></textarea>

					</div>

				</div>

			</div>

			<div class="row">

				<div class="col-md-12">

					<div class="form-group">

						<label>E-mail de Contato</label>

						<input type="email" class="form-control" name="contact_email" required value="<?=$system->cfg_contact_email?>">

					</div>

				</div>

			</div>

			            <br>
			<div class="row" style="padding:7px;background-color:#fff4a6;border: 1px solid #DDD;">

				<div class="col-md-4">

					<div class="form-group">

						<label>Slogan Principal</label>

						<input maxlength="35" type="text" placeholder="Anunciou, vendeu!" class="form-control" name="slogan_pri" required value="<?=$system->cfg_slogan_pri?>">
                        
                        <span>35 caracteres no máximo</span>

					</div>

				</div>

				<div class="col-md-4">

					<div class="form-group">

						<label>Slogan Secundário</label>

						<input maxlength="45" type="text" placeholder="Melhor do Brasil" class="form-control" name="slogan_sec" value="<?=$system->cfg_slogan_sec?>">
                        
                        <span>45 caracteres no máximo</span>

					</div>

				</div>
                <div class="col-md-4">

					<div class="form-group">

						<label>Slogan Mobile</label>

						<input maxlength="20" placeholder="Anunciou, vendeu!" type="text" class="form-control" name="slogan_mob" value="<?=$system->cfg_slogan_mob?>">
                        
                        <span>20 caracteres no máximo</span>

					</div>

				</div>

            </div>

			<div class="row">

				<div class="col-md-12">

					<h3>Configurações Adicionais</h3>

				</div>

			</div>

			<div class="row">

				<div class="col-md-6">

					<div class="form-group">

						<label>Contador de Anúncios</label>

						<div class="checkbox">

							<label>

								<input type="checkbox" <?=(($system->cfg_ads_count) ? 'checked' : '')?> name="ads_count"> Habilitar contador de anúncios e lojas na página principal.

							</label>

						</div>

					</div>

				</div>

				<div class="col-md-6">

					<div class="form-group">

						<label>Manutenção <small>(Coloque um IP para restrigir o acesso somente para ele)</small></label>

						<div class="row">

							<div class="col-md-10"><input type="text" id="s-maintenance" class="form-control" name="maintenance" value="<?=$system->cfg_maintenance?>"></div>

							<div class="col-md-2"><button type="button" id="s-my-ip" class="btn btn-info btn-block"><i class="fa fa-fw fa-crosshairs"></i></button></div>

						</div>

						<div align="right"><small>Inserir meu IP</small></div>

					</div>

				</div>

			</div>



			<div class="row">

				<div class="col-md-12">

					<h3>Configurações SMTP <i class="fa fa-exclamation-triangle"> <small>(A configuração errada pode quebrar o disparo de e-mails!)</small></i></h3>


				</div>

			</div>

			<div class="row">

				<div class="col-md-6">

					<div class="form-group">

						<label>Servidor</label>

						<input type="text" class="form-control" name="smtp_host" value="<?=$system->cfg_smtp_host?>">

					</div>

				</div>

				<div class="col-md-6">

					<div class="form-group">

						<label>Porta</label>

						<input type="text" class="form-control" name="smtp_port" value="<?=$system->cfg_smtp_port?>">

					</div>

				</div>

			</div>

			<div class="row">

				<div class="col-md-6">

					<div class="form-group">

						<label>Usuário</label>

						<input type="text" class="form-control" name="smtp_user" value="<?=$system->cfg_smtp_user?>">

					</div>

				</div>

				<div class="col-md-6">

					<div class="form-group">

						<label>Senha</label>

						<input type="password" class="form-control" name="smtp_pass" value="<?=$system->cfg_smtp_pass?>">

					</div>

				</div>

			</div>



			<div class="row">

				<div class="col-md-12">

					<h3>Redes Sociais</h3>

				</div>

			</div>

			<div class="row">

				<div class="col-md-6">

					<div class="form-group">

						<label>Facebook</label>

						<div class="input-group">

							<span class="input-group-addon"><i class="fa fa-fw fa-facebook"></i></span>

							<input type="text" class="form-control" name="social_facebook" value="<?=$system->cfg_social_facebook?>">

						</div>

					</div>

				</div>

				<div class="col-md-6">

					<div class="form-group">

						<label>Youtube</label>

						<div class="input-group">

							<span class="input-group-addon"><i class="fa fa-fw fa-youtube-play"></i></span>

							<input type="text" class="form-control" name="social_google" value="<?=$system->cfg_social_google?>">

						</div>

					</div>

				</div>

			</div>

			<div class="row">

				<div class="col-md-6">

					<div class="form-group">

						<label>Twitter</label>

						<div class="input-group">

							<span class="input-group-addon"><i class="fa fa-fw fa-twitter"></i></span>

							<input type="text" class="form-control" name="social_twitter" value="<?=$system->cfg_social_twitter?>">

						</div>

					</div>

				</div>

				<div class="col-md-6">

					<div class="form-group">

						<label>Instagram</label>

						<div class="input-group">

							<span class="input-group-addon"><i class="fa fa-fw fa-instagram"></i></span>

							<input type="text" class="form-control" name="social_instagram" value="<?=$system->cfg_social_linkedin?>">

						</div>

					</div>

				</div>

			</div>



			<div class="row">

				<div class="col-md-12">

					<button type="submit" class="btn btn-primary btn-lg">Salvar</button>

				</div>

			</div>

		<form>

	</div>

</div>



<script type="text/javascript" src="https://l2.io/ip.js?var=myip"></script>

<script type="application/javascript">

	$(document).ready(function() {

		$("#s-my-ip").on('click', function(event) {

			$("#s-maintenance").val(myip);

		});

	});

</script>