<script>
    $(function(){
    var jElement = $('#ads-inserir');
    var tam = $(window).width();
   
    if(tam <= 1024){
        $(".medium-6 columns").show();
    }else{
        $(window).scroll(function(){
        if ( $(this).scrollTop() > 980 ){
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
        <div class="announce-insert" id="announce-insert">
            <div class="row">
                <div class="medium-12 large-8 columns">
                    <div class="announce__header">
                        <span>Adicionar anúncio</span>
                        <p>Adicione todos os dados e tenha mais chances de vender.</p>
                    </div>

                    <h1 style="text-align: center;"><i class="fa fa-info-circle"></i> Dados do Anúncio</h1>
                    <p class="announce_infor">As informações marcadas com asterisco (*) são obrigatórias</p>
                    
                    <div id="msg_titulo" class="alert alert-subtitle" id="msgImg" style="display: none;">
                                    <ul><li><span style="font-size: 15px;"><i class="fa fa-info-circle"></i> Atenção:</span> <span style="color: orange; font-size: 14px;">	 <strong>Não aceitamos venda de animais! Não compre, adote <i class="fa fa-heart"></i></strong></span></li></ul>
                                </div>


                    <form  enctype="multipart/form-data" method="POST" accept-charset="utf-8" action="<?= base_url('announce/insert') ?>" id="ai-form" class="form form-simple ai-form">
                        <input type="hidden" name="hash" id="ai-hash" value="<?=$hash?>">

                        <!-- Categories -->
                        <input type="hidden" name="category" id="ai-category" value="">

                        <div class="row" id="ai-f-category-required">
                            <div class="medium-12 columns">
                                <div class="alert alert-danger"><strong><i class="fa fa-exclamation-triangle"></i>Atenção:</strong> Selecione uma categoria para continuar!</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="small-12 medium-2 columns">
                                <label class="text-right middle ai-label">Categoria:<span class="required">*</span></label>
                            </div>
                            <div class="small-12 medium-10 columns">
                                <div class="ai-f-categories">
                                    <div class="l" id="ai-f-c-parent">
                                        <ul>
                                            <?php
                                            foreach ($categories as $key => $cat) {
                                                echo '<li data-id="' . $cat->ads_cat_id . '" data-name="' . $cat->ads_cat_name . '"><i class="fa fa-fw ' . $cat->ads_cat_icon . '"></i>' . $cat->ads_cat_name . '</li>';
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                    <div class="r" id="ai-f-c-sub">&nbsp;</div>
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="hide-for-small-only medium-2 columns">
                                <label class="text-right middle">Título:<span class="required">*</span></label>
                            </div>
                            
                            <div class="small-12 medium-10 large-10 end columns">
                                <label class="show-for-small-only">Título:<span class="required">*</span></label>
                                
                                                                  
       
                                <input type="text" required name="title" id="ai-title" placeholder="Título do Anúncio" maxlength="70">
                            </div>
                        </div>

                        <div class="row">
                            <div class="hide-for-small-only medium-2 columns">
                                <label class="text-right middle">Descrição:<span class="required">*</span></label>
                            </div>
                            <div class="small-12 medium-10 large-10 end columns">
                                <label class="show-for-small-only">Descrição:<span class="required">*</span></label>
                                <textarea required name="desc" id="ai-desc" rows="6" placeholder="Descrição do Anúncio" maxlength="800"></textarea>
                            </div>
                        </div>

                        <div id="desativa" class="row">
                            <div id="not_desktop_preco" class="hide-for-small-only medium-2 columns">
                                <label class="text-right middle ai-label">Preço:<span class="required">*</span></label>
                            </div>
                            <div id="not_preco" class="small-12 medium-4 large-4 end columns">
                                <label class="show-for-small-only">Preço:<span class="required">*</span></label>
                                <div class="row collapse">
                                    <div class="small-3 large-2 columns">
                                        <span class="prefix">R$</span>
                                    </div>
                                    <div class="small-9 large-10 columns">
                                        <input type="text" required class="input-money" name="price" id="ai-price" placeholder="Preço do Anúncio">
                                    </div>
                                </div>
                            </div>

                            <div id="bloco" class="small-12 medium-6 large-6 columns">
                                <div id="service" class="checkbox-custom cc-m-bottom-xsmall" style="margin-top: -6px;">
                                    <input type="checkbox" name="no-price" id="ai-no-price" value="1">
                                    <label for="ai-no-price">Não tem preço, é um serviço.</label>
                                </div>
                                <div id="trade" class="checkbox-custom cc-m-bottom-xsmall">
                                    <input type="checkbox" name="yes-trade" id="ai-yes-trade" value="1">
                                    <label for="ai-yes-trade">Aceito troca.</label>
                                </div>
                                <div id="adote" style="display:none; margin-left: -12px;" class="small-12 medium-4 large-10 end columns">
                                    <strong>Vai anunciar um Animal? <i class="fa fa-frown-o"></i></strong>
                                    <div id="ai-adote" class="checkbox-custom cc-m-bottom-xsmall">
                                        <input type="checkbox" name="adote" id="ai-yes-adote" value="1">
                                        <label>Sim</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="show-for-small-only"><br></div>
                        <!-- custom fields - begin -->

                        <div id="ai-custom-fields"></div>

                        <!-- custom fields - end -->

                        <div class="row">
                            <div class="hide-for-small-only medium-2 columns">
                                <label class="text-right middle">Imagens:<span class="required">*</span></label>
                            </div>
                            <div class="small-12 medium-10 large-10 end columns">
                                <label class="show-for-small-only">Imagens:<span class="required">*</span></label>
                                <button type="button" class="btn btn-secondary btn-m-bottom-medium" id="images-upload-button">
                                    <i class="fa fa-picture-o"></i> Adicionar Imagens
                                </button>

                                <div class="dropzone" id="images-upload"></div>

                                <div id="image-preview-template" style="display: none">
                                    <div class="dz-preview dz-file-preview">
                                        <div class="dz-remove-file" style="display: none"><span style="padding: 0px 0px 0px 0px;" title="Apagar Imagem" data-dz-remove><i class="fa fa-fw fa-trash"></i></span></div>
                                        <div class="dz-image">
                                            <img class="gimg"  data-dz-thumbnail />
                                        </div>
                                        <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
                                        <div class="dz-success-mark"><span><i class="fa fa-fw fa-check"></i></span></div>
                                        <div class="dz-error-mark"><span><i class="fa fa-fw fa-close"></i></span></div>
                                        <div class="dz-error-message"><span data-dz-errormessage></span></div>
                                    </div>
                                </div>
                                <div style="clear: both;"></div>
                                <div class="alert alert-subtitle hide-for-small-only" id="msgImg" style="display: none;">
                                    <ul><li><span style="font-size: 15px;">Atenção:</span> <span style="color: red; font-size: 14px;"><strong>Altura e largura mínima:</strong> 350x260px</span></li></ul>
                                </div>
                                <div class="alert alert-subtitle hide-for-small-only">
                                    <ul>
                                        <li><strong>Tamanho máximo:</strong> 8MB</li>
                                        <li><strong>Altura e largura mínima:</strong> 350x260px</li>
                                        <li><strong>Máximo de imagens permitidas:</strong> 10</li>
                                        <li><strong>Tipos arquivo permitido:</strong> JPG, JPEG e PNG</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="hide-for-small-only medium-2 columns">
                                <label class="text-right middle">Vídeo:</label>
                            </div>
                            <div class="small-12 medium-6 large-6 end columns">
                                <label class="show-for-small-only">Vídeo:</label>
                                <input type="text" name="video" placeholder="Link Vídeo do Produto" data-original-title="Só aceitamos videos do Youtube, caso coloque de outro site, não garantimos o funcionamento." data-toggle="tooltip" data-placement="top" title="">
                            </div>
                        </div>

                        <div class="row">
                            <div class="hide-for-small-only medium-2 columns">
                                <label class="text-right middle">Mercado Livre:</label>
                            </div>
                            <div class="small-12 medium-6 large-6 end columns">
                                <label class="show-for-small-only">Mercado Livre:</label>
                                <input type="text" name="mercado_livre" placeholder="Link do seu anúncio no Mercado Livre" data-original-title="Caso tenha um anúncio no Mercado Livre do mesmo produto, coloque o link e venda mais rápido." data-toggle="tooltip" data-placement="top" title="">
                            </div>

                        </div>

                        <div class="row">
                            <div class="hide-for-small-only medium-2 columns">
                                <label class="text-right middle">Elo7:</label>
                            </div>
                            <div class="small-12 medium-6 large-6 end columns">
                                <label class="show-for-small-only">Elo7:</label>
                                <input type="text" name="elo7" placeholder="Link do seu anúncio no Elo7" data-original-title="Caso tenha um anúncio no Elo7 do mesmo produto, coloque o link e venda mais rápido." data-toggle="tooltip" data-placement="top" title="">
                            </div>
                        </div>

                        <div class="row">
                            <div class="medium-10 medium-offset-2 columns">
                                <div class="ad_address">

                                    <div class="row">
                                        <div class="hide-for-small-only medium-2 end columns">
                                            <label class="text-right middle">CEP:<span class="required">*</span></label>
                                        </div>
                                        <div class="small-12 medium-5 large-5 end columns">
                                            <label class="show-for-small-only">CEP:<span class="required">*</span></label>
                                            <input type="text" required class="input-cep" name="cep" id="ai-cep" placeholder="Digite o CEP">
                                        </div>
                                        <div class="small-12 medium-5 columns">
                                            <a href="http://www.buscacep.correios.com.br/sistemas/buscacep/" class="cep_link" target="_blank">
                                                <span class="btn btn-help hidden-xs">
                                                    <i class="fa fa-question"></i>
                                                </span>
                                                Não sei meu CEP
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Estado -->
                                    <div class="row">
                                        <div class="hide-for-small-only medium-2 columns">
                                            <label class="text-right middle">Estado:<span class="required">*</span></label>
                                        </div>
                                        <div class="small-12 medium-8 large-8 end columns">
                                            <label class="show-for-small-only">Estado:<span class="required">*</span></label>
                                            <select name="state" id="ai-state" required >
                                                <option>Selecione seu Estado</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Região -->
                                    <div class="row">
                                        <div class="hide-for-small-only medium-2 columns">
                                            <label class="text-right middle">Região:<span class="required">*</span></label>
                                        </div>
                                        <div class="small-12 medium-8 large-8 end columns">
                                            <label class="show-for-small-only">Região:<span class="required">*</span></label>
                                            <select name="region" id="ai-region" required>
                                                <option value="">Região da Cidade</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Cidade -->
                                    <div class="row">
                                        <div class="hide-for-small-only medium-2 columns">
                                            <label class="text-right middle">Município:<span class="required">*</span></label>
                                        </div>
                                        <div class="small-12 medium-8 large-8 end columns">
                                            <label class="show-for-small-only">Município:<span class="required">*</span></label>
                                            <select name="city" id="ai-city" required>
                                                <option value="">Selecione um município</option>

                                            </select>
                                        </div>
                                    </div>

                                    <!-- Bairro -->
                                    <div class="row" id="box-neighborhood" style="display:none;">
                                        <div class="small-12 medium-10 medium-offset-2 end columns">
                                            <div id="label-neighborhood" style="margin-bottom: 10px;">...</div>
                                            <input type="hidden" name="neighborhood" id="ai-neighborhood" value="">
                                        </div>
                                    </div>

                                    <!-- Endereço -->
                                    <div class="row" id="box-address" style="display:none;">
                                        <div class="small-12 medium-10 medium-offset-2 end columns">
                                            <div id="label-address" style="margin-bottom: 10px;">...</div>
                                            <input type="hidden" name="address" id="ai-address" value="">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="small-12 medium-10 medium-offset-2 columns">
                                           <!-- <div class="checkbox-custom cc-m-bottom-xsmall" style="margin-top: 5px">
                                                <input type="checkbox" name="use-info" id="ai-use-info" >
                                                <label for="ai-use-info">Usar dados do meu perfil</label>
                                            </div>-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="small-12 medium-2 columns">&nbsp;</div>
                            <div class="small-12 medium-10 large-10 end columns">
                                <div class="checkbox-custom">
                                    <input type="checkbox" required id="ai-terms">
                                    <label for="ai-terms">Concordo com os <a href="<?= base_url('ajuda/termos-de-uso') ?>" target="_blank">Termos do your-site</a>.</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="small-12 columns" align="center">
                                <div class="ai-f-actions">
                                    <button type="button" id="preview-button" class="btn btn-secondary hide-for-small-only"><i class="fa fa-eye"></i> Pré-Visualizar</button>
                                    <?php if (!isset($form_disabled)): ?>
                                        <button type="submit" id="publish-button" disabled="disabled" class="btn btn-primary"><i class="fa fa-reply-all"></i> Publicar</button>
                                    <?php else: ?>
                                        <button type="button" class="btn btn-default" onclick="modal('<?= $modal_alert ?>')"><i class="fa fa-reply-all"></i> Publicar</button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="preview-alert-img" style="display: none">
                            <div class="medium-12 columns">
                                <div class="alert alert-danger" align="center"><strong><i class="fa fa-exclamation-triangle"></i> Atenção</strong><br>Para pré-visualizar o anúncio, você precisa selecionar pelo menos uma imagem.</div>
                            </div>
                        </div>
                        <div class="row" id="preview-alert" style="display: none">
                            <div class="medium-12 columns">
                                <div class="alert alert-danger" align="center"><strong><i class="fa fa-exclamation-triangle"></i>Atenção</strong><br>Para pré-visualizar o anúncio, você precisa escolher uma <strong>categoria</strong>, preencher com <strong>título</strong>, <strong>descrição</strong>, <strong>preço</strong>, <strong>endereço</strong> e pelo menos uma imagem.</div>
                            </div>
                        </div>
                    </form>

                </div>

                <div class="medium-12 large-4 columns">
                    <div class="hide-for-small-only ai-tips">
                        <h3>Dicas para vender rápido</h3>

                        <ul>
                            <li>
                                <span><i class="fa fa-fw fa-tag"></i></span>
                                <span>Anúncios com fotos reais vende 5x mais rápido.</span>
                            </li>
                            <li>
                                <span><i class="fa fa-fw fa-dollar"></i></span>
                                <span>Coloque um preço atrativo e justo.</span>
                            </li>
                            <li>
                                <span><i class="fa fa-fw fa-info"></i></span>
                                <span>Escolha uma categoria que tenha a ver com seu anúncio.</span>
                            </li>
                            <li>
                                <span><i class="fa fa-fw fa-pencil"></i></span>
                                <span>Insira um texto atrativo.</span>
                            </li>
                            <li>
                                <span><i class="fa fa-fw fa-envelope-o"></i></span>
                                <span>Responda com rapidez os interessados.</span>
                            </li>
                            <li>
                                <span><i class="fa fa-fw fa-share-alt"></i></span>
                                <span>Compartilhe seu anúncio em suas redes sociais e aumente suas chance de vender.</span>
                            </li>
                        </ul>
                    </div>

                    <div class="hide-for-small-only"><?= $this->main_model->advertisingBox('top', '266px', '300px') ?></div>
                    <div id="ads-inserir">
                    <div class="hide-for-small-only"><?= $this->main_model->advertisingBox('top', '266px', '600px') ?></div>
                    </div>

                </div>
            </div>
            <?= $this->main_model->advertisingBox('side', '100%', '600px') ?>
        </div>

        <div class="ads-page" id="announce-preview" style="display: none">
            <div class="row">
                <div class="medium-8 columns">
                    <h1 class="ap-title" id="preview-title"><!-- ad title --></h1>

                    <div id="preview-images"><!-- ad images --></div>

                    <div class="ap-desc">
                        <h3>Descrição</h3>
                        <p id="preview-desc"><!-- ad desc --></p>

                        <br>

                        <h3>Detalhes</h3>
                        <ul>
                            <li><strong>Publicado em:</strong> <?= date("d/m/Y H:i:s") ?></li>
                            <li><strong>Categoria:</strong> <span id="preview-cat-1"></span> <i class="fa fa-angle-right" aria-hidden="true"></i> <span id="preview-cat-2"></span></li>
                            <li><strong>ID do Anúncio:</strong> <?= rand(500, 99999) ?></li>
                        </ul>
                    </div>
                </div>
                <div class="medium-4 columns">
                    <div class="ap-price" id="preview-price"><!-- price or service --></div>

                    <div class="ap-change" id="preview-trade" style="display: none"><span>Aceito Troca</span></div>

                    <div class="ap-salesman-info">
                        <h4>Informações do Vendedor</h4>

                        <ul>
                            <li><i class="fa fa-fw fa-user"></i><?= $user->use_name ?></li>

                            <?= (($user->use_phone) ? '<li><i class="fa fa-fw fa-phone"></i>' . $user->use_phone . '</li>' : '') ?>
                            <?= (($user->use_whatsapp) ? '<li><i class="fa fa-fw fa-whatsapp"></i>' . $user->use_whatsapp . '</li>' : '') ?>

                            <li><i class="fa fa-fw fa-instagram"></i>Instagram</li>
                            <li><i class="fa fa-fw fa-globe"></i>Website</li>
                            <li><i class="fa fa-fw fa-external-link"></i>Mercado Livre</li>
                            <li><i class="fa fa-fw fa-external-link"></i>Elo7</li>
                        </ul>
                        <div class="ap-send-message">
                            <center><h4>Interessado?<br>Envie uma menssagem agora!</h4></center>
                            <input type="hidden" name="code" value="<?= $ad->ad_id ?>">
                            <input type="hidden" name="user_email" value="<?= $ad->use_email ?>" disabled>

                            <input type="text" required name="name" placeholder="Nome Completo*"  disabled>

                            <input type="email" required name="email" placeholder="Seu e-mail*"  disabled>

                            <input type="text" name="phone" class="input-phone" placeholder="Seu telefone ou celular"  disabled>

                            <textarea required name="msg" placeholder="Mensagem ao vendedor"  disabled></textarea>

                            <div class="checkbox-custom">
                                <input type="checkbox" name="sender-copy" id="ad-sender-copy">
                                <label for="ad-sender-copy">Deseja receber uma cópia?</label>
                            </div>

                            <center><button type="button" class="btn btn-primary" disabled><i class="fa fa-envelope"></i> Enviar Mensagem</button></center>
                        </div>
                    </div>

                    <div class="ap-preview-actions" align="center">
                        <button type="button" id="back-preview-button" class="btn btn-secondary"><i class="fa fa-pencil"></i> Voltar a Edição</button>
                        <?php if (!isset($form_disabled)): ?>
                            <button type="button" id="publish-preview-button" class="btn btn-primary"><i class="fa fa-reply-all"></i> Publicar Agora</button>
                        <?php else: ?>
                            <button type="button" class="btn btn-default" onclick="modal('<?= $modal_alert ?>')"><i class="fa fa-reply-all"></i> Publicar Agora</button>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </div>


    </div>
</div>
<script>

    $(function() {
        $("#ai-adote").click(function() {

            if ($('#ai-yes-adote').is(':checked')) {
                $('#ai-price').prop('disabled', false);
                $('#ai-yes-adote').prop('checked', false);
                $('#not_preco').show();
                $('#not_desktop_preco').show();
                $('#service').show();
                $('#trade').show();
                $('#bloco').addClass('small-12 medium-6 large-6 columns');
                $('#bloco').removeAttr('style');
            } else {
                $('#bloco').removeClass('small-12 medium-6 large-6 columns');
                $('#bloco').css({"margin-left":"135px", "padding-bottom":"60px"});
                $('#service').hide();
                $('#trade').hide();
                $('#not_preco').hide();
                $('#not_desktop_preco').hide();
                $('#ai-price').prop('disabled', true);
                $('#ai-yes-adote').prop('checked', true);
            }
        });
    });

    $("#ai-f-c-parent").on('click', 'li', function(event) {
        var btn = $(this);
        var cat = btn.attr('data-id');
        event.preventDefault();
        if (cat == 1) {
            $('#msg_titulo').show();
            $('#adote').show();

        } else {
            $('#msg_titulo').hide();
            $('#adote').hide();
        }
        if (cat == 114) {
            $('#ai-price').prop('disabled', true);
            $('#desativa').hide();

        } else {
            $('#ai-price').prop('disabled', false);
            $('#desativa').show();
        }
        
    });
</script>
<script src="<?= base_url('assets/js/vendor/dropzone.js') ?>"></script>
<script src="<?= base_url('assets/js/custom/announce.js') ?>"></script>
<?php if ($modal_alert): ?>
    <script>
        $(document).ready(function() {
            modal('<?= $modal_alert ?>');
        });
    </script>
<?php endif; ?>