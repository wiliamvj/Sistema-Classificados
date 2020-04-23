<!-- Sistema desenvolvido por Wiliam Joaquim, sua distribuição não é autorizada! -->

﻿<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="google-site-verification" content="vSNBXv699WAJVLEgzZX4Hlo51pOcDm3rMz6sbB8bs7U" />

<title>Admin | your-site</title>
<link rel="shortcut icon" type="image/png" href="httsp://your-site.com.br/assets/img/favicon.png" />
<!-- css -->
<link href="<?=base_url('assets/font-awesome/css/font-awesome.min.css')?>" rel="stylesheet">
<link href="<?=base_url('assets/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet">
<link href="<?=base_url('assets/css/styles.css')?>" rel="stylesheet">

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

<!-- js -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="<?=base_url('assets/bootstrap/js/bootstrap.min.js')?>"></script>
<script src="<?=base_url('assets/js/vendor/pace.min.js')?>"></script>
<script src="<?=base_url('assets/js/vendor/jquery.dataTables.min.js')?>"></script>
<script src="<?=base_url('assets/tinymce/tinymce.min.js')?>"></script>
<script src="<?=base_url('assets/js/vendor/foneMascara.min.js')?>"></script>
<script src="<?=base_url('assets/js/vendor/jquery.mask.min.js')?>"></script>
<script src="<?=base_url('assets/js/system.js')?>"></script>
<script>
    function fields(pagina, janela) {
                //$("#janela_" + janela).empty();
                $("#carregandoJanela_" + janela).show();

                setTimeout(function() {
                    $("#janela_" + janela).load(pagina);
                    $("#carregandoJanela_" + janela).hide();


                }, 1000);
            }
</script>