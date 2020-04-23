<form method="POST" action="<?=base_url('ads/report/'.$code.'/send')?>" class="form form-simple">
	<div class="row">
		<div class="hide-for-small-only medium-2 columns">
			<label class="text-right middle">Nome:<span class="required">*</span></label>
		</div>
		<div class="small-12 medium-9 columns">
			<label class="show-for-small-only">Nome:<span class="required">*</span></label>
			<input type="text" required name="name" placeholder="Seu nome" value="<?=$this->user_model->info('use_name')?>">
		</div>
	</div>
	<div class="row">
		<div class="hide-for-small-only medium-2 columns">
			<label class="text-right middle">Motivo:<span class="required">*</span></label>
		</div>
		<div class="small-12 medium-9 columns">
			<label class="show-for-small-only">Motivo:<span class="required">*</span></label>
			<input type="text" required name="reason" placeholder="Motivo da denúncia">
		</div>
	</div>
	<div class="row">
		<div class="hide-for-small-only medium-2 columns">
			<label class="text-right middle">Denúncia:<span class="required">*</span></label>
		</div>
		<div class="small-12 medium-9 columns">
			<label class="show-for-small-only">Denúncia:<span class="required">*</span></label>
			<textarea name="text" placeholder="Explique sua denúncia" style="height: 200px;" required></textarea>
		</div>
	</div>

	<div id="login-return"></div>

	<div class="divider divider-m-top-none"></div>

	<div class="row">
		<div class="small-12 columns text-right">
			<button type="button" class="btn btn-link modal-close"><i class="fa fa-times" aria-hidden="true"></i>Cancelar</button>
			<button type="submit" class="btn btn-primary"><i class="fa fa-send"></i>Enviar</button>
		</div>
	</div>
</form>