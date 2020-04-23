<div class="simple-page">
    <div id="first-step" align="center">
        <p>Você já possui (mais de) <strong>5 anúncios publicados</strong> e agora você já pode abrir uma loja.</p>
        <br>
        <button type="button" id="open-shop" class="btn btn-primary"><i class="fa fa-shopping-cart" aria-hidden="true"></i>Abrir Minha Loja</button>
    </div>
    <div id="second-step" style="display: none">
        <form method="POST" action="<?= base_url('profile/shop/open') ?>" id="sc-form" class="form form-simple" enctype="multipart/form-data">
            <h1>Informações da Loja</h1>

            <div class="row">
                <div class="hide-for-small-only medium-2 columns">
                    <label class="text-right middle">Nome da Loja:<span class="required">*</span></label>
                </div>
                <div class="small-12 medium-10 columns">
                    <label class="show-for-small-only">Nome da Loja:<span class="required">*</span></label>
                    <input type="text" required name="name" id="nome"  placeholder="Informe o nome da sua loja" maxlength="50">
                </div>
            </div>

            <div class="row">
                <div class="hide-for-small-only medium-2 columns">
                    <label class="text-right middle">Descrição:<span class="required">*</span></label>
                </div>
                <div class="small-12 medium-10 columns">
                    <label class="show-for-small-only">Descrição:<span class="required">*</span></label>
                    <textarea name="desc" required placeholder="Descrição da loja" id="descricao" maxlength="500" style="height: 150px;"></textarea>
                </div>
            </div>

            <div class="row">
                <div class="hide-for-small-only medium-2 columns">
                    <label class="text-right middle">URL da Loja:<span class="required">*</span></label>
                </div>
                <div class="small-12 medium-8 end columns">
                	
                    <label class="show-for-small-only" style="margin-left: 15px;">URL da Loja:<span class="required">*</span></label>
                    <div class="row collapse">
                        <div class="small-6 large-5 columns">
                            <span class="prefix hide-for-small-only">your-site.com.br/loja/</span>
                            <span class="prefix show-for-small-only">loja/</span>
                        </div>
                        <div class="small-6 large-7 columns" data-original-title="Você não poderá alterar essa informação futuramente." data-toggle="tooltip" data-placement="top" title="">
                            <input type="text" name="slug" id="sc-slug" autocomplete="off" required placeholder="Seu perfil" value="<?= $shop->shop_slug ?>">
                            <div id="urlmsg" style=" height: 20px; margin-top: -15px;"></div>
                        </div>
                    </div>
                    
                    <div class="alert alert-subtitle hide-for-small-only"><strong><i class="fa fa-link" aria-hidden="true"></i> Essa URL serve para você divulgar/acessar sua loja.</strong><br>
                    	<div class="alert alert-subtitle hide-for-small-only" style="font-size: 12px; font-weight: bold;">
                    		Não use espaços nem caracteres especiais ($, &, *, #, @)<br>
	                	<div style="color:green;"><br><i class="fa fa-check"></i>your-site.com.br/loja/deve-ser-assim<br></div>
	                	<div style="color:red;"><i class="fa fa-times"></i>your-site.com.br/loja/Não deve ser assim</div>
	                </div>
                	
                    
                    </div>
                    
                </div>
            </div>
            <script>
                function isExtensao(obj) {
                    var extensoesOk = ",.png,.jpg,.jpeg,";
                    var extensao = "," + obj.value.substr(obj.value.length - 4).toLowerCase() + ",";
                    if (extensoesOk.indexOf(extensao) == -1 && obj.value != '')
                    {
                        notificacao("Erro!", "Arquivo não possui uma extensão válida.");
                        obj.value = '';
                        return false;
                    } else {
                        return true;
                    }
                }


                var loadFile = function(event, obg) {
                    if (isExtensao(obg)) {
                        var output = document.getElementById('pre-img');
                        output.src = URL.createObjectURL(event.target.files[0]);
                    }
                };

            </script>
            <script>

                $('#nome').keypress(function(e) {
                    if (e.which == 13) {
                        e.preventDefault();
                    }
                });
                
                $('#descricao').keypress(function(e) {
                    if (e.which == 13) {
                        e.preventDefault();
                    }
                });
                
                $('#sc-slug').keypress(function(e) {
                    if (e.which == 13) {
                        e.preventDefault();
                    }
                });
                
                $('#sc-slug').keyup(function() {
                    var slug = $("#sc-slug").val();
                    $('#urlmsg').empty();
                    if (slug != '') {
                        $.ajax({url: 'https://your-site.com.br/shops/slug_verify', type: 'POST', data: {string: slug, code: 0}}).done(function(data) {
                            if (data == "slug_yes") {
                                $('#urlmsg').empty();
                                $('#urlmsg').html('<span style="color: red; font-size: 12px; "><i class="fa fa-close"></i> <strong>Ops! URL não disponível</strong></span>');
                                //$("#sc-slug").focus();
                                $('#sc-bt').hide();
                            } else if (data == "slug_no"){
                                $('#urlmsg').empty();
                                $('#urlmsg').html('<span style="color: green; font-size: 12px; "><i class="fa fa-check"></i> <strong>URL disponível</strong></span>');
                                $('#sc-bt').show();
                            }
                            console.clear();
                        }).fail(function() {
                            console.log("slug verify: error");
                        });
                    }else{
                        $('#urlmsg').empty();
                        
                    }
                });</script>
            <div class="row">
                <div class="hide-for-small-only medium-2 columns">
                    <label class="text-right middle">Categoria:<span class="required">*</span></label>
                </div>
                <div class="small-12 medium-5 end columns">
                    <label class="show-for-small-only">Categoria:<span class="required">*</span></label>
                    <select name="category">
                        <?php
                        foreach ($categories as $key => $category) {
                            echo '<option value="' . $category->ads_cat_id . '">' . $category->ads_cat_name . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="hide-for-small-only medium-2 columns">
                    <label class="text-right middle">Logo:<span class="required">*</span></label>
                </div>
                <div class="small-12 medium-10 end columns" style="padding-right=19px;">
                    <label class="show-for-small-only">Logo:<span class="required">*</span></label>
                    <div class="small-12 medium-7 columns">
                        <input type="file" name="image" onchange="loadFile(event, this);" required id="sc-f-images-input" accept="image/*" capture="camera">
                        <label  style="width:100%;" class="btn btn-secondary btn-m-bottom-medium" for="sc-f-images-input" id="sc-f-images-label">
                            <i class="fa fa-image"></i> Selecionar uma Imagem
                        </label>

                        <div class="alert alert-subtitle hide-for-small-only">
                            <ul>
                                <li><strong>Tamanho máximo:</strong> 2MB</li>
                                <li><strong>Altura e largura mínima:</strong> 400px</li>
                                <li><strong>Tipos arquivo permitido:</strong> JPG e PNG</li>
                            </ul>
                        </div>
                    </div>
                    <div class="small-12 medium-3 columns">
                        <div id="sc-f-images-box" style="border: dotted #ccc 2px;">
                            <?php
                            $image = thumbnail(@$shop->shop_img_file, "shops", 190, 190, 2);

                            echo '<img src="https://your-site.com.br/assets/img/no-image.png">';
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <br>

            <div class="row">
                <div class="medium-10 medium-offset-2 columns">
                    <button type="submit" id="sc-bt" class="btn btn-primary"><i class="fa fa-cart-plus"></i> Criar Loja</button>
                </div>
            </div>
        </form>
    </div>
</div>   
<script src="<?= base_url('assets/js/custom/profile_shop_create.js') ?>"></script>