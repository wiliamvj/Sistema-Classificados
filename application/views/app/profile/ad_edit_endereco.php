
    <div class="row">
        <div class="hide-for-small-only medium-2 end columns">
            <label class="text-right middle">CEP:<span class="required">*</span></label>
        </div>
        <div class="small-12 medium-3 large-3 end columns">
            <label class="show-for-small-only">CEP:<span class="required">*</span></label>
            <input type="text" required class="input-cep" name="cep" id="ai-cep" placeholder="Digite o CEP">
        </div>
        <div class="small-12 medium-7 columns">
            <div class="checkbox-custom cc-m-bottom-xsmall" style="margin-top: 5px">
                <a href="http://www.buscacep.correios.com.br/sistemas/buscacep/" target="_blank">Não sei meu cep</a>
            </div>
        </div>
    </div>

    <!-- Estado -->
    <div class="row">
        <div class="hide-for-small-only medium-2 columns">
            <label class="text-right middle">Estado:<span class="required">*</span></label>
        </div>
        <div class="small-12 medium-4 large-4 end columns">
            <label class="show-for-small-only">Estado:<span class="required">*</span></label>
            <select name="state" id="ai-state" required >
                    <option value="">Selecione seu Estado</option>
            </select>
        </div>
    </div>

    <!-- Região -->
    <div class="row">
        <div class="hide-for-small-only medium-2 columns">
            <label class="text-right middle">Região:<span class="required">*</span></label>
        </div>
        <div class="small-12 medium-4 large-4 end columns">
            <label class="show-for-small-only">Região:<span class="required">*</span></label>
            <select name="region" id="ai-region" required>
                <option value="">Região da Cidade</option>
            </select>
        </div>
    </div>

    <!-- Cidade -->
    <div class="row" id="box-city" style="display:none;">
       <div class="small-12 medium-10 medium-offset-2 end columns">
            <div id="label-city" style="margin-bottom: 10px;">...</div>
            <input type="hidden" name="city" id="ai-city" value="">
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
            <div class="checkbox-custom cc-m-bottom-xsmall" style="margin-top: 5px">
                <input type="checkbox" name="use-info" id="ai-use-info" >
                <label for="ai-use-info">Usar informações do meu perfil</label>
            </div>
        </div>
    </div>
