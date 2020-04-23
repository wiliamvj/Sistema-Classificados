<div class="row">
	<div class="col-md-8">
		<h1>Anúncios / Áreas</h1>
	</div>
	<div class="col-md-4" align="right">
		<div class="btn-group btn-group-lg" role="group">
			<a href="<?=base_url('ads')?>" class="btn btn-default">Anúncios</a>
			<a href="<?=base_url('ads/areas_insert')?>" class="btn btn-primary">Adicionar Novo</a>
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
							<td align="center">'.$item->area_id.'</td>
							<td>'.$item->area_name.'</td>
							<td align="center">'.status($item->area_status).'</td>
							<td align="center">
								<div class="btn-group" role="group">
									<a href="'.base_url('ads/areas_edit/'.$item->area_id).'" title="Editar" class="btn btn-primary"><i class="fa fa-fw fa-edit"></i></a>
									<button type="button" data-toggle="modal" data-modal="'.base_url('ads/areas_delete/modal/'.$item->area_id).'" data-target="#modal" class="btn btn-danger"><i class="fa fa-fw fa-close"></i></button>
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