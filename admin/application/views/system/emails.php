<div class="row">
	<div class="col-md-12">
		<h1>E-mails</h1>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
             <?php  paginacao()->filtro('emails', FALSE); ?>
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th align="center">ID</th>
					<th>Título</th>
					<th>Assunto</th>
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
							<td align="center">'.$item->email_id.'</td>
							<td>'.$item->email_name.'</td>
							<td>'.$item->email_subject.'</td>
							<td align="center">'.string_date_time($item->email_timestamp).'</td>
							<td align="center">'.status($item->email_status).'</td>
							<td align="center">
								<div class="btn-group" role="group">
									<a href="'.base_url('emails/edit/'.$item->email_id).'" class="btn btn-primary"><i class="fa fa-fw fa-edit"></i></a>
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
            <?php  paginacao()->exibirPaginacao(paginacao()->getPagina(), paginacao()->getTotalPagina($total), 'emails', $total, FALSE); ?>
	</div>
</div>