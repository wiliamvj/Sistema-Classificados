<script>
    $(function(){
    var jElement = $('#fixo-categoria');
    var tam = $(window).width();
   
    if(tam < 1300){
        $(".medium-6 columns").show();
    }else{
        $(window).scroll(function(){
        if ( $(this).scrollTop() > 1860){
            jElement.css({
                'position':'fixed',
                'top':'83px',
                'width': '266px',
            });
        }else{
            jElement.css({
                'position':'static',
                'top':'auto'
            });
        }
    });
    }
    
    });
</script>
<!-- 
    ############################################
    ##### desenvolvido por wiliamvj.com.br ##### 
    ############################################
-->
<div class="row">
    <div class="medium-4 large-3 columns">
        <button type="button" class="show-for-small-only" id="show-filtros">Exibir Filtros</button>
        <div class="ads-sidebar hide-for-small-only" id="mobile-filtros">
            <div class="as-search hide-for-small-only">
                <div class="input-group">

                    <input class="input-group-field" type="text"  onkeyup="if (event.keyCode == 13 || event.which == 13) {
                                filtroAnuncio('<?php echo base_url(); ?>anuncios/?search=' + this.value);
                            }" id="as-s-input" placeholder="Procure pelo nome..." value="<?php echo (strlen($_GET['search']) > 0) ? $_GET['search'] : ''; ?>">

                    <div class="input-group-button">
                        <button type="button" onclick="filtroAnuncio('<?php echo base_url(); ?>anuncios/?search=' + document.getElementById('as-s-input').value);" class="btn btn-primary btn-just-icon" id="as-s-button"><i class="fa fa-search"></i></button>
                    </div>

                </div>
            </div>
            <div id="fixo-categoria">
            <a id="top_ads"></a>
            <!------ box categorias -------->
            <div class="as-box">
                <div class="as-b-title">buscar por categorias</div>
                <div class="as-b-content">
                    <ul class="as-b-categories" id="as-b-categories">
                        <?php
                        if ($categories) {
                            foreach ($categories as $key => $cat) {
                                ?>
                                <li>
                                    <a href="javascript:void(0);" onclick="filtroAnuncio('<?php echo base_url() . 'anuncios/?categoria=' . $cat->ads_cat_id; ?>&estado=<?php echo $_GET['estado']; ?>&preco=<?php echo $_GET['preco']; ?>&tipo=<?php echo $_GET['tipo']; ?>&search=<?php echo $_GET['search']; ?>&estado_nome=<?php echo $_GET['estado_nome']; ?>&regiao=<?php echo $_GET['regiao']; ?>&cidade=<?php echo $_GET['cidade']; ?>');"  <?php echo (((int) $_GET['categoria'] == $cat->ads_cat_id) ? 'class="active"' : ''); ?> >
                                        <span><i class="fa <?php echo $cat->ads_cat_icon; ?>"></i></span>
                                        <span><?php echo $cat->ads_cat_name; ?></span>
                                    </a>
                                </li>
                                <?php
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>
            </div>
            <!-- box localidade -->
            <div class="as-box" class="hide-for-small-only" id="mobile-regiao">
                <div class="as-b-title">onde você está?</div>
                <div class="as-b-content">
                    <!-- estado -->
                    <div class="as-item">
                        <div id="title-filter" class="titulo_filtro"></div>
                        <span id="janela_estado">
                            <select id="estado"  onchange="filtroAnuncio('<?php echo base_url(); ?>anuncios/?estado=' + this.value + '&estado_nome=' + this.options[selectedIndex].id + '&categoria=<?php echo $_GET['categoria']; ?>&preco=<?php echo $_GET['preco']; ?>&tipo=<?php echo $_GET['tipo']; ?>&search=<?php echo $_GET['search']; ?>');" >
                                <option value="">Todo o brasil<?php echo $this->ads_model->totalAnuncio(array()); ?></option>
                                <?php
                                if (count($estado) > 0) {
                                    foreach ($estado as $e) { 
                                        ?>
                                        <option value="<?php echo $e->sta_id; ?>" id="<?php echo $e->sta_name ?>"  <?php echo selected($e->sta_id, $_GET['estado']) ;?>><?php echo $e->sta_name; ?><?php echo ($_GET['estado'] == $e->sta_id and $this->ads_model->totalAnuncio(array('ad_state' => $e->sta_id), TRUE) > 0) ? '' : $this->ads_model->totalAnuncio(array('ad_state' => $e->sta_id)); ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </span>
                    </div>
                    <!-- regiao -->
                    <div class="as-item">
                        <div id="title-filter" class="titulo_filtro"></div>
                        <span id="janela_regiao">
                            <select id="regiao" onchange="filtroAnuncio('<?php echo base_url(); ?>anuncios/?regiao=' + this.value + '&estado=<?php echo $_GET['estado']; ?>&estado_nome=<?php echo $_GET['estado_nome']; ?>&categoria=<?php echo $_GET['categoria']; ?>&preco=<?php echo $_GET['preco']; ?>&tipo=<?php echo $_GET['tipo']; ?>&search=<?php echo $_GET['search']; ?>');" <?php echo disabilita('estado_nome'); ?>>
                                <option value="">Todas as Regiões</option>
                                <?php
                                if (count($regiao['regions']) > 0) {
                                    foreach ($regiao['regions'] as $e) {
                                        ?>
                                        <option value="<?php echo $e['region_id']; ?>" <?php
                                        echo selected($e['region_id'], $_GET['regiao']);
                                        echo ($this->ads_model->totalAnuncio(array('ad_region' => $e['region_id']), TRUE) > 0) ? '' : 'disabled="disabled"';
                                        ?>><?php echo $e['name']; ?><?php echo ($_GET['regiao'] == $e['region_id']) ? '' : $this->ads_model->totalAnuncio(array('ad_region' => $e['region_id'])); ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                            </select>
                        </span>
                    </div>
                    <!-- cidade -->
                    <div class="as-item">
                        <div id="title-filter" class="titulo_filtro"></div>
                        <span id="janela_cidade">

                            <select  id="cidade" onchange="filtroAnuncio('<?php echo base_url(); ?>anuncios/?cidade=' + this.value + '&regiao=<?php echo $_GET['regiao']; ?>&estado=<?php echo $_GET['estado']; ?>&estado_nome=<?php echo $_GET['estado_nome']; ?>&categoria=<?php echo $_GET['categoria']; ?>&preco=<?php echo $_GET['preco']; ?>&tipo=<?php echo $_GET['tipo']; ?>&search=<?php echo $_GET['search']; ?>');"  <?php echo disabilita('regiao'); ?>>
                                <option value="">Todas as Cidades</option>
                                <?php
                                if (count($cidade) > 0) {
                                    foreach ($cidade as $e) {
                                        ?>
                                        <option value="<?php echo $e->cit_id; ?>" <?php
                                        echo selected($e->cit_id, $_GET['cidade']);
                                        echo ($this->ads_model->totalAnuncio(array('ad_city' => $e->cit_id), TRUE) > 0) ? '' : 'disabled="disabled"';
                                        ?>><?php echo $e->cit_name; ?><?php echo ($_GET['cidade'] == $e->cit_id) ? '' : $this->ads_model->totalAnuncio(array('ad_city' => $e->cit_id)); ?></option>
                                                <?php
                                            }
                                        }
                                    ?>
                            </select>
                        </span>
                    </div>
                </div>
            </div>
            <div class="as-box">
                <div class="as-b-title">filtrar por preço</div>
                <div class="as-b-content">
                    <ul class="as-b-options">
                        <li data-value="0"  onclick="filtroAnuncio('<?php echo base_url() . 'anuncios/?preco='; ?>&categoria=<?php echo $_GET['categoria']; ?>&estado=<?php echo $_GET['estado']; ?>&tipo=<?php echo $_GET['tipo']; ?>&search=<?php echo $_GET['search']; ?>&estado_nome=<?php echo $_GET['estado_nome']; ?>&regiao=<?php echo $_GET['regiao']; ?>&cidade=<?php echo $_GET['cidade']; ?>');" <?php echo ($_GET['preco'] == '') ? 'class="active"' : ''; ?>>Todos os preços</li>
                        <li data-value="1_50" onclick="filtroAnuncio('<?php echo base_url() . 'anuncios/?preco=1_50'; ?>&categoria=<?php echo $_GET['categoria']; ?>&estado=<?php echo $_GET['estado']; ?>&tipo=<?php echo $_GET['tipo']; ?>&search=<?php echo $_GET['search']; ?>&estado_nome=<?php echo $_GET['estado_nome']; ?>&regiao=<?php echo $_GET['regiao']; ?>&cidade=<?php echo $_GET['cidade']; ?>');" <?php echo ($_GET['preco'] == '1_50') ? 'class="active"' : ''; ?>>R$ 1 - R$ 50</li>
                        <li data-value="51_150" onclick="filtroAnuncio('<?php echo base_url() . 'anuncios/?preco=51_150'; ?>&categoria=<?php echo $_GET['categoria']; ?>&estado=<?php echo $_GET['estado']; ?>&tipo=<?php echo $_GET['tipo']; ?>&search=<?php echo $_GET['search']; ?>&estado_nome=<?php echo $_GET['estado_nome']; ?>&regiao=<?php echo $_GET['regiao']; ?>&cidade=<?php echo $_GET['cidade']; ?>');" <?php echo ($_GET['preco'] == '51_150') ? 'class="active"' : ''; ?>>R$ 51 - R$ 150</li>
                        <li data-value="151_300" onclick="filtroAnuncio('<?php echo base_url() . 'anuncios/?preco=151_300'; ?>&categoria=<?php echo $_GET['categoria']; ?>&estado=<?php echo $_GET['estado']; ?>&tipo=<?php echo $_GET['tipo']; ?>&search=<?php echo $_GET['search']; ?>&estado_nome=<?php echo $_GET['estado_nome']; ?>&regiao=<?php echo $_GET['regiao']; ?>&cidade=<?php echo $_GET['cidade']; ?>');" <?php echo ($_GET['preco'] == '151_300') ? 'class="active"' : ''; ?>>R$ 151 - R$ 300</li>
                        <li data-value="301_800" onclick="filtroAnuncio('<?php echo base_url() . 'anuncios/?preco=301_800'; ?>&categoria=<?php echo $_GET['categoria']; ?>&estado=<?php echo $_GET['estado']; ?>&tipo=<?php echo $_GET['tipo']; ?>&search=<?php echo $_GET['search']; ?>&estado_nome=<?php echo $_GET['estado_nome']; ?>&regiao=<?php echo $_GET['regiao']; ?>&cidade=<?php echo $_GET['cidade']; ?>');" <?php echo ($_GET['preco'] == '301_800') ? 'class="active"' : ''; ?>>R$ 301 - R$ 800</li>
                        <li data-value="801_10000000000" onclick="filtroAnuncio('<?php echo base_url() . 'anuncios/?preco=801_10000000000'; ?>&categoria=<?php echo $_GET['categoria']; ?>&estado=<?php echo $_GET['estado']; ?>&tipo=<?php echo $_GET['tipo']; ?>&search=<?php echo $_GET['search']; ?>&estado_nome=<?php echo $_GET['estado_nome']; ?>&regiao=<?php echo $_GET['regiao']; ?>&cidade=<?php echo $_GET['cidade']; ?>');" <?php echo ($_GET['preco'] == '801_10000000000') ? 'class="active"' : ''; ?>>R$ 801 - R$ ~</li>
                    </ul>
                </div>
            </div>
            <div class="as-box">
                <div class="as-b-title">filtrar por tipo</div>
                <div class="as-b-content">
                    <ul class="as-b-options" id="as-b-type">
                        <li data-value="all" onclick="filtroAnuncio('<?php echo base_url() . 'anuncios/?tipo=all'; ?>&estado=<?php echo $_GET['estado']; ?>&preco=<?php echo $_GET['preco']; ?>&categoria=<?php echo $_GET['categoria']; ?>&search=<?php echo $_GET['search']; ?>&estado_nome=<?php echo $_GET['estado_nome']; ?>&regiao=<?php echo $_GET['regiao']; ?>&cidade=<?php echo $_GET['cidade']; ?>');" <?php echo ($_GET['tipo'] == '') ? 'class="active"' : ''; ?>>Todos</li>
                        <li data-value="service" onclick="filtroAnuncio('<?php echo base_url() . 'anuncios/?tipo=service'; ?>&estado=<?php echo $_GET['estado']; ?>&preco=<?php echo $_GET['preco']; ?>&categoria=<?php echo $_GET['categoria']; ?>&search=<?php echo $_GET['search']; ?>&estado_nome=<?php echo $_GET['estado_nome']; ?>&regiao=<?php echo $_GET['regiao']; ?>&cidade=<?php echo $_GET['cidade']; ?>');" <?php echo ($_GET['tipo'] == 'service') ? 'class="active"' : ''; ?>>Apenas Serviços</li>
                        <li data-value="trade" onclick="filtroAnuncio('<?php echo base_url() . 'anuncios/?tipo=trade'; ?>&estado=<?php echo $_GET['estado']; ?>&preco=<?php echo $_GET['preco']; ?>&categoria=<?php echo $_GET['categoria']; ?>&search=<?php echo $_GET['search']; ?>&estado_nome=<?php echo $_GET['estado_nome']; ?>&regiao=<?php echo $_GET['regiao']; ?>&cidade=<?php echo $_GET['cidade']; ?>');" <?php echo ($_GET['tipo'] == 'trade') ? 'class="active"' : ''; ?>>Aceita Troca</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="hide-for-small-only"><?= $this->main_model->advertisingBox('side', '266px', '600px') ?></div>
    </div>
    <div class="medium-8 large-9 columns">
        <div class="ads-filter">
            <div class="af-l"></div>
            <div class="af-r">
                <a href="<?= base_url('anuncios') ?>" class="btn btn-primary btn-padding-small btn-font-small">Limpar Filtros <i class="fa fa-times" aria-hidden="true"></i></a> 
            </div>
        </div>

        <?= $this->main_model->advertisingBox('top', '100%', '90px') ?>
        <?php
        if ($ads) {
            echo '<div class="ads-listing" id="ads-listing">';
            foreach ($ads as $key => $ad) {
                echo $this->ads_model->ads_item($ad);
            }
            echo '</div>';
            echo '<div class="pagination-box"></div>';
        } else {
            echo '<div class="ads-listing" id="ads-listing">';
            echo '<div align="center"><strong>Opss!<br>Nenhum anúncio encontrado!
            <br>
            Tente buscar uma palavra diferente, ou use os filtros!</strong></div>';
            echo '</div>';
        } 
        echo paginacao()->exibirPaginacao(paginacao()->getPagina(), paginacao()->getTotalPagina($total), 'anuncios', $total, false);
        ?>
    </div>
</div>
<script src="<?= base_url('assets/js/custom/select2.min.js') ?>"></script>
<script>
    $(".shophover").hover(function() {
    $(this).find('h3').css("text-decoration", "underline");

}, function() {
    $(this).find('h3').css("text-decoration", "none");
});

</script>
<script type="text/javascript">
    if (!isMobile()) {
        $('#estado').select2();
        $('#regiao').select2();
        $('#cidade').select2();
    }
        if (isMobile()) {
            $('.e').css('width', '100%');
        }
</script>