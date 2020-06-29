<!doctype html>
<!-- 
    ############################################
    ##### desenvolvido por wiliamvj.com.br ##### 
    ############################################
-->
<html class="no-js" lang="pt-br" dir="ltr">
    <head>
        <?php include "head.php"; ?>        
    </head>
    <body id="corpo">
        <script>
            window.fbAsyncInit = function() {
                FB.init({
                    appId: 'Your ID',
                    xfbml: true,
                    version: 'v2.6'
                });
            };

            (function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) {
                    return;
                }
                js = d.createElement(s);
                js.id = id;
                js.src = "//connect.facebook.net/pt_BR/sdk.js";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
        </script>
        <style>
            ul#as-b-categories li:hover {
                background-color: #F5F5F5;
            }
            ul#as-b-categories a:hover {
                color: #000;
            }
            #as-b-categories .fa{ font-size: 30px;}
            .h-main-menu .fa{ font-size: 20px;}
        </style>
        <div id="black-wall"></div>

        <div id="container">
            <!-- header | begin -->
            <header>
                <div class="row">
                    <div class="small-12 medium-2 columns">
                        <a href="<?= base_url() ?>" class="h-logo" title="Panamérico">
                            <img src="<?= base_url('assets/img/logo.png') ?>" id="mobilelogo" alt="Panamérico">
                        </a>
                    </div>
                    <!-- campo busca menu -->
                    <div class="small-9 medium-4 columns" id="HmS">
                        <div class="as-search" id="homeSearch">
                            <div class="input-group">
                                <input class="input-group-field" type="text"  onkeyup="if (event.keyCode == 13 || event.which == 13) {
                                filtroAnuncio('<?php echo base_url(); ?>anuncios/?search=' + this.value);
                            }" id="as-s-input" placeholder="eiii!! busque um anúncio aqui" value="<?php echo (strlen($_GET['search']) > 0) ? $_GET['search'] : ''; ?>">
                            <div class="input-group-button">
                            <button type="button" onclick="filtroAnuncio('<?php echo base_url(); ?>anuncios/?search=' + document.getElementById('as-s-input').value);" class="btn btn-primary btn-just-icon" id="as-s-button"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </div>
                    </div>
                    <div class="small-3 medium-6 columns">
                      <nav class="h-main-menu">
                        <!--<div class="show-for-small-only" class="imgMenuMobile">
                            <img src="https://www.your-site.com.br/assets/img/logo.png" alt="Panamérico Classificados">
                        </div>-->
                            <ul>
                                <?php if ($this->session->userdata('login')) { ?>
                                    <li><a href="<?= base_url('cliente/painel') ?>"> oi, <?= first_name($user->use_name) ?></a></li>
                                    <li><a href="<?= base_url('chat') ?>">chat</a></li>
                                <?php } else { ?>
                                    <li><a href="#" data-modal="<?= base_url('register') ?>" class="modal-open"> 
                                    cadastrar</a></li>
                                    <li><a href="#" data-modal="<?= base_url('login') ?>" class="modal-open"> entrar</a></li>
                                    <!--<li><a href="#" data-modal="<?= base_url('login') ?>" class="modal-open">chat</a></li>-->
                                <?php } ?>
                                <li><a href="<?= base_url('anuncios') ?>"> anúncios</a></li>
                                <?php if ($this->session->userdata('login')) { ?>
                                    <li><a href="<?= base_url('ajuda/duvidas-frequentes') ?>">ajuda</a></li>
                                <?php } ?>

                                <li><a class="h-mm-lojas" href="<?= base_url('lojas') ?>"> lojas</a></li>

                                <?php if ($this->session->userdata('login')) { ?>
                                    <li><a class="h-mm-inserir" href="<?= base_url('anunciar') ?>">vender grátis</a></li>
                                <?php } else { ?>
                                    <li><a class="h-mm-inserir modal-open" href="#" data-modal="<?= base_url('login/required') ?>"> vender grátis</a></li>
                                <?php } ?>
                            </ul>
                        </nav>

                        <div id="menuMobile" class="h-mobile-menu">
                            <span><i class="fa fa-bars"></i></span>
                        </div>
                    </div>
                </div>
            </header>
            <!-- header | end -->

            <!-- section | begin -->
            <section class="app-section" id="janela_container">
                <?php
                include_once('returns.php');

                if (@$breadcrumbs) {
                    echo '
                     <div class="row hide-for-small-only">
                        <div class="medium-12 columns">
                           <div class="breadcrumbs">
                              <ul>
                                 <li><a href="' . base_url() . '">Início</a></li>
                  ';

                    foreach ($breadcrumbs as $key => $bc) {
                        echo '<li>' . ((@$bc['link']) ? '<a href="' . $bc['link'] . '" target="_self">' . $bc['name'] . '</a>' : $bc['name']) . '</li>';
                    }

                    echo '
                              </ul>
                           </div>
                        </div>
                     </div>
                  ';
                }

                echo $contents;
                ?>
            </section>
            <!-- section | end -->
                   
            <div class="hide-for-small-only">
                   
            <!-- footer | begin -->
            <footer>
                <div class="row">
                    <div class="medium-7 columns">
                        <nav class="f-main-menu">
                            <ul>
                                <li><a href="<?= base_url('depoimentos') ?>">Depoimentos</a></li><li>/</li>
                                <li><a href="<?= base_url('ajuda/duvidas-frequentes') ?>">Ajuda e Contato</a></li><li>/</li>
                                <li><a href="<?= base_url('ajuda/termos-de-uso') ?>">Termos e Privacidade</a></li><li>/</li>
                                <li><a href="<?= base_url('ajuda/quem-somos') ?>">Quem Somos</a></li>
                            </ul>
                        </nav>
                    </div>
                    <div class="medium-2 columns hide-for-small-only"><div class="fb-like" style="position: absolute;padding-top: 6px;" data-href="Your URL Facebook" data-layout="button_count" data-action="like" data-show-faces="true" data-share="false"></div></div>
                    <div class="medium-4 columns">
                        <ul class="f-socials">
                            <li><a href="<?= $config->cfg_social_facebook ?>" target="_blank" title="Facebook" class="f-s-facebook"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="<?= $config->cfg_social_twitter ?>" target="_blank" title="Twitter" class="f-s-twitter"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="<?= $config->cfg_social_linkedin ?>" target="_blank" title="Instagram" class="f-s-linkedin"><i class="fa fa-instagram"></i></a></li>
                        </ul>
                    </div>
                    <div class="dev">
                        <a target="_blank" href="https://wiliam.io">por Wiliam Joaquim</a><br />
                        <a target="_blank" href="https://github.com/wiliamvj/Sistema-Classificados"><i class="fa fa-github" style="font-size: 16px;"></i> Sistema Open Source</a>
                    </div>
                </div>
                
            </footer>
            </div>
            <!-- footer | end -->
        </div>

        <!-- modal | begin -->
        <div class="app-modal" id="app-modal">
            <div>
                <!-- modal content -->
            </div>
        </div>
        <!-- modal | end -->
        <style>
            #sidr{
                margin-top: 62px;
                border: 1px solid #ddd;
                padding: 4px;
                height: 100%;
            }
        </style>
        <script type="text/javascript" src="<?= base_url('assets/js/jquery.touchSwipe.min.js') ?>"></script>
        <script>
            $(function() {
                //delizamento do touch menu
                $("#sidr").swipe({
                    swipeRight: function(event, direction, distance, duration, fingerCount, fingerData) {
                        //if (direction == 'left' || direction == 'right') {
                            $('#black-wall').trigger('click');
                        //}

                    }
                });
            });
        </script>
        <!-- menu mobile - begin -->          
        <div id="sidr" style="right: 10px;"></div>
        <!-- menu mobile - end -->
    </body>

</html>
