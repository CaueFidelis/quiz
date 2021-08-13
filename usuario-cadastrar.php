<?php
// Classes
require_once('inc/classes.php');
//verificar se é administrador
@session_start();
Helper::isAdministrador($_SESSION['nivel']);

	// verificar se o formulario foi postado
	if(isset($_POST['btnCadastrar'])){
			$objUsuario = new Usuario();
			$id_usuario = $objUsuario->cadastrar($_POST);
			header('location:usuarios?'.$id_usuario);
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
        <?php require_once('inc/topo.php'); ?>       
        <!-- /TOPO -->
        <!-- CONTEUDO -->
        <div class="col-md-12">
			<div class="card">
			  <div class="card-header">
			    <h3><i class="fas fa-users"></i> CADASTRO DE USUÁRIO</h3>
			  </div>
			
				<div class="card-body">
					<form action="?" method="post" accept-charset="utf-8"  enctype="multipart/form-data">
						<div class="form-row">
							<div class="form-group col-md-6">
								<label for="nome">Nome*</label>
								<input  class="form-control" type="text" id="nome" name="nome" value="" required>
							</div>
							<div class="form-group col-md-6">
								<label for="email">E-mail*</label>
								<input  class="form-control" type="email" id="email" name="email" value="" required>
							</div>
							<div class="form-group col-md-4">
								<label for="senha">Senha*</label>
								<input  class="form-control" type="password" id="senha" name="senha" value="" required>
							</div>

							<div class="form-group col-md-4">
								<label for="confirmaSenha">Confirma Senha*</label>
								<input  class="form-control" type="password" id="confirmaSenha" name="confirmaSenha" value="" required>
							</div>

							<div class="form-group col-md-4">
								<label for="nascimento">Data de Nascimento</label>
								<input  class="form-control" type="date" id="nascimento" name="nascimento" value="">
							</div>
							<span id="alerta" class="col-md-12 alert alert-danger">
								<strong>As senhas não conferem! Digite Novamente!</strong>
							</span>

							<div class="form-group col-md-2">
								<labe>&nbsp;</label>
								<input class="form-control btn btn-success mt-1" type="submit" name="btnCadastrar" value=" Cadastrar">
							</div>
						</div>
					</form>
				</div>

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