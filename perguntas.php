<?php
// Classes
require_once('inc/classes.php');
//verificar se é administrador
@session_start();
Helper::isAdministrador($_SESSION['nivel']);

$objCategoria = new Categoria();
$objPergunta  = new Pergunta();
$objUsuario   = new Usuario();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QUIZ - T86 - PERGUNTAS</title>
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
			<h1><i class="fas fa-question-circle"></i> PERGUNTAS <a href="pergunta-cadastrar.php" class="btn btn-primary"> Nova Pergunta</a></h1>
			<table class="table table-striped">
			  <thead>
			    <tr>
			      <th scope="col">AÇÕES</th>
			      <th scope="col">Pergunta</th>
			      <th scope="col">Categoria</th>
			      <th scope="col">Criador</th>
			    </tr>
			  </thead>
			  <tbody>
				<?php 
					$perguntas = $objPergunta->listar();
					foreach ($perguntas as $pergunta){
				?>
			    <tr>
			      <th scope="row">
			      	<a class="btn btn-warning" href="pergunta-opcoes.php?id=<?php echo $pergunta->id_pergunta; ?>"><i class="fas fa-filter"></i> Opções</a>
			      	<?php 
			      	  if ($_SESSION['id_usuario'] == $pergunta->id_usuario) {
			      	?>
			      	<a class="btn btn-danger"  href="#"><i class="fas fa-trash-alt"></i> Excluir</a>
			      	<a class="btn btn-success" href="pergunta-editar.php?id=<?php echo $pergunta->id_pergunta; ?>"><i class="fas fa-edit"></i> Editar</a>
			      	<?php
			      	} //fecha o if 
			      	?>
			      </th>
			      <td><?php echo $pergunta->pergunta ;?></td>
			      <td><?php echo $objCategoria->nomeCategoria($pergunta->id_categoria) ;?></td>
			      <td><?php echo $objUsuario->nomeUsuario($pergunta->id_usuario) ;?></td>
			    </tr>
			    <?php 
			    	} //fecha o loop
			    ?>
			  </tbody>
			</table>

			
		</div>
        <!-- /CONTEUDO -->
        <!-- RODAPE -->
        <?php //require_once('inc/rodape.php'); ?>
        <!-- /RODAPE -->
    </div>
    <!-- /CONTAINER -->    
</body>
<!-- JS -->
<?php
	
	require_once('inc/js.php');
?>

</html>