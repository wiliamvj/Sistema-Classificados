<div class="row">
	<div class="col-md-12">
		<h1>Retornos</h1>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
             <?php  paginacao()->filtro('returns', FALSE); ?>
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th align="center">ID</th>
					<th>Slug</th>
					<th>Tipo</th>
					<th align="center">Ícone</th>
					<th>Texto</th>
					<th align="center">Ações</th>
				</tr>
			</thead>
			<tbody>
			<?php 
				if($listing){
					foreach ($listing as $key => $item) {
						echo '
						<tr>
							<td align="center">'.$item->ret_id.'</td>
							<td>'.$item->ret_name.'</td>
							<td>'.$item->ret_type.'</td>
							<td align="center"><i class="fa fa-fw '.$item->ret_icon.'"></i></td>
							<td>'.$item->ret_text.'</td>
							<td align="center">
								<div class="btn-group" role="group">
									<a href="'.base_url('returns/edit/'.$item->ret_id).'" title="Editar" class="btn btn-primary"><i class="fa fa-fw fa-edit"></i></a>
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
            <?php  paginacao()->exibirPaginacao(paginacao()->getPagina(), paginacao()->getTotalPagina($total), 'returns', $total, FALSE); ?>
	</div>
</div>