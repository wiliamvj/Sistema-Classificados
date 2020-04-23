<!-- 
    ############################################
    ##### desenvolvido por wiliamvj.com.br ##### 
    ############################################
-->
<div class="row">
    <div class="medium-3 large-3 columns">
        <?php include_once('shops_sidebar.php'); ?>

        <div class="hide-for-small-only">
		<?=$this->main_model->advertisingBox('side', '266px', '600px')?>
		</div>
    </div>
    <div class="medium-9 large-9 columns">
        <?= $this->main_model->advertisingBox('top', '100%', '90px') ?>

        <div class="ads-shops">
            <?php
            if ($shops) {
                foreach ($shops as $key => $shop) {
                    echo $this->shops_model->shop_item($shop);
                }
            } else {
                echo '<div align="center"><strong>Opss!<br>Nenhuma loja encontrada!
            <br>
            Tente buscar uma palavra diferente, ou use os filtros!</strong></div>';
            }
            echo paginacao()->exibirPaginacao(paginacao()->getPagina(), paginacao()->getTotalPagina($total), 'lojas', $total, FALSE);
            ?>
        </div>
        
    </div>
</div>
<script>
    $(".shopshover").hover(function() {
    
    $(this).find('h3').css("text-decoration", "underline");

}, function() {
     $(this).find('h3').css("text-decoration", "none");
});

</script>