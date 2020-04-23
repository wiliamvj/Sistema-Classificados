<div class="row">
	<div class="col-md-12">
		<h1>Editar Campo</h1>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<form action="<?=base_url('categories/fields_save')?>" enctype="multipart/form-data" method="POST" accept-charset="utf-8">
			<input type="hidden" name="category" value="<?=(($e) ? $item->ads_cat_id : $code)?>">
			<input type="hidden" name="e" value="<?=(($e) ? $item->cat_fie_id : '')?>">

			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Nome</label>
						<input type="text" class="form-control" name="name" required value="<?=(($e) ? $item->cat_fie_name : '')?>">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Status</label>
						<select class="form-control" name="status">
							<option <?=(($e && $item->cat_fie_status == '1') ? 'selected' : '')?> value="1">Ativado</option>
							<option <?=(($e && $item->cat_fie_status == '0') ? 'selected' : '')?> value="0">Desativado</option>
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="cf-type">Tipo</label>
						<select class="form-control" required name="type" id="cf-type">
							<option hidden value="">Selecione um tipo</option>
							<option <?=(($e && $item->cat_fie_type == 'text') ? 'selected' : '')?> value="text">Text Input</option>
							<option <?=(($e && $item->cat_fie_type == 'textarea') ? 'selected' : '')?> value="textarea">Textarea</option>
							<option <?=(($e && $item->cat_fie_type == 'select') ? 'selected' : '')?> value="select">Select Box</option>
							<option <?=(($e && $item->cat_fie_type == 'checkbox') ? 'selected' : '')?> value="checkbox">Checkboxs</option>
						</select>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Obrigatório</label>
						<select class="form-control" name="required">
							<option <?=(($e && $item->cat_fie_required == '0') ? 'selected' : '')?> value="0">Não</option>
							<option <?=(($e && $item->cat_fie_required == '1') ? 'selected' : '')?> value="1">Sim</option>
						</select>
					</div>
				</div>
			</div>

			<div class="fields-box">
				<div class="item <?=(($e && $item->cat_fie_type == 'text') ? 'active' : '')?>" data-type="text">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Placeholder</label>
								<input type="text" class="form-control" name="text_placeholder" value="<?=(($e) ? $item->cat_fie_placeholder : '')?>">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Máscara</label>
								<select class="form-control" name="text_mask">
									<option <?=(($e && $item->cat_fie_text_mask == '') ? 'selected' : '')?> value="">Nenhuma</option>
									<option <?=(($e && $item->cat_fie_text_mask == 'phone') ? 'selected' : '')?> value="phone">Telefone</option>
									<option <?=(($e && $item->cat_fie_text_mask == 'price') ? 'selected' : '')?> value="price">Preço</option>
									<option <?=(($e && $item->cat_fie_text_mask == 'cep') ? 'selected' : '')?> value="cep">CEP</option>
									<option <?=(($e && $item->cat_fie_text_mask == 'cpf') ? 'selected' : '')?> value="cpf">CPF</option>
								</select>
							</div>
						</div>
					</div>
				</div>

				<div class="item <?=(($e && $item->cat_fie_type == 'textarea') ? 'active' : '')?>" data-type="textarea">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Placeholder</label>
								<input type="text" class="form-control" name="textarea_placeholder" value="<?=(($e) ? $item->cat_fie_placeholder : '')?>">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Altura</label>
								<input type="number" class="form-control" name="textarea_rows" value="<?=(($e) ? $item->cat_fie_textarea_rows : '6')?>">
							</div>
						</div>
					</div>
				</div>

				<div class="item <?=(($e && $item->cat_fie_type == 'select') ? 'active' : '')?>" data-type="select">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Opções</label><small>(Cada opção em uma linha)</small>
								<textarea class="form-control" name="select_options" rows="7"><?=(($e) ? $item->cat_fie_select_options : '')?></textarea>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label>Opção Padrão</label>
								<input type="text" class="form-control" name="select_default" value="<?=(($e) ? $item->cat_fie_select_default : 'Selecione uma opção...')?>">
							</div>
						</div>
					</div>
				</div>

				<div class="item <?=(($e && $item->cat_fie_type == 'checkbox') ? 'active' : '')?>" data-type="checkbox">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Opções</label><small>(Cada opção em uma linha)</small>
								<textarea class="form-control" name="checkbox_options" rows="7"><?=(($e) ? $item->cat_fie_checkbox_options : '')?></textarea>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<a href="<?=base_url('categories/fields/'.(($e) ? $item->ads_cat_id : $code))?>" class="btn btn-default btn-lg">Cancelar</a>
					<button type="submit" class="btn btn-primary btn-lg">Salvar</button>
				</div>
			</div>
		</form>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$("#cf-type").on('change', function(event) {
			var value = $(this).val();

			$(".fields-box .item").removeClass('active');
			$(".fields-box .item[data-type='"+value+"']").addClass('active');
		});
	});
</script>