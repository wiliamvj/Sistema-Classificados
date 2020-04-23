

$(document).ready(function() {

   /*function limpa_formulario_cep() {
        // Limpa valores do formulário de cep.
        $("[id*='address']").val("");
        $("[id*='city']").val("");
        $("#bairro").val("");
        $("[id*='state']").val("");
    }

    //Quando o campo cep perde o foco.
    $("[id*='cep']").blur(function() {

        //Nova variável "cep" somente com dígitos.
        var cep = $(this).val().replace(/\D/g, '');

        //Verifica se campo cep possui valor informado.
        if (cep != "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if(validacep.test(cep)) {
                atualizaCep(cep);//Preenche os campos com "..." enquanto consulta webservice.

            } //end if.
            else {
                //cep é inválido.
                limpa_formulario_cep();
                alert("Formato de CEP inválido.");
            }
        } //end if.
        else {
            //cep sem valor, limpa formulário.
            limpa_formulario_cep();
        }
    });

    function atualizaCep(cep){
        $("[id*='address']").val('');
        //$("#bairro").val("");
        $("[id*='city']").val("");
        $("[id*='state']").val("");

        //Consulta o webservice viacep.com.br/
        $.getJSON("//viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

            if (!("erro" in dados)) {
                //Atualiza os campos com os valores da consulta.
                $("[id*='address']").val(dados.logradouro);
                //$("#bairro").val(dados.bairro);
                $("[id*='city']").val(dados.localidade);
                $("[id*='state']").val(dados.uf);
            } //end if.
            else {
                //CEP pesquisado não foi encontrado.
                limpa_formulario_cep();
                alert("CEP não encontrado.");
            }
        });
    }*/
});