<div class="row">
	<div class="col-md-12">
		<h1>Editar Categoria</h1>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<form action="<?=base_url('categories/save')?>" enctype="multipart/form-data" method="POST" accept-charset="utf-8">
			<input type="hidden" name="e" value="<?=(($e) ? $item->ads_cat_id : '')?>">

			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>Nome</label>
						<input type="text" class="form-control" name="name" required value="<?=(($e) ? $item->ads_cat_name : '')?>">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Ícone</label>
						<input type="text" required class="form-control" name="icon" value="<?=(($e) ? $item->ads_cat_icon : '')?>">
						<small><a href="http://fontawesome.io/icons/" target="_blank">http://fontawesome.io/icons/</a></small>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Status</label>
						<select class="form-control" name="status">
							<option <?=(($e && $item->ads_cat_status == '1') ? 'selected' : '')?> value="1">Ativado</option>
							<option <?=(($e && $item->ads_cat_status == '0') ? 'selected' : '')?> value="0">Desativado</option>
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<a href="<?=base_url('categories')?>" class="btn btn-default btn-lg">Cancelar</a>
					<button type="submit" class="btn btn-primary btn-lg">Salvar</button>
				</div>
			</div>
		</form>
	</div>
</div>