<?php
// iniciar as sessões
session_start();
// Classes
require_once('inc/classes.php');
$objUsuario = new Usuario();

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QUIZ - T86 - ATIVAR USUÁRIO</title>
    <!-- CSS / ICONES -->
    <?php require_once('inc/css.php'); ?>

</head>
<body>
    <!-- CONTAINER -->
    <div class="container">
        <!-- CONTEUDO -->
        <div class="row mt-5">
            <div class="col-md-6 offset-md-3 border rounded p-2">
                <?php
                    if( $objUsuario->ativarUsuario($_GET['token']) ){
                ?>
                <p class="alert alert-success"> Cadastro ativado com Sucesso! </p>
                <p> <a href="login.php"> Acesse agora !</a> </p>
                <?php
                    }else{
                ?>
                    <p class="alert alert-danger"> Código de ativação inválido !</p>
                <?php
                    } //fecha o else
                ?>
            </div>
        </div>
        <!-- /CONTEUDO -->
        <!-- RODAPE -->
        <?php require_once('inc/rodape.php'); ?>
        <!-- /RODAPE -->
    </div>
    <!-- /CONTAINER -->
</body>
<!-- JS -->
<?php require_once('inc/js.php'); ?>

</html>