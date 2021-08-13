<?php
// iniciar as sessões
session_start();
// Classes
require_once('inc/classes.php');
// Estancia OBJ
    if(isset($_POST['btnLogar'])){
        $objUsuario = new Usuario();
        //verificar se o login está correto
        if( $objUsuario->logar($_POST['email'],$_POST['senha']) ){
            header('location:classificacao.php');
        }else{
            //verificar se o login não foi realizado,
            //porque o usuário está bloqueado
            if(isset($_SESSION['msgBloqueio'])){
                header('location:?b');
            }else{
                header('location:?e');
            }

        }

    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QUIZ - T86</title>
    <!-- CSS / ICONES -->
    <?php require_once('inc/css.php'); ?>

</head>
<body>
    <!-- CONTAINER -->
    <div class="container">
        <!-- TOPO -->
        <?php //require_once('inc/topo.php'); ?>       
        <!-- /TOPO -->
        <!-- CONTEUDO -->
        <div class="row mt-5"> 
        <div class="col-md-6 offset-md-3 border rounded p-2">    
                <form action="?" method="post" accept-charset="utf-8">
                <div class="row" >
                    <div class="col-11">
                        <label for="email"><i class="fas fa-envelope" id="envelope"></i> Login</label>
                        <input class="form-control" type="email" name="email" id="email" value="" placeholder="Digite seu e-mail, ele é o seu login" required>
                    </div>

                    <div class="col-11">
                        <label for="senha"><i class="fas fa-lock" id="cadeado"></i> Senha</label>
                        <input  class="form-control" type="password" name="senha" id="senha" value="" placeholder="Digite a sua senha" required="">
                    </div>

                    <div class="form-group col-12">
                        <input type="submit"  class="btn btn-success mt-4" name="btnLogar" value="Entrar agora">
                        <a class="btn btn-info mt-4 ml-1" href="novo-usuario.php"> Não tenho cadastro</a>
                        <a class="btn btn-warning mt-4"   href="recuperar-senha.php"> Esqueci minha senha</a>
                    </div>
                    <?php
                    // Mensagem se o usuário ou senha estiver errado
                    if( isset($_GET['e']) ){
                        echo '<div class="col-12 alert alert-danger">
                            Usuário ou Senha inválido!
                            </div>';
                    }
                    // Mensagen se o usuário estiver bloqueado
                    if( isset($_GET['b']) ){
                        echo '<div class="col-12 alert alert-danger">';
                            echo $_SESSION['usuario'].'<br>';
                            echo $_SESSION['msgBloqueio'];
                        echo '</div>';
                    }
                    // Mensagem se o tentou acessar uma área proibida
                    if( isset($_GET['n']) ){
                        echo '<div class="col-12 alert alert-danger">
                            Acesso Negado, Apenas administradores podem acessar!
                            </div>';
                    }
                    // Mensagemn se o usuário saiu
                    if( isset($_GET['s']) ){
                        echo '<div class="col-12 alert alert-success">
                            Fechado com Sucesso!
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