<div class="row">
	<div class="col-md-8">
		<h1>Categorias</h1>
	</div>
	<div class="col-md-4" align="right">
		<div class="btn-group btn-group-lg" role="group">
			<a href="<?=base_url('categories/insert')?>" class="btn btn-primary">Adicionar Novo</a>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
            <?php  paginacao()->filtro('categories', FALSE); ?>
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th align="center">ID</th>
					<th>Nome</th>
					<th align="center">Ícone</th>
					<th align="center">Categorias</th>
					<th align="center">Status</th>
					<th align="center">Ações</th>
				</tr>
			</thead>
			<tbody>
			<?php 
				if($listing){
					foreach ($listing as $key => $item) {
						$categories = $this->panamerico_model->count('ads_categories', 'ads_cat_parent', $item->ads_cat_id);

						echo '
						<tr>
							<td align="center">'.$item->ads_cat_id.'</td>
							<td>'.$item->ads_cat_name.'</td>
							<td align="center"><i class="fa fa-fw '.$item->ads_cat_icon.'"></i></td>
							<td align="center">'.$categories.'</td>
							<td align="center">'.status($item->ads_cat_status).'</td>
							<td align="center">
								<div class="btn-group" role="group">
									<a href="'.base_url('categories/secondary/'.$item->ads_cat_id).'" title="Categorias" class="btn btn-warning"><i class="fa fa-fw fa-th-list"></i></a>
									<a href="'.base_url('categories/edit/'.$item->ads_cat_id).'" title="Editar" class="btn btn-primary"><i class="fa fa-fw fa-edit"></i></a>
									<button type="button" data-toggle="modal" data-modal="'.base_url('categories/delete/modal/'.$item->ads_cat_id).'" data-target="#modal" class="btn btn-danger"><i class="fa fa-fw fa-close"></i></button>
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
            <?php  paginacao()->exibirPaginacao(paginacao()->getPagina(), paginacao()->getTotalPagina($total), 'categories', $total, FALSE); ?>
	</div>
</div>