<form method="POST" action="<?=base_url('login/password/send')?>" id="form-login" class="form form-simple">
	<div class="row">
		<div class="small-12 columns">
			<p>Digite seu endereço de e-mail. Você receberá um link para criar uma nova senha via email.</p>
			<br>
		</div>
	</div>
	<div class="row">
		<div class="small-3 columns">
			<label class="text-right middle">Email<span class="required">*</span></label>
		</div>
		<div class="small-9 columns">
			<input type="email" required name="email" id="input-email" placeholder="Digite seu email">
		</div>
	</div>

	<div id="login-return"></div>

	<div class="divider divider-m-top-none"></div>

	<div class="row">
		<div class="small-12 columns text-right">
			<button type="button" data-modal="<?=base_url('login')?>" class="btn btn-link modal-open">Voltar</button>
			<button type="submit" class="btn btn-primary">Recuperar</button>
		</div>
	</div>
</form>