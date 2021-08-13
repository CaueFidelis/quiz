<?php
// Classes
require_once('inc/classes.php');
//verificar se é administrador
@session_start();
Helper::isAdministrador($_SESSION['nivel']);
// ESTANCIAR OS OBJETOS
$objPergunta  = new Pergunta();
$objCategoria = new Categoria();

$id_pergunta = $_GET['id'];
//  VERIFICAR SE O FORMULARIO FOI POSTADO
 if (isset($_POST['btnAtualizar'])){
 	$objPergunta->atualizar($_POST['id_pergunta'],$_POST);
 	//die();
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
	   <h3> <i class="fas fa-align-justify"></i> EDIÇÃO DE PERGUNTA</h3>
	   <?php
	   		$pergunta = $objPergunta->mostrarPergunta($id_pergunta);
	   		$respostaCorreta = $objPergunta->mostrarAlternativaCorreta($id_pergunta);
	   		$respostasErradas= $objPergunta->mostrarAlternativasErradas($id_pergunta);
	    ?>
	</div>

<div class="card-body">
<form action="?" method="post" accept-charset="utf-8" enctype="multipart/form-data">
<!-- OCULTO -->
<input type="hidden" name="id_usuario"  value="<?php echo $_SESSION['id_usuario'];?>">
<input type="hidden" name="id_pergunta" value="<?php echo $id_pergunta;?>">

<!-- OCULTO -->
<div class="form-row">
	<div class="form-group col-md-3">
		<label for="id_categoria">Categoria*</label>
		<select class="form-control" name="id_categoria" id="id_categoria" required>
			<?php
				$categorias = $objCategoria->listar();
				foreach ($categorias as $categoria){
			?>
			<option value="<?php echo $categoria->id_categoria;?>"
				<?php
					if($categoria->id_categoria == $pergunta->id_categoria){
						echo ' selected="selected" ';
					}
				 ?>
			>
				<?php echo $categoria->categoria;?>
			</option>
			<?php
			 } //fecha o loop
			?>
		</select>
	</div>

	<div class="form-group col-md-12">
		<labe for="pergunta">Pergunta*</label>
		<input class="form-control" type="text" name="pergunta" id="pergunta" value="<?php echo $pergunta->pergunta;?>" required="">
	</div>

	<div class="form-group col-md-12">
		<labe for="correta">Resposta Correta*</label>
		<input class="form-control" type="text" name="correta" id="correta" value="<?php  echo $respostaCorreta->resposta ;?>" required="">
	</div>

	<?php
		$x = 1;
		foreach($respostasErradas as $respostaErrada) {
	?>
	<div class="form-group col-md-12">
		<labe for="errada[<?php echo $respostaErrada->id_alternativa;?>]">Opção Errada <?php echo $x;?>*</label>
		<input class="form-control" type="text"
						name="errada[<?php echo $respostaErrada->id_alternativa;?>]"
						id="errada[<?php echo $respostaErrada->id_alternativa;?>]"
						value="<?php echo $respostaErrada->resposta ?>"
						required="">
	</div>
	<?php
		$x++;
	   } //fecha o loop
	?>

	<input class="btn btn-primary" type="submit" name="btnAtualizar" value="Atualizar">

</div>
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