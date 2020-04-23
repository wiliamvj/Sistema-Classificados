<div class="row">
	<div class="col-md-12">
		<h1>Editar Depoimento</h1>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<form action="<?=base_url('testimonials/save')?>" enctype="multipart/form-data" method="POST" accept-charset="utf-8">
			<input type="hidden" name="e" value="<?=(($e) ? $item->tes_id : '')?>">

			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Nome</label>
						<input type="text" class="form-control" name="name" value="<?=(($e) ? $item->tes_name : '')?>">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Status</label>
						<select class="form-control" name="status">
							<option <?=(($e && $item->tes_status == '1') ? 'selected' : '')?> value="1">Ativado</option>
							<option <?=(($e && $item->tes_status == '2') ? 'selected' : '')?> value="2">Em Análise</option>
							<option <?=(($e && $item->tes_status == '0') ? 'selected' : '')?> value="0">Desativado</option>
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Anúncio</label>
						<input type="text" class="form-control" name="ad" value="<?=(($e) ? $item->tes_ad : '')?>">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Categoria</label>
						<input type="text" class="form-control" name="category" value="<?=(($e) ? $item->tes_category : '')?>">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>Texto</label>
						<textarea class="form-control" name="text" rows="4"><?=(($e) ? $item->tes_text : '')?></textarea>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<a href="<?=base_url('testimonials')?>" class="btn btn-default btn-lg">Cancelar</a>
					<button type="submit" class="btn btn-primary btn-lg">Salvar</button>
				</div>
			</div>
		</form>
	</div>
</div>