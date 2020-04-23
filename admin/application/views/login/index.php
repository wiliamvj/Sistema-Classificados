<div class="row">
	<div class="col-md-12">
		<div class="al-logo">
			<img src="<?=base_url('assets/img/logo.png')?>" alt="your-site">
		</div>
	</div>
</div>

<?php
	$return = $this->session->flashdata('return');

	if($return){
		if($return == "login_error"){
			echo '<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation"></i> Usuário e senha não coincidem. Tente novamente.</div>';
		}

		if($return == "login_required"){
			echo '<div class="alert alert-danger" role="alert"><i class="fa fa-close"></i> Para acessar essa área, você precisa entrar com sua conta de Administrador.</div>';
		}
	}
?>

<div class="row">
	<div class="col-md-12">
		<form class="form-horizontal" method="POST" action="<?=base_url('login/in')?>">
			<div class="form-group">
				<label class="col-sm-2 control-label">Usuário</label>
				<div class="col-sm-10">
					<input type="text" required name="user" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Senha</label>
				<div class="col-sm-10">
					<input type="password" required name="pass" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<div class="checkbox">
						<label>
							<input type="checkbox"> Lembrar-me
						</label>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button type="submit" class="btn btn-primary">Entrar</button>
				</div>
			</div>
		</form>
	</div>
</div>