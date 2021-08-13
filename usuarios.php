<?php
// Classes
require_once('inc/classes.php');
//verificar se é administrador
@session_start();
Helper::isAdministrador($_SESSION['nivel']);

// estanciar OBJ
$objUsuario = new Usuario();

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QUIZ - T86 - USUÁRIOS</title>
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
			<h1><i class="fas fa-users"></i> USUÁRIOS - <a href="usuario-cadastrar.php" class="btn btn-primary"> Novo Usuário</a></h1>

			<table class="table table-striped">
			  <thead>
			    <tr>
			      <th scope="col">AÇÕES</th>
			      <th scope="col">Nome</th>
			      <th scope="col">E-mail</th>
			      <th scope="col">Data de Nascimento</th>
			    </tr>
			  </thead>
			  <tbody>
				<?php
					$usuarios = $objUsuario->listar();
					foreach($usuarios as $usuario){
				?>
			    <tr>
			      <th scope="row">
			      	<a class="btn btn-success" href="usuario-editar.php?id=<?php echo $usuario->id_usuario;?>"><i class="fas fa-edit"></i> Editar</a>
			      	<a class="btn btn-danger"  href="#"><i class="fas fa-trash-alt"></i> Excluir</a>
			      </th>
			      <td><?php echo Helper::primeiraLetraMaiuscula($usuario->nome);?></td>
			      <td><?php echo $usuario->email;?></td>
			      <td><?php echo $usuario->nascimento;?></td>
			    </tr>
				<?php
					} //fecha o loop
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