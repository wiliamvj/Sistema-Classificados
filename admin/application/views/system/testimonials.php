<div class="row">
	<div class="col-md-12">
		<h1>Depoimentos</h1>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
             <?php  paginacao()->filtro('testimonials', FALSE); ?>
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th align="center">ID</th>
					<th>Nome</th>
					<th>Texto</th>
					<th align="center">Data e Hora</th>
					<th>Categoria</th>
					<th>Anúncio</th>
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
							<td align="center">'.$item->tes_id.'</td>
							<td>'.$item->tes_name.'</td>
							<td>'.$item->tes_text.'</td>
							<td align="center">'.string_date_time($item->tes_timestamp).'</td>
							<td>'.$item->tes_category.'</td>
							<td>'.$item->tes_ad.'</td>
							<td align="center">'.status($item->tes_status).'</td>
							<td align="center" width="150">
								<div class="btn-group" role="group">
						';

						if($item->tes_status == 2){
							echo '<button type="button" data-toggle="modal" data-modal="'.base_url('testimonials/approve/modal/'.$item->tes_id).'" data-target="#modal" class="btn btn-success"><i class="fa fa-fw fa-thumbs-up"></i></button>';
						}

						echo '
									<a href="'.base_url('testimonials/edit/'.$item->tes_id).'" title="Editar" class="btn btn-primary"><i class="fa fa-fw fa-edit"></i></a>
									<a href="#" data-toggle="modal" data-modal="'.base_url('testimonials/delete/modal/'.$item->tes_id).'" data-target="#modal" title="Apagar" class="btn btn-danger modal-open"><i class="fa fa-fw fa-close"></i></a>
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
            <?php  paginacao()->exibirPaginacao(paginacao()->getPagina(), paginacao()->getTotalPagina($total), 'testimonials', $total, FALSE); ?>
	</div>
</div>