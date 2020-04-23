<div class="row">
	<div class="col-md-12">
		<h1>Editar Retorno</h1>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<form action="<?=base_url('returns/save')?>" enctype="multipart/form-data" method="POST" accept-charset="utf-8">
			<input type="hidden" name="e" value="<?=(($e) ? $item->ret_id : '')?>">

			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>Nome</label>
						<input type="text" class="form-control" disabled value="<?=(($e) ? $item->ret_name : '')?>">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Tipo</label>
						<select class="form-control" name="type">
							<option <?=(($e && $item->ret_type == 'primary') ? 'selected' : '' )?> value="primary">primary</option>
							<option <?=(($e && $item->ret_type == 'secondary') ? 'selected' : '' )?> value="secondary">secondary</option>
							<option <?=(($e && $item->ret_type == 'success') ? 'selected' : '' )?> value="success">success</option>
							<option <?=(($e && $item->ret_type == 'danger') ? 'selected' : '' )?> value="danger">danger</option>
							<option <?=(($e && $item->ret_type == 'warning') ? 'selected' : '' )?> value="warning">warning</option>
							<option <?=(($e && $item->ret_type == 'info') ? 'selected' : '' )?> value="info">info</option>
						</select>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Ícone</label>
						<input type="text" class="form-control" name="icon" value="<?=(($e) ? $item->ret_icon : '')?>">
						<small><a href="http://fontawesome.io/icons/" target="_blank">http://fontawesome.io/icons/</a></small>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>Texto</label>
						<input type="text" name="text" class="form-control" value="<?=(($e) ? $item->ret_text : '')?>">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<a href="<?=base_url('returns')?>" class="btn btn-default btn-lg">Cancelar</a>
					<button type="submit" class="btn btn-primary btn-lg">Salvar</button>
				</div>
			</div>
		</form>
	</div>
</div>