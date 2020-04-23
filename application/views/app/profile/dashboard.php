<link href="<?= base_url('assets/css/tabs.css') ?>" rel="stylesheet" />
<div class="profile-dashboard">
    <?php if (isMobile() === TRUE) { ?>
        <div class="pd-tabs">
            <div class="active" onclick="carregaPagina('<?php echo base_url() . 'profile/ads/'; ?>', 'interna');"><i class="fa fa-tags" aria-hidden="true"></i> todos</div>
            <div onclick="active(this);
                    carregaPagina('<?php echo base_url() . 'profile/ads/?status=1'; ?>', 'interna');"><i class="fa fa-hourglass-half" aria-hidden="true"></i> aprovação pendente</div>
            <div onclick="active(this);
                    carregaPagina('<?php echo base_url() . 'profile/ads/?status=3'; ?>', 'interna');"><i class="fa fa-pause" aria-hidden="true"></i> pausados</div>
            <div onclick="active(this);
                    carregaPagina('<?php echo base_url() . 'profile/ads/?status=2'; ?>', 'interna');"><i class="fa fa-check" aria-hidden="true"></i> ativos</div>
            <div style="display: none;" onclick="active(this);
                    carregaPagina('<?php echo base_url() . 'profile/ads/?status=4'; ?>', 'interna');"><i class="fa fa-money" aria-hidden="true"></i> vendidos</div>
        </div>
        <div class="pd-content" id="janela_interna"><!-- content -->

        </div>
    <?php } ?>
    <?php if (isMobile() === FALSE) { ?>
        <div style="background: #fff; float: left; width: 100%;">
            <ul class="mnav mnav-tabs" style="float: left; width: 100%;">
                <li class="active"><a data-toggle="tab" onclick="carregaPagina('<?php echo base_url() . 'profile/ads/'; ?>', 'interna');"> <i class="fa fa-tags"></i> todos</a></li>
                <li><a data-toggle="tab" onclick="active(this);
                        carregaPagina('<?php echo base_url() . 'profile/ads/?status=2'; ?>', 'interna');"><i class="fa fa-check"></i> ativos</a></li>
                <li><a data-toggle="tab" onclick="active(this);
                        carregaPagina('<?php echo base_url() . 'profile/ads/?status=3'; ?>', 'interna');"><i class="fa fa-pause"></i> pausados</a></li>
                <li><a data-toggle="tab" onclick="active(this);
                        carregaPagina('<?php echo base_url() . 'profile/ads/?status=1'; ?>', 'interna');"><i class="fa fa-hourglass-half"></i> aprovação pendente</a></li>
            </ul>

            <div class="tab-contente" style="float: left; width: 100%;">
                <div id="home" class="tab-panes fade in active">
                    <div class="pd-content" id="janela_interna" style="border: none; width: 100%;border-bottom: 1px solid #ddd;
    border-left: 1px solid #ddd;border-right: 1px solid #ddd"><!-- content -->


                    </div>

                </div>
            </div>
        </div>
    <?php } ?>
</div>
<script>
    function shopHover(){
    $(".shophover").hover(function() {
           $(this).find('h3').css("text-decoration", "underline");
    }, function() {
        $(this).find('h3').css("text-decoration", "none");
    });
    }
</script>
<script type="text/javascript">
    $(function() {
        carregaPagina('<?php echo base_url() . 'profile/ads/'; ?>', 'interna');
    });

    function active(obj) {
        $(".pd-tabs > div").removeClass('active');
        $(obj).addClass('active');
    }


    function carregaPagina(pagina, janela) {
        $("#janela_" + janela).empty();
        $("#janela_" + janela).html('<div id="carregandoJanela_interna" class="pd-c-loader"><i class="fa fa-spin fa-cog"></i></div>');
        $("#carregandoJanela_" + janela).show();
        setTimeout(function() {
            $("#janela_" + janela).load(pagina);
            $("#carregandoJanela_" + janela).hide();

            $('html, body').scrollTop(0);
        }, 1000);
    }
     
</script>
