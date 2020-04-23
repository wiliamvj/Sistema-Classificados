<div class="row">
    <div class="col-md-8">
        <h1>Anúncios</h1>
    </div>
    <div class="col-md-4" align="right">
        <div class="btn-group btn-group-lg" role="group">
            <button type="button" id="a-aprovar-anuncios" class="btn btn-success">Aprovar Anúncios</button>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <?php  paginacao()->filtro('app/ajax', TRUE); ?>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th align="center">ID</th>
                    <th>Título</th>
                    <th>Usuário</th>
                    <th>Categoria</th>
                    <th align="center">Localização</th>
                    <th align="center">Data e Hora</th>
                    <th align="center">Visualizações</th>
                    <th align="center">Status</th>
                    <th align="center">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($listing) {
                    foreach ($listing as $key => $item) {
                        $user = $this->panamerico_model->details('users', 'use_id', $item->use_id);
                        $category_secondary = $this->panamerico_model->details('ads_categories', 'ads_cat_id', $item->ads_cat_id);
                        $category_primary = $this->panamerico_model->details('ads_categories', 'ads_cat_id', $category_secondary->ads_cat_parent);

                        $link = str_replace('admin.', '', base_url('anuncio/' . $item->ad_slug));

                        if ($item->ad_use_info) {
                            $city = $this->panamerico_model->details('cities', 'cit_id', $user->use_city);
                            $state = $this->panamerico_model->details('states', 'sta_id', $user->use_state);
                        } else {
                            $city = $this->panamerico_model->details('cities', 'cit_id', $item->ad_city);
                            $state = $this->panamerico_model->details('states', 'sta_id', $item->ad_state);
                        }

                        echo '
						<tr>
							<td align="center">' . $item->ad_id . '</td>
							<td>
								<strong>' . $item->ad_name . ' ' . (($item->ad_status == 2) ? '<a target="_blank" title="Abrir anúncio" href="' . $link . '"><i class="fa fa-external-link"></i></a>' : '') . '</strong>
								<br>
								<span>' . (($item->ad_service) ? 'Serviço' : string_money($item->ad_price) . (($item->ad_trade) ? ' | Aceito Troca' : '')) . '</span>
							</td>
							<td>' . $user->use_name . '</td>
							<td>' . $category_primary->ads_cat_name . ' <i class="fa fa-angle-right" aria-hidden="true"></i> ' . $category_secondary->ads_cat_name . '</td>
							<td align="center">' . ((@$city->cit_name && @$state->sta_initials) ? $city->cit_name . ' - ' . $state->sta_initials : '-') . '</td>
							<td align="center">' . string_date_time($item->ad_timestamp) . '</td>
							<td align="center">' . $item->ad_visits . '</td>
							<td align="center">' . ads_status($item->ad_status) . '</td>
							<td align="center" width="150">
								<div class="btn-group" role="group">
									' . (($item->ad_status == 1) ? '<button type="button" data-toggle="modal" data-modal="' . base_url('ads/approve/modal/' . $item->ad_id) . '" data-target="#modal" class="btn btn-success"><i class="fa fa-fw fa-thumbs-up"></i></button>' : '') . '
									<a href="' . base_url('ads/edit/' . $item->ad_id) . '" title="Editar" class="btn btn-primary"><i class="fa fa-fw fa-edit"></i></a>
									<button type="button" data-toggle="modal" data-modal="' . base_url('ads/delete/modal/' . $item->ad_id) . '" data-target="#modal" class="btn btn-danger"><i class="fa fa-fw fa-close"></i></button>
								</div>
							</td>
						</tr>
						';
                    }
                } else {
                    echo no_results();
                }
                ?>
            </tbody>
        </table>

        <?php //echo getInfoRegistro(); ?>

        <nav class='text-center'>
            <?php  paginacao()->exibirPaginacao(paginacao()->getPagina(), paginacao()->getTotalPagina($total), 'app/ajax', $total, TRUE); ?>
        </nav>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $("#a-aprovar-anuncios").on('click', function(event) {
            $("#DataTables_Table_0_filter input[type='search']").val('Aprovação Pendente');
            $("#DataTables_Table_0_filter input[type='search']").keyup();
        });
    });
</script>