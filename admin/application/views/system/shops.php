<div class="row">
	<div class="col-md-12">
		<h1>Lojas</h1>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
            <?php  paginacao()->filtro('shops', FALSE); ?>
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th align="center">ID</th>
					<th>Nome da Loja</th>
					<th>Descrição</th>
					<th>Usuário</th>
					<th>Categoria</th>
					<th align="center">Anúncios</th>
					<th align="center">Data e Hora</th>
					<th align="center">Status</th>
					<th align="center">Ações</th>
				</tr>
			</thead>
			<tbody>
			<?php 
				if($listing){
					foreach ($listing as $key => $item) {
						$user = $this->panamerico_model->details('users', 'use_id', $item->use_id);
						$category = $this->panamerico_model->details('ads_categories', 'ads_cat_id', $item->ads_cat_id);
						$ads = $this->panamerico_model->countAdsByUser($item->use_id);
						$link = str_replace('admin.', '', base_url('loja/'.$item->shop_slug));

						echo '
						<tr>
							<td align="center">'.$item->shop_id.'</td>
							<td>
								<strong>'.$item->shop_name.'</strong>
								<br>
								<span>
									<a href="'.$link.'" target="_blank"> Ver loja <i class="fa fa-external-link"></i></a>
								</span>
							</td>
							<td width="400">'.resume($item->shop_desc, 140).'</td>
							<td>'.$user->use_name.'</td>
							<td>'.$category->ads_cat_name.'</td>
							<td align="center">'.$ads.'</td>
							<td align="center">'.string_date_time($item->shop_date_update).'</td>
							<td align="center">'.status($item->shop_status).'</td>
							<td align="center">
								<div class="btn-group" role="group">
									<a href="'.base_url('shops/edit/'.$item->shop_id).'" title="Editar" class="btn btn-primary"><i class="fa fa-fw fa-edit"></i></a>
									<button type="button" data-toggle="modal" data-modal="'.base_url('shops/delete/modal/'.$item->shop_id).'" data-target="#modal" title="Apagar" class="btn btn-danger"><i class="fa fa-fw fa-close"></i></button>
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
            <?php  paginacao()->exibirPaginacao(paginacao()->getPagina(), paginacao()->getTotalPagina($total), 'shops', $total, FALSE); ?>
	</div>
</div>