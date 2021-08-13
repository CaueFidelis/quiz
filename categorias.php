<?php
// Classes
require_once('inc/classes.php');
//verificar se é administrador
@session_start();
Helper::isAdministrador($_SESSION['nivel']);

// ESTANCIAR OS OBJETOS
 $objCategoria = new Categoria();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QUIZ - T86 - CATEGORIAS</title>
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
			<h1><i class="fas fa-align-justify"></i> CATEGORIAS - <a href="categoria-form.php" class="btn btn-primary"> Nova Categoria</a></h1>
			<table class="table table-striped">
			  <thead>
			    <tr>
			      <th>AÇÕES</th>
			      <th>Código</th>
			      <th>Categoria</th>
			    </tr>
			  </thead>

			  <tbody>
				<?php
				 $categorias = $objCategoria->listar();
				 foreach ($categorias as $categoria){
				?>
			    <tr>
			      <th>
			      	<?php if($categoria->id_categoria != 1){ ?>
			      		<a class="btn btn-success" href="categoria-form?id=<?php     echo Helper::encrypta($categoria->id_categoria); ?>"><i class="fas fa-edit"></i> Editar</a>
			      		<a class="btn btn-danger"  href="categoria-excluir?id=<?php  echo Helper::encrypta($categoria->id_categoria); ?>"><i class="fas fa-trash-alt"></i> Excluir</a>
			        <?php } ?>
			      </th>
			      <td><?php  echo $categoria->id_categoria; ?></td>
			      <td><?php  echo $categoria->categoria; ?></td>
			    </tr>
			    <?php
			      } // fecha o loop 
			    ?>

			  </tbody>
			</table>
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