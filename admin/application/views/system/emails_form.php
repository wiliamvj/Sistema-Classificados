<div class="row">
	<div class="col-md-12">
		<h1>Editar E-mail</h1>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<form action="<?=base_url('emails/save')?>" enctype="multipart/form-data" method="POST" accept-charset="utf-8">
			<input type="hidden" name="e" value="<?=(($e) ? $item->email_id : '')?>">

			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Título</label>
						<input type="text" class="form-control" name="name" disabled value="<?=(($e) ? $item->email_name : '')?>">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Status</label>
						<select class="form-control" disabled name="status">
							<option <?=(($e && $item->email_status == '1') ? 'selected' : '')?> value="1">Ativado</option>
							<option <?=(($e && $item->email_status == '0') ? 'selected' : '')?> value="0">Desativado</option>
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>Assunto</label>
						<input type="text" class="form-control" name="subject" required value="<?=(($e) ? $item->email_subject : '')?>">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>Conteúdo</label>
						<textarea rows="15" class="form-control" id="textarea-editor" name="content">
							<?=(($e) ? $item->email_content : '')?>
						</textarea>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading">Variáveis disponíveis para esse e-mail</div>
						<div class="panel-body">
							<ul>
								<?php
									foreach ($tags as $key => $t) {
										echo '<li><strong>'.$t->email_tag_name.':</strong> '.$t->email_tag_variable.'</li>';
									}
								?>	
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<a href="<?=base_url('emails')?>" class="btn btn-default btn-lg">Cancelar</a>
					<button type="submit" class="btn btn-primary btn-lg">Salvar</button>
				</div>
			</div>
		</form>
	</div>
</div>