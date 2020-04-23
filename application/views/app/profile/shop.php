<link href="<?= base_url('assets/css/tabs.css') ?>" rel="stylesheet" />
<div class="profile-shop">
    <?php if (isMobile() === TRUE) { ?>
    <div class="ps-tabs">
        <div data-tab="shop" class="active"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Minha Loja</div>
        <div data-tab="edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar Loja</div>
    </div>
    <div class="ps-content">
        <div data-tab="shop" class="active">
            <?php
            echo $this->shops_model->shop_page($shop, true);
            ?>
        </div>
        <div data-tab="edit">
            <?php $this->load->view('app/profile/editShop', $shop);?>
        </div>
    </div>
    <?php } ?> 
    
    
    <?php if (isMobile() === FALSE) { ?>
        <div style="background: #fff; float: left; width: 100%;">
            <ul class="mnav mnav-tabs" style="float: left; width: 100%;">
                <li class="active"><a data-toggle="tab" href="#minhaLoja"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Minha Loja</a></li>
                <li><a data-toggle="tab" href="#editarLoja"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar Loja</a></li>
            </ul>

            <div class="tab-contente" style="float: left; width: 100%;">
                <div id="minhaLoja" class="tab-panes fade in active">
                    <div class="content" style="border: none; display: block !important; padding: 20px; width: 100%;"><!-- content -->
                        <?php echo $this->shops_model->shop_page($shop, true); ?>
                    </div>

                </div>
                <div id="editarLoja" class="tab-panes fade">
                    <div class="content" style="border: none; display: block !important; padding: 20px; width: 100%;"><!-- content -->
                        <?php $this->load->view('app/profile/editShop', $shop);?>
                    </div>

                </div>
            </div>
        </div>
    <?php } ?>
    
    
</div>
<script>
    $('#ai-use-info').change(function(){
        if($(this).is(':checked')){
            $('#sc-cep').prop('disabled', true);
            $('#sc-state').prop('disabled', true);
            $('#sc-region').prop('disabled', true);
            $('#sc-city').prop('disabled', true);
        }else{
            $('#sc-cep').prop('disabled', false);
            $('#sc-state').prop('disabled', false);
            $('#sc-region').prop('disabled', false);
            $('#sc-city').prop('disabled', false);
        }
    });
</script>
<script>
    $(".shophover").hover(function() {
    $(this).find('h3').css("text-decoration", "underline");

}, function() {
    $(this).find('h3').css("text-decoration", "none");
});

</script>
<script src="<?= base_url('assets/js/custom/profile_shop.js') ?>"></script>