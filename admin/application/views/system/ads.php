<?php
if (!function_exists('selected')) {

    function selected($bd, $value) {
        if ($bd == $value) {
            return 'selected="selected"';
        }
    }

}
?>
<div class="row">
    <div class="col-md-8">
        <h1>Anúncios</h1>
    </div>
    <div class="col-md-4 hide" align="right">
        <div class="btn-group btn-group-lg" role="group">
            <button type="button" id="a-aprovar-anuncios" class="btn btn-success">Aprovar Anúncios</button>
        </div>
    </div>
</div>
<style>.nav-tabs>li>a{cursor: pointer;}</style>
<div class="row">
    <ul class="nav nav-tabs">
        <li <?php echo (!isset($_GET['status'])) ? 'class="active"' : ''; ?>><a data-toggle="tab" onclick="mudaPagina('ads');"><i class="fa fa-tags"></i> Todos</a></li>
        <li <?php echo ($_GET['status'] == '2') ? 'class="active"' : ''; ?>><a data-toggle="tab" onclick="mudaPagina('ads/?status=2');"><i class="fa fa-check"></i> Ativos</a></li>
        <li <?php echo ($_GET['status'] == '1') ? 'class="active"' : ''; ?>><a data-toggle="tab" onclick="mudaPagina('ads/?status=1');"><i class="fa fa-hourglass-half"></i> Aprovação pendente</a></li>
        <li <?php echo ($_GET['status'] == '3') ? 'class="active"' : ''; ?>><a data-toggle="tab" onclick="mudaPagina('ads/?status=3');"><i class="fa fa-pause"></i> Pausados</a></li>
        <li <?php echo ($_GET['status'] == '5') ? 'class="active"' : ''; ?>><a data-toggle="tab" onclick="mudaPagina('ads/?status=5');"><i class="fa fa-close"></i> Excluídos</a></li>
    </ul>
    <div class="tab-content">
        <div id="home" class="tab-pane fade in active">
            <div class="row" style="margin-top: 20px;">
                <div class="col-md-12">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper no-footer">
                        <div class="dataTables_length" id="DataTables_Table_0_length" style="width: 30%;"><label>Mostrar <select style="width: 20%;" onchange="mudaPagina('ads/?offset=' + this.value + '<?php echo ($_GET['status'] > 0) ? '&status=' . $_GET['status'] : null; ?>' + '<?php echo ($_GET['search'] > 0) ? '&search=' . $_GET['search'] : null; ?>');" name="DataTables_Table_0_length" aria-controls="DataTables_Table_0" class="form-control"><option value="50" <?php echo selected($_GET['offset'], 50); ?>>50</option><option value="100" <?php echo selected($_GET['offset'], 100); ?>>100</option><option value="200" <?php echo selected($_GET['offset'], 200); ?>>200</option><option value="300" <?php echo selected($_GET['offset'], 300); ?>>300</option></select> registros</label></div>
                        <div id="DataTables_Table_0_filter" class="dataTables_filter" style="width: 25%;"><label>Pesquisar:<input type="search" name="search" value="<?php echo $_GET['search']; ?>" onkeypress="if (event.keyCode == 13 || event.which == 13) {
                                    mudaPagina('ads/?search=' + this.value + '<?php echo ($_GET['status'] > 0) ? '&status=' . $_GET['status'] : null; ?>' + '<?php echo ($_GET['offset'] > 0) ? '&offset=' . $_GET['offset'] : null; ?>');
                                }" class="form-control" placeholder="Digite alguma coisa e aperte a tecla Enter" aria-controls="DataTables_Table_0"></label></div>
                        <div style="float:left">
                            <a href="javascript:void(0);" onclick="javascript:marcaTodosAds();" data-toggle="tooltip" title="Marcar Todos" data-placement="left" class="btn btn-default"><i class="fa fa-check-circle"></i> Marcar Todos</a>
                            <?php if ($_GET['status'] < 1) { ?>
                                &nbsp;<button type="button" data-toggle="modal" data-modal="<?php echo base_url(); ?>ads/modalStatus/3/Pausar/2" data-target="#modal" class="btn btn-warning"><i class="fa fa-pause"></i> Pausar</button>
                                &nbsp;<button type="button" data-toggle="modal" data-modal="<?php echo base_url(); ?>ads/modalStatus/2/Aprovar/1" data-target="#modal" class="btn btn-success"><i class="fa fa-thumbs-up"></i> Aprovar</button>
                                &nbsp;<button type="button" data-toggle="modal" data-modal="<?php echo base_url(); ?>ads/modalStatus/2/Reativar/5" data-target="#modal" class="btn btn-primary"><i class="fa fa-refresh"></i> Reativar</button>
                            <?php } elseif ($_GET['status'] == 2) { ?>
                                &nbsp;<button type="button" data-toggle="modal" data-modal="<?php echo base_url(); ?>ads/modalStatus/3/Pausar/<?php echo $_GET['status']; ?>" data-target="#modal" class="btn btn-info"><i class="fa fa-pause"></i> Pausar</button>
                            <?php } elseif ($_GET['status'] == 1) { ?>
                                &nbsp;<button type="button" data-toggle="modal" data-modal="<?php echo base_url(); ?>ads/modalStatus/2/Aprovar/<?php echo $_GET['status']; ?>" data-target="#modal" class="btn btn-success"><i class="fa fa-thumbs-up"></i> Aprovar</button>
                            <?php } elseif ($_GET['status'] == 3) { ?>
                                &nbsp;<button type="button" data-toggle="modal" data-modal="<?php echo base_url(); ?>ads/modalStatus/2/Ativar/<?php echo $_GET['status']; ?>" data-target="#modal" class="btn btn-success"><i class="fa fa-check"></i> Ativar</button>
                            <?php } elseif ($_GET['status'] == 5) { ?>
                                &nbsp;<button type="button" data-toggle="modal" data-modal="<?php echo base_url(); ?>ads/modalStatus/2/Reativar/<?php echo $_GET['status']; ?>" data-target="#modal" class="btn btn-info"><i class="fa fa-refresh"></i> Reativar</button>
                                &nbsp;<button type="button" data-toggle="modal" data-modal="<?php echo base_url(); ?>ads/modalStatus/0/Excluir Permanentemente/<?php echo $_GET['status']; ?>" data-target="#modal" class="btn btn-danger"><i class="fa fa-close"></i> Excluir Permanentemente</button>
                            <?php } if ($_GET['status'] == '' or $_GET['status'] != 5) { ?>
                                &nbsp;<button type="button" data-toggle="modal" data-modal="<?php echo base_url(); ?>ads/modalStatus/5/Excluir/<?php echo ($_GET['status'] > 0) ? $_GET['status'] : 0; ?>" data-target="#modal" class="btn btn-danger"><i class="fa fa-close"></i> Excluir</button>
                            <?php } ?>
                        </div>
                    </div>

                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th class="center"><input type="checkbox" id="todos" disabled="disabled"/></th>
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
                                                <td class="center"><input name="item_id[]" type="checkbox" class="idads" value="' . $item->ad_id . '"  /></td>
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
                                                                        '.(($item->ad_status == 1) ? '<button type="button" data-toggle="modal" data-modal="'.base_url('ads/approve/modal/'.$item->ad_id.'/?status='.$_GET['status']).'" data-target="#modal" class="btn btn-success"><i class="fa fa-fw fa-thumbs-up"></i></button>' : '').'
									<a href="' . base_url('ads/edit/' . $item->ad_id) . '" title="Editar" class="btn btn-primary"><i class="fa fa-fw fa-edit"></i></a>
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

                    <nav class='text-center'>
                        <?php paginacao()->exibirPaginacao(paginacao()->getPagina(), paginacao()->getTotalPagina($total), 'ads', $total, FALSE); ?>
                    </nav>
                </div>
            </div>
        </div>

    </div>
