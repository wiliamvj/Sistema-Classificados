<div class="row">
	<div class="col-md-12">
		<h1>Usuários</h1>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
             <?php  paginacao()->filtro('users', FALSE); ?>
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th align="center">ID</th>
					<th>Nome</th>
					<th>E-mail</th>
					<th align="center">Anúncios</th>
					<th align="center">Loja</th>
					<th align="center">Data de Registro</th>
					<th align="center">Último Acesso</th>
					<th align="center">Último Acesso</th>
					<th align="center">Status</th>
					<th align="center">Ações</th>
				</tr>
			</thead>
			<tbody>
			<?php 
		
				if($listing){
					foreach ($listing as $key => $item) {
						$ads = $this->panamerico_model->countAdsByUser($item->use_id);
						$shop = $this->panamerico_model->details("shops", 'use_id', $item->use_id);

						if(!empty($item->use_email)):
							//$emailCorte    = substr($data->use_email, 0, 20);
							if(strlen($item->use_email) <= 34){
								$emailLimitado = substr($item->use_email, 0, 34);		
							}else{
								$emailLimitado = substr($item->use_email, 0, 28)."...";
							}	
						
						else:
							$emailLimitado = "";
						endif;


						echo '
						<tr>
							<td align="center">'.$item->use_id.'</td>
							<td>'.$item->use_name.'</td>
							<td>'.$emailLimitado.'&nbsp;<i data-link="'.$item->use_email.'" class="fa fa-fw fa-clipboard copy-link" style="cursor:pointer;"></i></td>
							<td align="center">'.$ads.'</td>
							<td align="center">'.(($shop) ? 'Sim' : 'Não').'</td>
							<td align="center">'.string_date_time($item->use_date_register).'</td>
							<td align="center">'.string_date_time($item->use_date_login).'</td>
							<td align="center">'.$item->use_last_ip.'</td>
							<td align="center">'.status($item->use_status).'</td>
							<td align="center" width="150">
								<div class="btn-group" role="group">
									<a href="'.base_url('users/details/'.$item->use_id).'" title="Visualizar" class="btn btn-warning"><i class="fa fa-fw fa-eye"></i></a>
									<a href="'.base_url('users/edit/'.$item->use_id).'" title="Editar" class="btn btn-primary"><i class="fa fa-fw fa-edit"></i></a>
									<a href="#" data-toggle="modal" data-modal="'.base_url('users/delete/modal/'.$item->use_id).'" data-target="#modal" title="Apagar" class="btn btn-danger"><i class="fa fa-fw fa-close"></i></a>
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
            <?php  paginacao()->exibirPaginacao(paginacao()->getPagina(), paginacao()->getTotalPagina($total), 'users', $total, FALSE); ?>
	</div>
</div>