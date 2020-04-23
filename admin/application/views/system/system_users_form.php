<div class="row">
	<div class="col-md-12">
		<h1>Editar Usuário</h1>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<form action="<?=base_url('system/users_save')?>" enctype="multipart/form-data" method="POST" accept-charset="utf-8">
			<input type="hidden" name="e" value="<?=(($e) ? $item->adm_use_id : '')?>">

			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Login</label>
						<input type="text" class="form-control" name="login" required value="<?=(($e) ? $item->adm_use_login : '')?>">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Status</label>
						<select class="form-control" name="status">
							<option <?=(($e && $item->adm_use_status == '1') ? 'selected' : '')?> value="1">Ativado</option>
							<option <?=(($e && $item->adm_use_status == '0') ? 'selected' : '')?> value="0">Desativado</option>
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Senha</label>
						<input type="password" <?=(($e) ? '' : 'required')?> class="form-control" name="pass">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>E-mail</label>
						<input type="email" class="form-control" required name="email" value="<?=(($e) ? $item->adm_use_email : '')?>">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<a href="<?=base_url('system/users')?>" class="btn btn-default btn-lg">Cancelar</a>
					<button type="submit" class="btn btn-primary btn-lg">Salvar</button>
				</div>
			</div>
		</form>
	</div>
</div>