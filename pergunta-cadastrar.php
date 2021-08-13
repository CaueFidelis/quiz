<?php
// Classes
require_once('inc/classes.php');
//verificar se é administrador
@session_start();
Helper::isAdministrador($_SESSION['nivel']);

// ESTANCIAR OS OBJETOS
$objPergunta  = new Pergunta();
$objCategoria = new Categoria();

// VERIFICAR SE O FORMULARIO FOI POSTADO
 if(isset($_POST['btnCadastrar'])){
 	$objPergunta->cadastrar($_POST);
 	header('location:perguntas.php');
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

<!-- CONTEUDO -->
<div class="col-md-12">
<div class="card">
	<div class="card-header">
	   <h3> <i class="fas fa-align-justify"></i> CADASTRO DE PERGUNTA</h3>
	</div>

<div class="card-body">

<form action="?" method="post" accept-charset="utf-8" enctype="multipart/form-data">
<!-- OCULTO -->
<input type="hidden" name="id_usuario" value="<?php echo $_SESSION['id_usuario'] ?>">
<!-- OCULTO -->
<div class="form-row">
	<div class="form-group col-md-3">
		<label for="id_categoria">Categoria*</label>
		<select class="form-control" name="id_categoria" id="id_categoria" required>
		<?php
		$categorias = $objCategoria->listar();
		
		foreach($categorias as $categoria) {
			echo'<option value="'.$categoria->id_categoria.'">'.$categoria->categoria.'</option>';
		}

		?>
		</select>
	</div>

	<div class="form-group col-md-12">
		<labe for="pergunta">Pergunta*</label>
		<input class="form-control" type="text" name="pergunta" id="pergunta" value="" required="">
	</div>

	<div class="form-group col-md-12">
		<labe for="correta">Resposta Correta*</label>
		<input class="form-control" type="text" name="correta" id="correta" value="" required="">
	</div>
	<div class="form-group col-md-12">
		<labe for="errada[1]">Opção Errada 1*</label>
		<input class="form-control" type="text" name="errada[1]" id="errada[1]" value="" required="">
	</div>
	<div class="form-group col-md-12">
		<labe for="errada[2]">Opção Errada 2*</label>
		<input class="form-control" type="text" name="errada[2]" id="errada[2]" value="" required="">
	</div>
	<div class="form-group col-md-12">
		<labe for="errada[3]">Opção Errada 3*</label>
		<input class="form-control" type="text" name="errada[3]" id="errada[3]" value="" required="">
	</div>
	<div class="form-group col-md-12">
		<labe for="errada[4]">Opção Errada 4*</label>
		<input class="form-control" type="text" name="errada[4]" id="errada[4]" value="" required="">
	</div>
	<div class="form-group col-md-12">
		<labe for="errada[5]">Opção Errada 5*</label>
		<input class="form-control" type="text" name="errada[5]" id="errada[5]" value="" required="">
	</div>
	<div class="form-group col-md-12">
		<labe for="errada[6]">Opção Errada 6*</label>
		<input class="form-control" type="text" name="errada[6]" id="errada[6]" value="" required="">
	</div>
	<div class="form-group col-md-12">
		<labe for="errada[7]">Opção Errada 7*</label>
		<input class="form-control" type="text" name="errada[7]" id="errada[7]" value="" required="">
	</div>
	<div class="form-group col-md-12">
		<labe for="errada[8]">Opção Errada 8*</label>
		<input class="form-control" type="text" name="errada[8]" id="errada[8]" value="" required="">
	</div>
</div>

 <input class="btn btn-primary" type="submit" name="btnCadastrar" value="Cadastrar">

</form>
</div>

</div>
</div>


<!-- /CONTEUDO -->
<!-- RODAPE -->
<?php //require_once('inc/rodape.php'); ?>
<!-- /RODAPE -->
</div>
<!-- /CONTAINER -->
</body>
<!-- JS -->
<?php require_once('inc/js.php'); ?>

</html>