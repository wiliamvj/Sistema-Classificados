<div class="row">
	<div class="col-md-12">
		<h1>Upload de Imagem</h1>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="col-md-4">
			<form enctype="multipart/form-data" method="POST" accept-charset="utf-8" action="<?= base_url('images/insert'); ?>">
				<div class="form-group">
					<label>Imagem</label>
					<input class="form-control" style="height: auto;" name="file" type="file">
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-primary">Enviar</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<h1>Imagens</h1>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="images-box">
			<?php
				if($listing){
					foreach ($listing as $key => $item) {
						echo '
							<div class="ib-item">
								<button type="button" data-toggle="modal" data-modal="'.base_url('images/delete/modal/'.$item->ads_img_id).'" data-target="#modal" class="btn btn-danger btn-xs"><i class="fa fa-fw fa-close"></i></button>
								<div class="img_number">'.$item->ad_id.'</div>
								<a data-lightbox="images" href="'.base_url('uploads/ads/'.$item->ads_img_file).'">
									<img src="'.thumbnail($item->ads_img_file, 'ads', 200, 200).'">
								</a>
							</div>
						';
					}
				?>
		</div>
		<div style="text-align: center; margin-top: 60px;">
			<?php	
				echo $pagination;
			} ?>
		</div>
	</div>
</div>