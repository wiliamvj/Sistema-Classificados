<div class="simple-page simple-page-intern">
    <form method="POST" action="<?= base_url('profile/shop/update') ?>" id="sc-form" class="form form-simple" enctype="multipart/form-data" >
        <input type="hidden" name="shop" id="sc-code" value="<?= $shop->shop_id ?>">
        <h1>Dados da Loja</h1>

        <div class="row">
            <div class="hide-for-small-only medium-2 columns">
                <label class="text-right middle">Nome da Loja:<span class="required">*</span></label>
            </div>
            <div class="small-12 medium-10 columns">
                <label class="show-for-small-only">Nome da Loja:<span class="required">*</span></label>
                <input type="text" required name="name" placeholder="Informe o nome da sua loja" maxlength="50" value="<?= $shop->shop_name ?>">
            </div>
        </div>

        <div class="row">
            <div class="hide-for-small-only medium-2 columns">
                <label class="text-right middle">Descrição:<span class="required">*</span></label>
            </div>
            <div class="small-12 medium-10 columns">
                <label class="show-for-small-only">Descrição:<span class="required">*</span></label>
                <textarea name="desc" required placeholder="Descrição da loja" maxlength="500" style="height: 150px;"><?= $shop->shop_desc ?></textarea>
            </div>
        </div>

        <div class="row">
            <div class="hide-for-small-only medium-2 columns">
                <label class="text-right middle">Categoria:<span class="required">*</span></label>
            </div>
            <div class="small-12 medium-5 end columns">
                <label class="show-for-small-only">Categoria:<span class="required">*</span></label>
                <select name="category">
                    <?php
                    foreach ($categories as $key => $category) {
                        echo '<option ' . (($shop->ads_cat_id == $category->ads_cat_id) ? 'selected' : '') . ' value="' . $category->ads_cat_id . '">' . $category->ads_cat_name . '</option>';
                    }
                    ?>
                </select>
            </div>
        </div>


        <div class="row">
            <div class="hide-for-small-only medium-2 columns">
                <label class="text-right middle">URL da Loja:<span class="required">*</span></label>
            </div>
            <div class="small-12 medium-8 end columns">
                <label class="show-for-small-only">URL da Loja:<span class="required">*</span></label>
                <div class="row collapse">
                    <div class="small-6 large-5 columns">
                        <span class="prefix hide-for-small-only">your-site.com.br/loja/</span>
                        <span class="prefix show-for-small-only">loja/</span>
                    </div>
                    <?php if ($shop->shop_slug == null): ?>
                        <div class="small-6 large-7 columns" data-original-title="Você não poderá alterar essa informação futuramente." data-toggle="tooltip" data-placement="top" title="">
                            <input type="text" name="slug" id="sc-slug" required placeholder="Seu perfil" value="<?= $shop->shop_slug ?>">
                        </div>
                    <?php else: ?>
                        <div class="small-6 large-7 columns" data-original-title="Você não pode mais alterar essa informação." data-toggle="tooltip" data-placement="top" title="">
                            <input type="text" placeholder="Seu perfil" value="<?= $shop->shop_slug ?>" disabled>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="alert alert-subtitle hide-for-small-only"><strong><i class="fa fa-link" aria-hidden="true"></i> Essa URL serve para você divulgar/acessar sua loja.</strong></div>
            </div>
        </div>

        <div class="row">
            <div class="hide-for-small-only medium-2 columns">
                <label class="text-right middle">Logo:<span class="required">*</span></label>
            </div>
            <div class="small-12 medium-7 columns">
                <label class="show-for-small-only">Logo:<span class="required">*</span></label>
                <input type="file" name="image" id="sc-f-images-input" accept="image/*" capture="camera">
                <label class="btn btn-secondary btn-m-bottom-medium" for="sc-f-images-input" id="sc-f-images-label">
                    <i class="fa fa-image"></i> Selecionar uma Imagem
                </label>

                <div class="alert alert-subtitle hide-for-small-only">
                    <ul>
                        <li><strong>Tamanho máximo:</strong> 2MB</li>
                        <li><strong>Altura e largura mínima:</strong> 400px</li>
                        <li><strong>Tipos arquivo permitido:</strong> JPG, JPEG e PNG</li>
                    </ul>
                </div>
            </div>
            <div class="small-12 medium-3 columns">
                <div id="sc-f-images-box">
                    <?php
                    $image = thumbnail(@$shop->shop_img_file, "shops", 190, 190, 2);

                    echo '<img src="' . $image . '">';
                    ?>
                </div>
            </div>
        </div>

        <br>
        <h1>Dados de Contato</h1>
        <div class="row">
            <div class="hide-for-small-only medium-2 columns">
                <label class="text-right middle">Telefone:<span class="required">*</span></label>
            </div>
            <div class="small-12 medium-4 end columns">
                <label class="show-for-small-only">Telefone:<span class="required">*</span></label>
                <input type="text" class="input-phone" id="sc-phone" required <?= (($shop->shop_user_info)) ?> name="phone" placeholder="(__) ____-____" value="<?= $shop->shop_phone ?>">
            </div>

        </div>

        <div class="row">
            <div class="medium-7 medium-offset-2 columns">
                <div class="ad_address">

                    <div class="row">
                        <div class="hide-for-small-only medium-2 end columns">
                            <label class="text-right middle">CEP:<span class="required">*</span></label>
                        </div>
                        <div class="small-12 medium-5 large-5 end columns">
                            <label class="show-for-small-only">CEP:<span class="required">*</span></label>
                            <input type="text" required class="input-cep" name="cep" id="sc-cep" value="<?= $shop->shop_cep ?>" placeholder="Digite o CEP">
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
                            <select name="state" id="sc-state" required >
                                <option value="">Selecione seu Estado</option>
                                <?php
                                foreach ($states as $key => $state) {
                                    echo '<option ' . (($shop->shop_state == $state->sta_id) ? 'selected' : '') . ' value="' . $state->sta_id . '">' . $state->sta_name . '</option>';
                                }
                                ?>
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
                            <select name="region" id="sc-region" required>
                                <option value="">Região da Cidade</option>
                                <?php if ($region): ?>
                                    <option value="<?= $shop->shop_region ?>" selected="selected"><?= $region ?></option>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>

                    <!-- Cidade -->
                    <div class="row">
                        <div class="hide-for-small-only medium-2 columns">
                            <label class="text-right middle">Cidade:<span class="required">*</span></label>
                        </div>
                        <div class="small-12 medium-8 large-8 end columns">
                            <label class="show-for-small-only">Cidade:<span class="required">*</span></label>
                            <select name="city" id="sc-city" required>
                                <option value="">Selecione uma cidade</option>
                                <?php
                                if ($shop->shop_city) {
                                    $cities = $this->main_model->cities($shop->shop_state);
                                    foreach ($cities as $key => $city) {
                                        echo '<option ' . (($shop->shop_city == $city->cit_id) ? 'selected' : '') . ' value="' . $city->cit_id . '">' . $city->cit_name . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>


                    <div class="row">
                        <div class="small-12 medium-10 medium-offset-2 columns">

                        </div>
                    </div>

                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="medium-10 medium-offset-2 columns">
                <button type="button" class="btn btn-primary" id="sc-submit"><i class="fa fa-floppy-o"></i>Salvar</button>
            </div>
        </div>
    </form>
</div>