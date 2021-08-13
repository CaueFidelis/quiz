<?php
// Classes
require_once('inc/classes.php');
$objUsuario   = new Usuario();

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QUIZ - T86 - CLAFISSICAÇÃO</title>
    <!-- CSS / ICONES -->
    <?php require_once('inc/css.php'); ?>

</head>
<body>
    <!-- CONTAINER -->
    <div class="container">
        <!-- TOPO -->
        <?php require_once('inc/topo.php'); ?>       
        <!-- /TOPO -->
        <!-- CONTEUDO -->
        <div class="col-md-12">
            <h1><i class="fas fa-trophy"></i> Classificação</h1>
            <ol>
                <?php
                    $classificacao = $objUsuario->classificacao();
                    foreach ($classificacao as $classificado) {
                        echo '<li>'.$classificado->nome.' - '.$classificado->pontuacao.' pontos</li>';
                    }
                ?>
            </ol>
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