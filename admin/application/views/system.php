<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <?php include "head.php"; ?>

    </head>
    <body>
        <header style="margin-top: -20px;">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-2">
                        <a title="Seu Site" class="h-logo" href="<?= base_url() ?>">
                            <img src="<?= base_url('assets/img/logo.png') ?>" alt="Seu Site">
                        </a>
                    </div>
                    <div class="col-xs-4">
                        <div class="h-links">
                            <a href="https://your-site.com.br" class="btn btn-primary" target="_blank">Visitar Site</a>
                            
                        </div>
                    </div>
                    <div class="col-xs-6" align="right">
                        <div class="h-actions">
                            <div class="btn-group" role="group" aria-label="...">
                                <a href="<?= base_url('system/users_edit/' . $this->session->userdata('login')) ?>" class="btn btn-default">Minha Conta</a>
                                <a href="<?= base_url('system/users') ?>" class="btn btn-primary">Usuários</a>
                                <a href="<?= base_url('login/out') ?>" class="btn btn-danger">Sair</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <div class="app-container">
            <!-- 			<div class="ac-sidebar">
                                            <nav id="ac-s-menu">
                                                    <ul>
                                                            <li><a <?= ((CURRENT_PAGE == "ads") ? 'class="active"' : '') ?> href="<?= base_url('ads') ?>"><i class="fa fa-fw fa-tags"></i>Anúncios</a></li>
                                                            <li><a <?= ((CURRENT_PAGE == "categories") ? 'class="active"' : '') ?> href="<?= base_url('categories') ?>"><i class="fa fa-fw fa-folder"></i>Categorias</a></li>
                                                            <li><a <?= ((CURRENT_PAGE == "shops") ? 'class="active"' : '') ?> href="<?= base_url('shops') ?>"><i class="fa fa-fw fa-shopping-cart"></i>Lojas</a></li>
                                                            <li><a <?= ((CURRENT_PAGE == "users") ? 'class="active"' : '') ?> href="<?= base_url('users') ?>"><i class="fa fa-fw fa-users"></i>Usuários</a></li>
                                                            <li><a <?= ((CURRENT_PAGE == "images") ? 'class="active"' : '') ?> href="<?= base_url('images') ?>"><i class="fa fa-fw fa-image"></i>Imagens</a></li>
                                                            <li><a <?= ((CURRENT_PAGE == "emails") ? 'class="active"' : '') ?> href="<?= base_url('emails') ?>"><i class="fa fa-fw fa-envelope"></i>E-mails</a></li>
                                                            <li><a <?= ((CURRENT_PAGE == "pages") ? 'class="active"' : '') ?> href="<?= base_url('pages') ?>"><i class="fa fa-file-text"></i>Páginas</a></li>
                                                            <li><a <?= ((CURRENT_PAGE == "advertising") ? 'class="active"' : '') ?> href="<?= base_url('advertising') ?>"><i class="fa fa-fw fa-puzzle-piece"></i>Publicidade</a></li>
                                                            <li><a <?= ((CURRENT_PAGE == "returns") ? 'class="active"' : '') ?> href="<?= base_url('returns') ?>"><i class="fa fa-fw fa-undo"></i>Retornos</a></li>
                                                            <li><a <?= ((CURRENT_PAGE == "testimonials") ? 'class="active"' : '') ?> href="<?= base_url('testimonials') ?>"><i class="fa fa-fw fa-indent"></i>Depoimentos</a></li>
                                                            <li><a <?= ((CURRENT_PAGE == "system") ? 'class="active"' : '') ?> href="<?= base_url('system') ?>"><i class="fa fa-fw fa-cog"></i>Sistema</a></li>
                                                    </ul>
                                            </nav>
                                    </div> -->
            <div class="container" style="width: 100%; text-align: center; background-color: #f9f9fa; padding: 10px;">
                <nav id="ac-s-menu">	
                    <ul class="list-inline" style=" display: block; font-size: 17px; font-weight: bold;">
                        <li><a <?= ((CURRENT_PAGE == "ads") ? 'class="active"' : '') ?> href="<?= base_url('ads') ?>"><i class="fa fa-fw fa-tags"></i>Anúncios</a></li>
                        <li><a <?= ((CURRENT_PAGE == "categories") ? 'class="active"' : '') ?> href="<?= base_url('categories') ?>"><i class="fa fa-fw fa-folder"></i>Categorias</a></li>
                        <li><a <?= ((CURRENT_PAGE == "shops") ? 'class="active"' : '') ?> href="<?= base_url('shops') ?>"><i class="fa fa-fw fa-shopping-cart"></i> Lojas</a></li>
                        <li><a <?= ((CURRENT_PAGE == "users") ? 'class="active"' : '') ?> href="<?= base_url('users') ?>"><i class="fa fa-fw fa-users"></i> Usuários</a></li>
                        <li><a <?= ((CURRENT_PAGE == "images") ? 'class="active"' : '') ?> href="<?= base_url('images') ?>"><i class="fa fa-fw fa-image"></i> Imagens</a></li>
                        <li><a <?= ((CURRENT_PAGE == "emails") ? 'class="active"' : '') ?> href="<?= base_url('emails') ?>"><i class="fa fa-fw fa-envelope"></i> E-mails</a></li>
                        <li><a <?= ((CURRENT_PAGE == "pages") ? 'class="active"' : '') ?> href="<?= base_url('pages') ?>"><i class="fa fa-file-text"></i> Páginas</a></li>
                        <li><a <?= ((CURRENT_PAGE == "advertising") ? 'class="active"' : '') ?> href="<?= base_url('advertising') ?>"><i class="fa fa-fw fa-puzzle-piece"></i>Publicidade</a></li>
                        <li><a <?= ((CURRENT_PAGE == "returns") ? 'class="active"' : '') ?> href="<?= base_url('returns') ?>"><i class="fa fa-fw fa-undo"></i>Retornos</a></li>
                        <li><a <?= ((CURRENT_PAGE == "testimonials") ? 'class="active"' : '') ?> href="<?= base_url('testimonials') ?>"><i class="fa fa-fw fa-indent"></i>Depoimentos</a></li>
                        <li><a <?= ((CURRENT_PAGE == "system") ? 'class="active"' : '') ?> href="<?= base_url('system') ?>"><i class="fa fa-fw fa-cog"></i>Sistema</a></li>
                    </ul>
                </nav>
            </div>
            <div class="ac-content">
                <div class="container-fluid" id="janela_container">
                    
                    <?php
                    $return = $this->session->flashdata('return');

                    if ($return) {
                        if ($return == 'save') {
                            echo '<div class="alert alert-success" role="alert"><strong>Sucesso!</strong> Registro salvo com sucesso.</div>';
                        }

                        if ($return == 'delete') {
                            echo '<div class="alert alert-success" role="alert"><strong>Apagado!</strong> Registro apagado com sucesso.</div>';
                        }
                    }

                    echo $contents;
                    ?>
                </div>
            </div>
        </div>



        <!-- modal -->
        <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"></div>

        <!-- lightbox -->
        <link href="<?= base_url('assets/lightbox/dist/css/lightbox.min.css') ?>" rel="stylesheet">
        <script src="<?= base_url('assets/lightbox/dist/js/lightbox.min.js') ?>"></script>
        <script type="text/javascript">

            function loadingPaginacao(pagina, janela) {
                //$("#janela_" + janela).empty();
                $("#carregandoJanela_" + janela).show();

                setTimeout(function() {
                    $("#janela_" + janela).load(pagina);
                    $("#carregandoJanela_" + janela).hide();


                }, 1000);
            }

            function mudaPagina(url) {
                window.location = '<?php echo base_url(); ?>' + url;
            }
            
             
        </script>
    </body>
    <!-- Sistema desenvolvido por Wiliam Joaquim, sua distribuição não é autorizada! -->
</html>