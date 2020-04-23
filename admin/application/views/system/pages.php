<div class="row">
	<div class="col-md-8">
		<h1>Páginas</h1>
	</div>
	<div class="col-md-4" align="right">
		<div class="btn-group btn-group-lg" role="group">
			<a href="<?=base_url('pages/insert')?>" class="btn btn-primary">Adicionar Novo</a>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
               <?php  paginacao()->filtro('pages', FALSE); ?>
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th align="center">ID</th>
					<th>Título</th>
					<th>Link</th>
					<th align="center">Atualizado em</th>
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
							<td align="center">'.$item->page_id.'</td>
							<td>'.$item->page_name.'</td>
							<td><a target="_blank" title="Abrir página '.$item->page_name.'" href="'.str_replace('admin.', '', base_url('ajuda/'.$item->page_slug)).'">'.$item->page_slug.' <i class="fa fa-external-link"></i></a></td>
							<td align="center">'.string_date_time($item->page_timestamp).'</td>
							<td align="center">'.status($item->page_status).'</td>
							<td align="center">
								<div class="btn-group" role="group">
									<a href="'.base_url('pages/edit/'.$item->page_id).'" class="btn btn-primary"><i class="fa fa-fw fa-edit"></i></a>
									<button type="button" data-toggle="modal" data-modal="'.base_url('pages/delete/modal/'.$item->page_id).'" data-target="#modal" class="btn btn-danger"><i class="fa fa-fw fa-close"></i></button>
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
            <?php  paginacao()->exibirPaginacao(paginacao()->getPagina(), paginacao()->getTotalPagina($total), 'pages', $total, FALSE); ?>
	</div>
</div>