</div>

<script type="text/javascript">


    function marcaTodosAds() {
        $('.idads').each(function() {
            if ($(this).prop("checked")) {
                $(this).prop("checked", false);
            } else {
                $(this).prop("checked", true);
            }
        });
    }
    $(document).ready(function() {
        $("#a-aprovar-anuncios").on('click', function(event) {
            $("#DataTables_Table_0_filter input[type='search']").val('Aprovação Pendente');
            $("#DataTables_Table_0_filter input[type='search']").keyup();
        });
    }
    );

    function enviaForm(status_id, status_atual) {
        if (!$('input[type=checkbox]').is(':checked')) {
            alert('Selecione pelo menos um anúncio.');
        } else {
            verificaChecado(status_id, status_atual);
        }
    }

    function pegaIds() {
        var ids = '';
        // percorrer todos os elementos checados...
        $(".idads:checked").each(function() {
            //Verifica se checkbox está marcado
            if (this.checked) {
                //pegar os id do checkbox selecionado
                ids = ids + ', ' + this.value;
            }
        });
        return ids = ids.substr(1); //eleminar a primeira virgula (',')
    }

    function verificaChecado(status_id, status_atual)
    {
        var ids = pegaIds();
        var acao = 'ok';
        if (status_id == 0) {
            acao = 'excluir';
        }

        $.post('<?php echo base_url(); ?>ads/status', {ad_id: ids, status: status_id, status_atual: status_atual, acao: acao},
        function(dados)
        {
            if (dados != null && status_id > 0)
            {

                mudaPagina('ads/?status=' + status_id);

            } else if (status_id == 0) {
                mudaPagina('ads');
            }
        }, "json");


    }

    function acaoEmMassa(status_id, status_atual)
    {

        var acao = 'massa';
        if (status_id == 0 && status_atual == 5) {
            acao = 'excluirmassa';
        }

        if (confirm('Deseja executar ação em massa?')) {
            $.post('<?php echo base_url(); ?>ads/status', {status_id: status_id, status_atual: status_atual, acao: acao},
            function(dados)
            {
                if (dados != null && status_id > 0)
                {

                    mudaPagina('ads/?status=' + status_id);

                } else if (status_id == 0) {
                    mudaPagina('ads');
                }
            }, "json");
        }
    }



</script>