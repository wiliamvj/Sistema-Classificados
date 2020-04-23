<div class="row">
	<div class="col-md-12">
		<h1>Editar Bloco de Publicidade</h1>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<form action="<?=base_url('advertising/save')?>" enctype="multipart/form-data" method="POST" accept-charset="utf-8">
			<input type="hidden" name="e" value="<?=(($e) ? $item->adv_id : '')?>">

			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>Nome</label>
						<input type="text" class="form-control" name="name" required value="<?=(($e) ? $item->adv_name : '')?>">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Posição</label>
						<select class="form-control" name="position">
							<option <?=(($e && $item->adv_position == 'top') ? 'selected' : '')?> value="top">Topo</option>
							<option <?=(($e && $item->adv_position == 'side') ? 'selected' : '')?> value="side">Lateral</option>
						</select>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Status</label>
						<select class="form-control" name="status">
							<option <?=(($e && $item->adv_status == '1') ? 'selected' : '')?> value="1">Ativado</option>
							<option <?=(($e && $item->adv_status == '0') ? 'selected' : '')?> value="0">Desativado</option>
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>Conteúdo</label>
						<small>(Permite HTML)</small>
						<textarea class="form-control" rows="10" name="content"><?=(($e) ? $item->adv_content : '')?></textarea>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<a href="<?=base_url('advertising')?>" class="btn btn-default btn-lg">Cancelar</a>
					<button type="submit" class="btn btn-primary btn-lg">Salvar</button>
				</div>
			</div>
		</form>
	</div>
</div>