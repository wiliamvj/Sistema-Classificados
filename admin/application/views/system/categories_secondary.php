<div class="row">
	<div class="col-md-8">
		<h1>Categorias / <?=$primary->ads_cat_name?></h1>
	</div>
	<div class="col-md-4" align="right">
		<div class="btn-group btn-group-lg" role="group">
			<a href="<?=base_url('categories')?>" class="btn btn-default">Voltar</a>
			<a href="<?=base_url('categories/secondary_insert/'.$code)?>" class="btn btn-primary">Adicionar Novo</a>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<table class="table table-striped table-bordered table-order">
			<thead>
				<tr>
					<th align="center">ID</th>
					<th>Nome</th>
					<th align="center">Anúncios</th>
					<th align="center">Campos</th>
					<th align="center">Status</th>
					<th align="center">Ações</th>
				</tr>
			</thead>
			<tbody>
			<?php 
				if($listing){
					foreach ($listing as $key => $item) {
						$ads = $this->panamerico_model->count('ads', 'ads_cat_id', $item->ads_cat_id);
						$fields = $this->panamerico_model->count('categories_fields', 'ads_cat_id', $item->ads_cat_id);;

						echo '
						<tr>
							<td align="center">'.$item->ads_cat_id.'</td>
							<td>'.$item->ads_cat_name.'</td>
							<td align="center">'.$ads.'</td>
							<td align="center">'.$fields.'</td>
							<td align="center">'.status($item->ads_cat_status).'</td>
							<td align="center">
								<div class="btn-group" role="group">
									<a href="'.base_url('categories/fields/'.$item->ads_cat_id).'" title="Campos Personalizados" class="btn btn-warning"><i class="fa fa-fw fa-sliders"></i></a>
									<a href="'.base_url('categories/secondary_edit/'.$item->ads_cat_id).'" title="Editar" class="btn btn-primary"><i class="fa fa-fw fa-edit"></i></a>
									<button type="button" data-toggle="modal" data-modal="'.base_url('categories/secondary_delete/modal/'.$item->ads_cat_id.'/'.$code).'" data-target="#modal" class="btn btn-danger"><i class="fa fa-fw fa-close"></i></button>
								</div>
							</td>
						</tr>
						';
					}
				}else{
					echo no_results();
				}
			?>
			</tbody>
		</table>
	</div>
</div>