<div class="row">
	<div class="col-md-12">
		<h1>Editar Página</h1>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<form action="<?=base_url('pages/save')?>" enctype="multipart/form-data" method="POST" accept-charset="utf-8">
			<input type="hidden" name="e" value="<?=(($e) ? $item->page_id : '')?>">

			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Nome</label>
						<input type="text" class="form-control" name="name" value="<?=(($e) ? $item->page_name : '')?>">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>URL Amigável</label>
						<input type="text" class="form-control" name="slug" value="<?=(($e) ? $item->page_slug : '')?>">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Ícone</label>
						<input type="text" class="form-control" name="icon" value="<?=(($e) ? $item->page_icon : '')?>">
						<small><a href="http://fontawesome.io/icons/" target="_blank">http://fontawesome.io/icons/</a></small>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Status</label>
						<select class="form-control" name="status">
							<option <?=(($e && $item->page_status == '1') ? 'selected' : '')?> value="1">Ativado</option>
							<option <?=(($e && $item->page_status == '0') ? 'selected' : '')?> value="0">Desativado</option>
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>Conteúdo</label>
						<textarea class="form-control" id="textarea-editor" rows="10" name="content"><?=(($e) ? $item->page_content : '')?></textarea>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="faq-box">
						<button type="button" id="fb-add" class="btn btn-success">Adicionar Pergunta e Resposta</button>

						<div class="fb-listing">
							<?php
								if($e && $faq){
									foreach ($faq as $key => $f) {
										echo '<div class="item"><div class="h"><button type="button" class="btn btn-danger btn-remove">Remover</button></div><div class="c"><input type="text" class="form-control" required name="faq_q[]" placeholder="Pergunta" value="'.$f->page_faq_question.'"><textarea required class="form-control" rows="5" name="faq_a[]" placeholder="Resposta">'.$f->page_faq_answer.'</textarea></div></div>';
									}
								}
							?>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<a href="<?=base_url('pages')?>" class="btn btn-default btn-lg">Cancelar</a>
					<button type="submit" class="btn btn-primary btn-lg">Salvar</button>
				</div>
			</div>
		</form>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$(".faq-box").on('click', '#fb-add', function(event) {
			var box = $(this).parent('.faq-box');
			var item = '<div class="item"><div class="h"><button type="button" class="btn btn-danger btn-remove">Remover</button></div><div class="c"><input type="text" class="form-control" required name="faq_q[]" placeholder="Pergunta"><textarea required class="form-control" rows="5" name="faq_a[]" placeholder="Resposta"></textarea></div></div>';
			var listing = box.children('.fb-listing');

			listing.append(item);
		});

		$(".faq-box").on('click', '.btn-remove', function(event) {
			var item = $(this).parent('.h').parent('.item');
			var box = item.parent('.faq-box');

			item.remove();
		});
	});
</script>