<div class="row">
	<div class="col-md-8">
		<h1>Visualizar Usuário</h1>
	</div>
	<div class="col-md-4" align="right">
		<div class="btn-group btn-group-lg" role="group">
			<a href="<?=base_url('users')?>" class="btn btn-default">Voltar</a>
			<a href="<?=base_url('users/edit/'.$item->use_id)?>" class="btn btn-primary">Editar</a>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<table class="table table-bordered">
			<tr>
				<td><strong>Nome</strong></td>
				<td><?=$item->use_name?></td>
				<td><strong>Status</strong></td>
				<td><?=Status($item->use_status)?></td>
			</tr>
			<tr>
				<td><strong>E-mail</strong></td>
				<td><?=$item->use_email?>&nbsp;<i data-link="<?=$item->use_email?>" class="fa fa-fw fa-clipboard copy-link" style="cursor:pointer;"></i></td>

				<!-- <td><strong>CPF</strong></td> -->
				<!-- <td><?=$item->use_cpf?></td> -->
			</tr>
			<tr>
				<td><strong>Telefone</strong></td>
				<td><?=$item->use_phone?></td>
				<td><strong>Celular</strong></td>
				<td><?=$item->use_celular?></td>
			</tr>
			<tr>
				<td><strong>WhatsApp</strong></td>
				<td><?=$item->use_whatsapp?></td>
				<td><strong>Website</strong></td>
				<td><?=$item->use_website?></td>
			</tr>
			<tr>
				<td><strong>Facebook</strong></td>
				<td><?=$item->use_facebook?></td>
				<td><strong>Instagram</strong></td>
				<td><?=$item->use_instagram?></td>
			</tr>
			<tr>
				<td><strong>Mercado Livre</strong></td>
				<td><?=$item->use_mercado_livre?></td>
				<td><strong>Elo7</strong></td>
				<td><?=$item->use_elo7?></td>
			</tr>
			<tr>
				<td><strong>CEP</strong></td>
				<td colspan="3"><?=$item->use_cep?></td>
			</tr>
			<tr>
				<td><strong>Endereço</strong></td>
				<td><?=$item->use_address?></td>
				<td><strong>Complemento</strong></td>
				<td><?=$item->use_address?></td>
			</tr>
			<tr>
				<td><strong>Cidade</strong></td>
				<td>
					<?php
						if($item->use_city){
							$city = $this->panamerico_model->details('cities', 'cit_id', $item->use_city);

							echo $city->cit_name;
						}
					?>
				</td>
				<td><strong>Estado</strong></td>
				<td>
					<?php
						if($item->use_state){
							$state = $this->panamerico_model->details('states', 'sta_id', $item->use_state);

							echo $state->sta_name;
						}
					?>
				</td>
			</tr>
			<tr>
				<td><strong>Facebook ID</strong></td>
				<td><?=$item->use_facebook_id?></td>
				<td><strong>Data de Registro</strong></td>
				<td><?=string_date_time($item->use_date_register)?></td>
			</tr>
			<tr>
				<td><strong>Último Login</strong></td>
				<td><?=string_date_time($item->use_date_login)?></td>
				<td><strong>Último IP</strong></td>
				<td><?=$item->use_last_ip?></td>
			</tr>
		</table>

		<br>

		<h3>Anúncios do Usuário</h3>

		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th align="center">ID</th>
					<th>Título</th>
					<th>Categoria</th>
					<th>Localização</th>
					<th align="center">Data e Hora</th>
					<th align="center">Visualizações</th>
					<th align="center">Status</th>
					<th align="center">Ações</th>
				</tr>
			</thead>
			<tbody>
			<?php 
				if($ads){
					foreach ($ads as $key => $item) {
						$user = $this->panamerico_model->details('users', 'use_id', $item->use_id);
						$category_secondary = $this->panamerico_model->details('ads_categories', 'ads_cat_id', $item->ads_cat_id);
						$category_primary = $this->panamerico_model->details('ads_categories', 'ads_cat_id', $category_secondary->ads_cat_parent);

						if($item->ad_use_info){
							$city = $this->panamerico_model->details('cities', 'cit_id', $user->use_city);
							$state = $this->panamerico_model->details('states', 'sta_id', $user->use_state);
						}else{
							$city = $this->panamerico_model->details('cities', 'cit_id', $item->ad_city);
							$state = $this->panamerico_model->details('states', 'sta_id', $item->ad_state);
						}

						echo '
						<tr>
							<td align="center">'.$item->ad_id.'</td>
							<td>
								<strong>'.$item->ad_name.'</strong>
								<br>
								<span>'.(($item->ad_service) ? 'Serviço' : string_money($item->ad_price).(($item->ad_trade) ? ' | Aceito Troca' : '')).'</span>
							</td>
							<td>'.$category_primary->ads_cat_name.' <i class="fa fa-angle-right" aria-hidden="true"></i> '.$category_secondary->ads_cat_name.'</td>
							<td>'.$city->cit_name.' - '.$state->sta_initials.'</td>
							<td align="center">'.string_date_time($item->ad_timestamp).'</td>
							<td align="center">'.$item->ad_visits.'</td>
							<td align="center">'.ads_status($item->ad_status).'</td>
							<td align="center" width="150">
								<div class="btn-group" role="group">
									'.(($item->ad_status == 1) ? '<button type="button" class="btn btn-success"><i class="fa fa-fw fa-thumbs-up"></i></button>' : '').'
									<a href="'.base_url('ads/edit/'.$item->ad_id).'" title="Editar" class="btn btn-primary"><i class="fa fa-fw fa-edit"></i></a>
									<button type="button" data-toggle="modal" data-modal="'.base_url('ads/delete/modal/'.$item->ad_id).'" data-target="#modal" class="btn btn-danger"><i class="fa fa-fw fa-close"></i></button>
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