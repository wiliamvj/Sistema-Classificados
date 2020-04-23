<div class="row">
	<div class="col-md-8">
		<h1><?=$category->ads_cat_name?> / Campos Personalizados</h1>
	</div>
	<div class="col-md-4" align="right">
		<div class="btn-group btn-group-lg" role="group">
			<a href="<?=base_url('categories/secondary/'.$category->ads_cat_parent)?>" class="btn btn-default">Voltar</a>
			<a href="<?=base_url('categories/fields_insert/'.$category->ads_cat_id)?>" class="btn btn-primary">Adicionar Novo</a>
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
					<th align="center">Type</th>
					<th align="center">Data e Hora</th>
					<th align="center">Status</th>
					<th align="center">Ações</th>
				</tr>
			</thead>
			<tbody>
			<?php 
				if($listing){
					foreach ($listing as $key => $item) {
						echo '
						<tr>
							<td align="center">'.$item->cat_fie_id.'</td>
							<td>'.$item->cat_fie_name.'</td>
							<td align="center">'.$item->cat_fie_type.'</td>
							<td align="center">'.string_date_time($item->cat_fie_timestamp).'</td>
							<td align="center">'.status($item->cat_fie_status).'</td>
							<td align="center">
								<div class="btn-group" role="group">
									<a href="'.base_url('categories/fields_edit/'.$item->cat_fie_id).'" title="Editar" class="btn btn-primary"><i class="fa fa-fw fa-edit"></i></a>
									<button type="button" data-toggle="modal" data-modal="'.base_url('categories/fields_delete/modal/'.$item->cat_fie_id.'/'.$category->ads_cat_id).'" data-target="#modal" class="btn btn-danger"><i class="fa fa-fw fa-close"></i></button>
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