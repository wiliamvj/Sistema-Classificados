<script>
    function isTipo(pVal)
    {
        var reTipo = /[A-z][ ][A-z]/;
        return reTipo.test(pVal);
    }

    $('#nome').keyup(function() {
        if (!isTipo($(this).val())) {
            $('#cadastrar').hide();
            $('#msgNome').show();
        } else {
            $('#cadastrar').show();
            $('#msgNome').hide();
        }
    });

    $('#nome').keypress(function(e) {
        if (e.which == 13) {
            e.preventDefault();
        }
    });
    
    $('#input-email').keypress(function(e) {
        if (e.which == 13) {
            e.preventDefault();
        }
    });

    $('#senha').keypress(function(e) {
        if (e.which == 13) {
            e.preventDefault();
        }
    });
</script>
<form method="POST" action="<?= base_url('register/insert') ?>" id="form-register" class="form form-simple">
    <div class="row">
        <div class="medium-12 columns">
            <span id="msgNome" style="color: crimson; font-size: 15px; font-family: arial; display: none;"><i class="fa fa-exclamation-triangle"></i> por favor, preencha nome e sobrenome. Ex. Maria silva</span>
            <input type="text" required name="name" autocomplete="off" id="nome" placeholder="nome completinho">
        </div>
    </div>
    <div class="row">
        <div class="medium-12 columns">
            <input type="email" required name="email" id="input-email" placeholder="email (exemplo@exemplo.com.br)">
        </div>
    </div>
    <div class="row">
        <div class="medium-12 columns">
            <input type="password" required onkeyup="passwordStrength(this.value)" id="senha" name="password" placeholder="Senha">
            <div class="passwordForce">
                <div class="no-strength"></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="medium-12 medium-3 end columns">
            <input type="tel" name="celular" maxlength="15" required name="phone" pattern="[0-9]+$" placeholder="Informe seu Celular" value="<?=$user->use_celular?>">
    </div>

    <div id="register-return"></div>

    <div class="row">
        <div class="medium-12 medium-12 columns">
            <button type="submit" class="btn btn-primary btn-full cadastrar" id="cadastrar">Cadastrar</button>
        </div>
    </div>

    <!--<div class="row">
        <div class="medium-12 medium-12 columns">
            <a href="<?= $this->config->item('facebook_link_auth') ?>" target="_self" class="btn btn-facebook btn-full">
                <i class="fa fa-facebook"></i> entrar com facebook
            </a>
        </div>
    </div>-->

</form>

<script src="<?= base_url('assets/js/custom/register.js') ?>"></script>