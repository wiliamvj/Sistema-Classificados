<div class="row">
	<div class="col-md-8">
		<h1>Painel / Usuários</h1>
	</div>
	<div class="col-md-4" align="right">
		<div class="btn-group btn-group-lg" role="group">
			<a href="<?=base_url('system/users_insert/')?>" class="btn btn-primary">Adicionar Novo</a>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th align="center">ID</th>
					<th>Login</th>
					<th>E-mail</th>
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
							<td align="center">'.$item->adm_use_id.'</td>
							<td>'.$item->adm_use_login.'</td>
							<td>'.$item->adm_use_email.'</td>
							<td align="center">'.status($item->adm_use_status).'</td>
							<td align="center">
								<div class="btn-group" role="group">
									<a href="'.base_url('system/users_edit/'.$item->adm_use_id).'" title="Editar" class="btn btn-primary"><i class="fa fa-fw fa-edit"></i></a>
						';

						if($this->session->userdata('login') != $item->adm_use_id){
							echo '<a href="#" data-toggle="modal" data-modal="'.base_url('system/users_delete/modal/'.$item->adm_use_id).'" data-target="#modal" title="Apagar" class="btn btn-danger modal-open"><i class="fa fa-fw fa-close"></i></a>';
						}

						echo '
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