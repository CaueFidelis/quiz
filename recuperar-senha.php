<?php
// iniciar as sessões
session_start();
// Classes
require_once('inc/classes.php');
    
    if(isset($_POST['btnRecupera'])){
        $objUsuario = new Usuario();
        $retorno = $objUsuario->recuperarSenha($_POST['email']);
        header('location:?'.$retorno);
    }

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QUIZ - T86 - RECUPERAR SENHA</title>
    <!-- CSS / ICONES -->
    <?php require_once('inc/css.php'); ?>

</head>
<body>
    <!-- CONTAINER -->
    <div class="container">
        <!-- CONTEUDO -->
        <div class="row mt-5">
        <div class="col-md-6 offset-md-3 border rounded p-2">
                <form action="?" method="post" accept-charset="utf-8">
                <div class="row" >
                    <div class="col-11">
                        <label for="email"><i class="fas fa-envelope" id="envelope"></i> Recuperar Senha</label>
                        <input class="form-control" type="email" name="email" id="email" value=""
                        placeholder="Digite seu e-mail cadastrado" required>
                    </div>

                    <div class="form-group col-12">
                        <input type="submit"  class="btn btn-outline-success mt-4" name="btnRecupera"
                        value="Recuperar Senha">
                    </div>
                    <?php
                    //  USUÁRIO NÃO LOCALIZADO
                    if( isset($_GET['e']) ){
                    echo '<div class="col-12 alert alert-danger">
                            E-mail não cadastrado!
                            </div>';
                    }
                    //  USUÁRIO BLOQUEADO
                    if( isset($_GET['b']) ){
                    echo '<div class="col-12 alert alert-danger">
                            Seu usuário está bloqueado, entre em contato com o Administrador!
                         </div>';
                    }
                    // NOVA SENHA ENVIADA POR E-MAIL
                    if( isset($_GET['s']) ){
                        echo '<div class="col-12 alert alert-success">
                            Uma nova senha foi enviada para o seu E-mail!
                            </div>';
                    }

                    ?>
                </div>
                </form>
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