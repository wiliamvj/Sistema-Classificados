<form method="POST" action="<?=base_url('login/in')?>" id="form-login" class="form form-simple">
	<div class="row">
		<div class="medium-12 columns">
			<input type="email" required name="email" id="input-email" placeholder="email (exemplo@exemplo.com.br)">
		</div>
	</div>
	<div class="row">
		<div class="medium-12 columns">
			<input type="password" required name="password" id="input-password" placeholder="Sua senha">
		</div>
	</div>
	<div class="row">
		<div class="small-12 columns" align="right">
			<a data-modal="<?=base_url('login/password')?>" class="modal-open" href="#">Esqueceu a senha?</a>
		</div>
	</div>

	<div id="login-return"></div>

	<div class="row">
		<div class="medium-12 columns text-right">
                    <button type="button" id="logar" class="btn btn-primary  btn-full cadastrar">Entrar</button>
		</div>
	</div>
	<!--<div class="row">
		<div class="medium-12 columns">
			<a href="<?=$this->config->item('facebook_link_auth')?>" target="_self" class="btn btn-facebook btn-full"><i class="fa fa-facebook"></i> entrar com facebook</a>
		</div>
	</div>-->

</form>

<script src="<?=base_url('assets/js/custom/login.js')?>"></script>