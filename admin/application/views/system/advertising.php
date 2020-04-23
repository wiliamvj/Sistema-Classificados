<div class="row">
	<div class="col-md-8">
		<h1>Publicidade<small>(Obrigatório o uso do anúncio "top", ou o site ficará quebrado!)</small></h1>
	</div>
	<div class="col-md-4" align="right">
		<div class="btn-group btn-group-lg" role="group">
			<a href="<?=base_url('advertising/insert')?>" class="btn btn-primary">Adicionar Novo</a>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
            <?php  paginacao()->filtro('advertising', FALSE); ?>
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th align="center">ID</th>
					<th>Nome</th>
					<th align="center">Posição</th>
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
							<td align="center">'.$item->adv_id.'</td>
							<td>'.$item->adv_name.'</td>
							<td align="center">'.$item->adv_position.'</td>
							<td align="center">'.string_date_time($item->adv_timestamp).'</td>
							<td align="center">'.status($item->adv_status).'</td>
							<td align="center">
								<div class="btn-group" role="group">
									<a href="'.base_url('advertising/edit/'.$item->adv_id).'" title="Editar" class="btn btn-primary"><i class="fa fa-fw fa-edit"></i></a>
									<button type="button" data-toggle="modal" data-modal="'.base_url('advertising/delete/modal/'.$item->adv_id).'" data-target="#modal" class="btn btn-danger"><i class="fa fa-fw fa-close"></i></button>
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
            <?php  paginacao()->exibirPaginacao(paginacao()->getPagina(), paginacao()->getTotalPagina($total), 'advertising', $total, FALSE); ?>
	</div>
</div>