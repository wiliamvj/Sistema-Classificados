<div class="row">
	<div class="medium-8 medium-centered large-6 large-centered columns">
		<div class="simple-page">
			<h1>Recuperação da Senha</h1>

			<form method="POST" action="<?=base_url('login/password/update')?>" id="password-form" class="form form-simple">
				<input type="hidden" name="token" value="<?=$token?>">
				<div class="row">
					<div class="hide-for-small-only medium-4 columns">
						<label class="text-right middle">Nova Senha:<span class="required">*</span></label>
					</div>
					<div class="small-12 medium-8 columns">
						<label class="show-for-small-only">Nova Senha:<span class="required">*</span></label>
						<input type="password" required name="new_pass" id="input-new-pass">
					</div>
				</div>

				<div class="row">
					<div class="hide-for-small-only medium-4 columns">
						<label class="text-right middle">Repita a Senha:<span class="required">*</span></label>
					</div>
					<div class="small-12 medium-8 columns">
						<label class="show-for-small-only">Repita a Senha:<span class="required">*</span></label>
						<input type="password" required name="repeat_pass" id="input-repeat-pass">
					</div>
				</div>

				<div id="password-return"></div>

				<div class="divider divider-m-top-none"></div>

				<div class="row">
					<div class="small-12 columns text-right">
						<button type="button" class="btn btn-link modal-close">Sair</button>
						<button type="submit" class="btn btn-primary">Atualizar</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<script src="<?=base_url('assets/js/custom/login_password_recover.js')?>"></script>