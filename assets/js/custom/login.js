$(document).ready(function() {


    $("#logar").click(function(event) {

        var action = $("#form-login").attr('action');
        var submit = $("#logar");
        var submit_text = submit.html();
        var email = $("#input-email").val();
        var password = $("#input-password").val();

        if (email == '') {
            $("#login-return").html('<div class="row"><div class="medium-12 columns"><div class="alert alert-warning alert-center alert-small">Preencha o campo E-mail</div></div></div>');
            setTimeout(function() {
                        $("#login-return").html('');
                    }, 5000);
        } else if (password == '') {
            $("#login-return").html('<div class="row"><div class="medium-12 columns"><div class="alert alert-warning alert-center alert-small">Preencha o campo Senha</div></div></div>');
            setTimeout(function() {
                        $("#login-return").html('');
                    }, 5000);
        } else if (email != '' && password != '') {
            submit.html('<i class="fa fa-fw fa-cog fa-spin"></i>').attr('disabled', '');
            $.post(action, {email: email, password: password}, function(data, textStatus, xhr) {
                /* nothing */
            }).done(function(data) {
                if (data == "login_success") {
                    window.location.replace(base_url + "/profile");
                } else if (data == "login_error") {
                    $("#login-return").html('<div class="row"><div class="medium-12 columns"><div class="alert alert-warning alert-center alert-small">E-mail e senha não coicidem.<br>Tente novamente.</div></div></div>');

                    setTimeout(function() {
                        $("#login-return").html('');
                    }, 5000);
                }
            }).error(function() {

            }).always(function() {
                submit.html(submit_text).removeAttr('disabled', '');

                console.clear();
            });
        }

        return false;
    });
});