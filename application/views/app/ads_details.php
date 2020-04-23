<script>
    $(function(){
    var jElement = $('#ads-inserir');
    var tam = $(window).width();
   
    if(tam <= 1024){
        $(".medium-6 columns").show();
    }else{
        $(window).scroll(function(){
        if ( $(this).scrollTop() > 1370 ){
            jElement.css({
                'position':'fixed',
                'top':'90px',
                'width': '350px',
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

<div class="row">
    <div class="medium-12 columns">
        <div class="ads-page">
            <div class="row">
                <div class="medium-8 columns">
                    <h1 class="ap-title"><?= descAnuncio($ad->ad_name); ?><?= (($ad->ad_verified) ? '<i class="fa fa-check-circle-o verify"></i>' : '') ?></h1>

                    <?php if ($images) { ?>

                        <div class="ap-images">
                            <div class="ap-i-master">
                                <?php
                                foreach ($images as $key => $image) {
                                    $w = 740;
                                    $h = 400;
                                    echo '<img data-image="' . $image->ads_img_id . '" class="img-item ' . (($key == 0) ? 'active' : '') . '" src="' . thumbnail(@$image->ads_img_file, "ads", $w, $h, 2) . '">';
                                }

                                if ($ad->ad_video):
                                    $url = $ad->ad_video;
                                    preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $url, $matches);
                                    $id = $matches[1];
                                    $width = '720px';
                                    $height = '400px';
                                    ?>
                                    <div class="flex-video img-item" data-image="video"><iframe id="ytplayer" type="text/html" width="<?php echo $width ?>" height="<?php echo $height ?>"
                                                                                                src="https://www.youtube.com/embed/<?php echo $id ?>?rel=0&showinfo=0&color=white&iv_load_policy=3"
                                                                                                frameborder="0" allowfullscreen></iframe></div>
                                        <?php
                                    endif;
                                    ?>
                            </div>

                            <?php if (count($images) > 1) { ?>

                                <div class="ap-i-controls">
                                    <div class="ap-ic-btn"><span id="ap-ic-prev"><i class="fa fa-chevron-left"></i></span></div>
                                    <div class="ap-ic-btn"><span id="ap-ic-next"><i class="fa fa-chevron-right"></i></span></div>
                                </div>
                                <div class="ap-i-slider" id="ap-i-slider">
                                    <?php
                                    foreach ($images as $key => $image) {
                                        echo '
                                        <div data-image="' . $image->ads_img_id . '" class="item">
                                            <img src="' . thumbnail(@$image->ads_img_file, "ads", 200, 150, 2) . '">
                                        </div>
                                    ';
                                    }
                                    if ($ad->ad_video):
                                        $yb_img = explode("=", $ad->ad_video);
                                        ?>
                                        <div data-image="video" class="item" style="background-image: url('http://i1.ytimg.com/vi/<?= $yb_img[1]; ?>/mqdefault.jpg');">
                                            <img src="https://www.your-site.com.br/assets/img/bg.png" style="opacity: 0;">
                                        </div>
                                        <?php
                                    endif;
                                    ?>
                                </div>

                            <?php } ?>
                        </div>

                    <?php }else { ?>

                        <div class="ap-images">
                            <div class="ap-i-master">
                                <img class="active" src="<?= thumbnail(false, false, 740, 400) ?>">
                            </div>
                        </div>

                    <?php } ?>

                    <div class="ap-desc">
                        <h3 id="show-descri-js">Descrição <small class="show-for-small-only" style="font-size: 10px;"><i class="fa fa-eye" aria-hidden="true"></i> Exibir descrição</small></h3>
                        <p class="hide-for-small-only" id="mobile-descri-js"><?= (($ad->ad_desc) ? descAnuncio($ad->ad_desc) : 'Esse anúncio não possui uma descrição.') ?></p>
                        

                        <br>

                        <h3 id="show-detalhes-js">Detalhes <small class="show-for-small-only" style="font-size: 10px;"><i class="fa fa-eye" aria-hidden="true"></i> Exibir detalhes</small></h3>
                        <div class="hide-for-small-only" id="mobile-detalhes-js">
                            <div class="row"><div style="margin-top: 10px;" class="small-12 medium-12 large-12 end columns"><i class="fa fa-square" style="font-size: 12px;color: #2CC17B;margin-right: 7px;" aria-hidden="true"></i><strong>Publicado em:</strong> <?= string_date_time($ad->ad_timestamp) ?></div></div>
                            <div class="row"><div style="margin-top: 10px;" class="small-12 medium-12 large-12 end columns"><i class="fa fa-square" style="font-size: 12px;color: #2CC17B;margin-right: 7px;" aria-hidden="true"></i><strong>Categoria:</strong> <?= $category_parent->ads_cat_name . ' <i class="fa fa-angle-right" aria-hidden="true"></i> ' . $ad->ads_cat_name ?></div></div>
                            <div class="row"><div style="margin-top: 10px;" class="small-12 medium-12 large-12 end columns"><i class="fa fa-square" style="font-size: 12px;color: #2CC17B;margin-right: 7px;" aria-hidden="true"></i><strong>ID do Anúncio:</strong> <?= $ad->ad_id ?></div></div>

                            <?php
                            if ($custom_fields) {

                                foreach ($custom_fields as $key => $cf) {
                                    
                                    $value = $cf->ads_cus_value;

                                    if ($cf->cat_fie_type == "textarea") {
                                        $value = nl2br($cf->ads_cus_value);
                                    }

                                    if ($cf->cat_fie_type == "select") {
                                        $option = $this->ads_model->customSelectOption($cf->ads_cus_value);

                                        $value = @$option->sel_opt_name;
                                    }


                                    if ($cf->cat_fie_type == "checkbox") {
                                        $options = $this->ads_model->customCheckboxOption($ad->ad_id, $cf->cat_fie_id);
                                        $value = "";

                                        if ($options) {
                                            $value .= '<div class="row">';

                                            foreach ($options as $key => $option) {
                                                $value .= '<div class="small-12 medium-6 large-6 end columns">' . $option->che_opt_name . '</div>';
                                            }

                                            $value .= '</div>';
                                        }
                                    }

                                    if ($value) {
                                        echo '<div class="row"><div style="margin-top: 10px;" class="small-12 medium-12 large-12 end columns"><i class="fa fa-square" style="font-size: 12px;margin-right: 7px; color: #2CC17B;" aria-hidden="true"></i><strong>' . $cf->cat_fie_name . ':</strong> ' . mudaCor($cf->cat_fie_name, $value) . '</div></div>
                                            ';
                                    }
                                }
                            }
                            ?>

                            <h3 style="margin-top: 10px;">Endereço</h3>
                            <div class="row">
                                <?= ($cep) ? ('<div class="small-12 medium-6 large-6 end columns"><i class="fa fa-square" style="font-size: 12px;color: #2CC17B;margin-right: 7px;" aria-hidden="true"></i><strong>CEP: </strong>' . $cep . '</div>') : ('') ?>
                                <?= ($state) ? ('<div class="small-12 medium-6 large-6 end columns"><i class="fa fa-square" style="font-size: 12px;color: #2CC17B;margin-right: 7px;" aria-hidden="true"></i><strong>Estado: </strong>' . $state . '</div>') : ('') ?>
                                <?= ($region) ? ('<div class="small-12 medium-6 large-6 end columns"><i class="fa fa-square" style="font-size: 12px;color: #2CC17B;margin-right: 7px;" aria-hidden="true"></i><strong>Região: </strong>' . $region . '</div>') : ('') ?>
                                <?= ($city) ? ('<div class="small-12 medium-6 large-6 end columns"><i class="fa fa-square" style="font-size: 12px;color: #2CC17B;margin-right: 7px;" aria-hidden="true"></i><strong>Município: </strong>' . $city . '</div>') : ('') ?>
                                <?= ($neighborhood) ? ('<div class="small-12 medium-6 large-6 end columns"><i class="fa fa-square" style="font-size: 12px;color: #2CC17B;margin-right: 7px;" aria-hidden="true"></i><strong>Bairro: </strong>' . $neighborhood . '</div>') : ('') ?>
                                <?= ($address) ? ('<div class="small-12 medium-6 large-6 end columns"><i class="fa fa-square" style="font-size: 12px;color: #2CC17B;margin-right: 7px;" aria-hidden="true"></i><strong>Endereço: </strong>' . $address . '</div>') : ('') ?>

                            </div>
                        </div>
                    </div>

                    <?php
                    
                    function descAnuncio($str){
                        if(strlen($str) >= 40){
                            $string = explode(' ', $str);
                            if(count($string) == 1){
                                return substr($str, 0, 40).'...';
                            }
                            
                            return nl2br($str);
                        }
                        
                        return nl2br($str);
                    }
                    
                    function mudaCor($nome, $value){
                        $aspa = "'";
                        $http = 'http://';
                        if($nome != 'URL'){
                            return str_replace('<div class="small-12 medium-6 large-6 end columns">', '<div class="small-12 medium-6 large-6 end columns"><i class="fa fa-circle" style="font-size: 12px;color: #ccc;margin-right: 7px;" aria-hidden="true"></i> ', $value);
                        }else if($nome == 'URL'){
                            return ' <a href="'.$http.str_replace('https://','',$value).'" style="color:blue;" target="_blank">'.$value.'</a>';
                           
                        }
                        return $value;
                        
                    }
                    
                    if ($related) {
                        echo '
                            <div class="row">
                                <div class="medium-12 columns">
                                    <div class="ap-ads-related">
                                        <h2>Anúncios Relacionados</h2>
                                        <div class="row">
                            ';

                        foreach ($related as $key => $rel) {
                            $related_images = $this->ads_model->images($rel->ad_id);
                            $related_image = thumbnail(@$related_images[0]->ads_img_file, "ads", 260, 180, 2);

                            $textoCorte = substr($rel->ad_name, 0, 25);
                            $textoLimitado = substr($textoCorte, 0, strrpos($textoCorte, ' '));

                            echo '
                                    <div class="small-6 medium-3 end columns">
                                        <a href="' . base_url('anuncio/' . $rel->ad_slug) . '" title="' . $rel->ad_name . '" class="item">
                                            <div class="image"><img alt="' . $rel->ad_name . '" src="' . $related_image . '"></div>

                                            <h4>' . $textoLimitado . '<br> Ver mais</h4>

                                            <div class="price">' . (($rel->ad_service) ? 'Serviço' : string_money($rel->ad_price)) . '</div>
                                        </a>
                                    </div>
                                ';
                        }
                        echo '
                                        </div>
                                    </div>  
                                </div>
                            </div>
                            ';
                    }
                    ?>

                   
                </div>
                <div class="medium-4 columns">
                    <div class="ap-price"><?= getDescAds($ad, $category_parent->ads_cat_id); ?></div>

                    <?= (($ad->ad_trade) ? '<div class="ap-change"><span><i class="fa fa-refresh"></i> Aceito Troca</span></div>' : '') ?>
                        
                    
                    
                     <?php if ($this->session->userdata('login')) { ?>
                                    <div class="ap-salesman-info">
                       <h4>Informações do Vendedor</h4>
			
                        <ul>
                            <li><i class="fa fa-fw fa-user"></i><?= $ad->use_name ?></li>

                            <?= (($ad->use_phone) ? '<li><i class="fa fa-fw fa-phone"></i>' . $ad->use_phone . '</li>' : '') ?>
                            <?= (($ad->use_celular) ? '<li><i class="fa fa-fw fa-mobile"></i>' . $ad->use_celular . '</li>' : '') ?>
                            <?= (($ad->use_whatsapp) ? '<li><i class="fa fa-fw fa-whatsapp"></i><a href=" https://api.whatsapp.com/send?phone=55'. $ad->use_whatsapp . '&text=Olá, vi seu anúncio ' . $ad->ad_name . ' no Panamérico e tenho interesse!" target="_blank">WhatsApp<small> - Clique para conversar</small></a></li>' : '') ?>
                            <?= (($ad->use_instagram) ? '<li><i class="fa fa-fw fa-instagram"></i><a href="https://www.instagram.com/' . $ad->use_instagram . '" target="_blank">Instagram</a></li>' : '') ?>
                            <?= (($ad->use_facebook) ? '<li><i class="fa fa-fw fa-facebook"></i><a href="https://www.facebook.com/' . $ad->use_facebook . '" target="_blank">Facebook</a></li>' : '') ?>
                            <?= (($ad->use_website) ? '<li><i class="fa fa-fw fa-globe"></i><a href="' . $ad->use_website . '" target="_blank">Website</a></li>' : '') ?>
                            <?= (($ad->use_mercado_livre) ? '<li><i class="fa fa-fw fa-external-link"></i><a href="' . $ad->use_mercado_livre . '" target="_blank">Mercado Livre</a></li>' : '') ?>
                            <?= (($ad->use_elo7) ? '<li><i class="fa fa-fw fa-external-link"></i><a href="http://www.elo7.com.br/' . $ad->use_elo7 . '" target="_blank">Elo7</a></li>' : '') ?>
                            <?= (($ads_shop) ? '<li><i class="fa fa-shopping-cart"></i><a href="' . base_url('loja/' . $shop) . '" target="_self">' . $ads_shop . ' Anúncios na Loja</a></li>' : '') ?>
                        </ul>
                        
                        <h4></h4>

                        <div class="ap-send-message">                       
                   
                        -<form method="POST" id="mobile-message" action="<?= base_url('chat/novo_chat') ?>">
                    
                            <input type="hidden" name="sender_id" value="<?= $_SESSION['login']; ?>">
                            <input type="hidden" name="recipient_id" value="<?= $ad->use_id ?>">
                            <input type="hidden" name="ad_id" value="<?= $ad->ad_id ?>">
                            <input type="hidden" name="use_email" value="<?= $ad->use_email; ?>">
                            <input type="hidden" name="use_name" value="<?= $ad->use_name; ?>">
                            <input type="hidden" name="ad_name" value="<?= $ad->ad_name; ?>">

                            <center><button style="width: 85%;" <?php if($_SESSION['login'] == $ad->use_id ){ echo 'disabled' ; } ?> type="submit" class="btn btn-warning"><i class="fa fa-comments"></i> Iniciar chat</button></center>
                        </form>
                    </div>
                    </div>
                    
                            <div></div>
                                <?php } else { ?>
                                    <div class="ap-salesman-info"><h4>Informações do Vendedor</h4>
                                          <ul>
                            <li><i class="fa fa-fw fa-user"></i><?= $ad->use_name ?></li>
                           
                            <?= (($ads_shop) ? '<li><i class="fa fa-shopping-cart"></i><a href="' . base_url('loja/' . $shop) . '" target="_self">' . $ads_shop . ' Anúncios na Loja</a></li>' : '') ?>
                        </ul>
                                    <a href="#" data-modal="<?= base_url('login') ?>" class="modal-open"><center><button class="btn btn-primary" style="width:80%;margint-top:10px;margin-bottom:10px">logar para exibir</button></center></a></div>
                                <?php } ?>

                    <div class="ap-actions">
                        <?php
                        if ($this->session->userdata('login')) {
                            $favoriteVerify = $this->user_model->favoriteVerify($ad->ad_id);

                            if ($favoriteVerify) {
                                echo '<a href="' . base_url('ads/remove_favorite/' . $ad->ad_id) . '" class="ap-a-favorite active"><i class="fa fa-heart"></i>Favorito</a>';
                            } else {
                                echo '<a href="' . base_url('ads/add_favorite/' . $ad->ad_id) . '" class="ap-a-favorite"><i class="fa fa-heart"></i>Favorito</a>';
                            }

                            echo '<a href="#" data-modal="' . base_url('ads/report/' . $ad->ad_id) . '" class="ap-a-report modal-open"><i class="fa fa-bullhorn"></i>Denunciar</a>';
                        } else {
                            echo '<a href="#" data-modal="' . base_url('login/required/') . '" class="ap-a-favorite modal-open"><i class="fa fa-heart"></i>Favorito</a>';

                            echo '<a href="#" data-modal="' . base_url('login/required/') . '" class="ap-a-report modal-open"><i class="fa fa-bullhorn"></i>Denunciar</a>';
                        }
                        ?>
                    </div>

                    <div class="ap-share">
                        <h4>Compartilhe</h4>

                        <ul>
                            <li><a href="https://www.facebook.com/sharer/sharer.php?u=<?= $link ?>" title="Facebook" class="window-open" target="_blank" id="ap-s-facebook"><i class="fa fa-facebook"></i></a></li>

                            <li><a href="#" data-modal="<?= base_url('ads/email_share/' . $ad->ad_id) ?>" title="Enviar E-mail" class="modal-open" id="ap-s-mail"><i class="fa fa-envelope"></i></a></li>
                            <li class="show-for-small-only"><a href="whatsapp://send?text=<?= $ad->ad_name ?> <?= $link ?>" data-modal="" title="Compartilhe no WhatsApp" target="_blank" id="ap-s-mail"><i class="fa fa-whatsapp"></i></a></li>
                            <li class="hide-for-small-only"><a href="https://plus.google.com/share?url=<?= $link ?>" title="Google Plus" class="window-open" target="_blank" id="ap-s-google-plus"><i class="fa fa-google-plus hide-for-small-only"></i></a></li>
                            <li class="hide-for-small-only"><a href="https://twitter.com/home?status=Olhem%20esse%20anuncio%3A%20<?= $link ?>" title="Twitter" class="window-open" target="_blank" id="ap-s-twitter"><i class="fa fa-twitter hide-for-small-only"></i></a></li>
                            <li class="hide-for-small-only"><a href="https://www.linkedin.com/shareArticle?mini=true&url=<?= $link ?>&title=<?= $ad->ad_name ?>&summary=<?= resume($ad->ad_desc, 100) ?>&source=Panam%C3%A9rico" title="LinkedIn" class="window-open hide-for-small-only" target="_blank" id="ap-s-linkedin"><i class="fa fa-linkedin"></i></a></li>
                        </ul>
                    </div>

                    <?php
                    if ($ad->ad_mercado_livre || $ad->ad_elo7) {
                        echo '
                        <div class="ap-links">
                            <h4>Publicado também em</h4>

                            <ul>
                        ';

                        if ($ad->ad_mercado_livre) {
                            echo '<li><a href="' . $ad->ad_mercado_livre . '" target="_blank" title="Ir para o Mercado Livre"><img alt="Mercado Livre" src="' . base_url('assets/img/mercadolivre-logo.png') . '"></a></li>';
                        }

                        if ($ad->ad_elo7) {
                            echo '<li><a href="' . $ad->ad_elo7 . '" target="_blank" title="Ir para o Elo7" title="Elo7"><img alt="Elo7" src="' . base_url('assets/img/elo7-logo.png') . '"></a></li>';
                        }

                        echo '
                            </ul>
                        </div>
                        ';
                    }
                    ?>

                    <br>
                    <div id="ads-inserir">
                    <div class="hide-for-small-only">
                        <?= $this->main_model->advertisingBox('top', '266px', '600px') ?>
                        </div>
                    </div>
                    <div><?= $this->main_model->advertisingBox('top', '100%', '600px') ?></div>
                </div>
            </div>
             <div class="hide-for-small-only"><?=$this->main_model->advertisingBox('top', '100%', '90px') ?></div>
        </div>
    </div>
</div>
<script src="<?= base_url('assets/js/custom/ads_details.js') ?>"></script>