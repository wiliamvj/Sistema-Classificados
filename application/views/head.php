<!doctype html>
<?php
/* Login Verify */
if ($this->session->userdata('login')) {
    $user = $this->user_model->info();
}

/* Config */
$config = $this->main_model->config();

/* SEO */
$site_name = ((@$seo_title) ? $seo_title . " - " . $config->cfg_seo_title : $config->cfg_seo_title);
$current_url = base_url($_SERVER[REQUEST_URI]);

/* Maintenance */
$maintenance = $config->cfg_maintenance;
if ($maintenance && ( $_SERVER['REMOTE_ADDR'] != $maintenance ) && (CURRENT_PAGE != "manutencao")) {
    header("location:" . base_url('manutencao'));
}
?>

<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title><?= $site_name ?></title>

<!-- 
    ############################################
    ##### desenvolvido por wiliamvj.com.br ##### 
    ############################################
-->

<!-- meta tags -->
<meta name="description" content="<?= $config->cfg_seo_desc ?>">
<meta name="keywords" content="<?= $config->cfg_seo_keywords ?>">
<meta name="author" content="<?= $config->cfg_seo_title ?>">
<meta name="google-site-verification" content="oOELG0VwXLw9xuL-ZIzFE3P1CJV8ztFfTOVFb4yqwMU" />

<!-- og tags -->
<meta property="og:title" content="<?= $site_name ?>">
<meta property="og:url" content="<?= $current_url ?>">
<meta property="og:site_name" content="<?= $config->cfg_seo_title ?>">
<meta property="og:description" content="<?= $config->cfg_seo_desc ?>">
<meta property="fb:app_id" content="317733798566075">
<meta property="og:type" content="website">

<link rel="shortcut icon" type="image/png" href="<?= base_url('assets/img/favicon.png') ?>" />

<!-- css -->
<link rel="stylesheet" href="<?= base_url('assets/font-awesome/css/font-awesome.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/foundation.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/jquery.sidr.dark.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/owl-carousel/owl.carousel.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/tooltipster/dist/css/tooltipster.bundle.min.css') ?>">      
<link rel="stylesheet" href="<?= base_url('assets/css/app.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/filter.app.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/chat.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/chat_box.css') ?>">
<link href="<?= base_url('assets/css/select2.min.css') ?>" rel="stylesheet" />

<!-- font -->
<link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap" rel="stylesheet">
				
<!-- js -->
<script src="<?= base_url('assets/js/vendor/jquery.js') ?>"></script>
<script src="<?= base_url('assets/js/vendor/bootstrap.min.js') ?>"></script>
<script src="<?= base_url('assets/js/vendor/jquery.scrollUp.js') ?>"></script>
<script src="<?= base_url('assets/js/vendor/pace.min.js') ?>"></script>
<script src="<?= base_url('assets/js/vendor/what-input.js') ?>"></script>
<script src="<?= base_url('assets/js/vendor/foundation.min.js') ?>"></script>
<script src="<?= base_url('assets/js/vendor/foneMascara.js') ?>"></script>
<script src="<?= base_url('assets/js/vendor/jquery.mask.min.js') ?>"></script>
<script src="<?= base_url('assets/js/vendor/jquery.sidr.min.js') ?>"></script>
<script src="<?= base_url('assets/owl-carousel/owl.carousel.min.js') ?>"></script>
<script src="<?= base_url('assets/js/vendor/jquery.paginate.js') ?>"></script>
<script src="<?= base_url('assets/tooltipster/dist/js/tooltipster.bundle.min.js') ?>"></script>
<script src="<?= base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/js/app.js') ?>"></script>

<script type="text/javascript">

    function mudaPagina(url) {
        window.location = '<?php echo base_url(); ?>' + url;
    }

    function loadingPaginacao(pagina, janela) {
        $("#carregandoJanela_" + janela).show();
        setTimeout(function() {
            $("#janela_" + janela).load(pagina);
            $("#carregandoJanela_" + janela).hide();

            $('html, body').scrollTop(0);
        }, 1000);
    }


    function filtroAnuncio(url) {
        window.location = url;
    }

    function filtrarPor(pagina, janela) {
        $("#carregandoJanela_" + janela).show();

        setTimeout(function() {
            $("#janela_" + janela).load(pagina);
            $("#carregandoJanela_" + janela).hide();

            $('html, body').scrollTop(0);
        }, 1000);
    }
</script>

