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

$pergunta = $objPergunta->mostrarPergunta($id_pergunta);
$respostaCorreta = $objPergunta->mostrarAlternativaCorreta($id_pergunta);
$respostasErradas= $objPergunta->mostrarAlternativasErradas($id_pergunta);


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
	   <h3> <i class="fas fa-align-justify"></i>PERGUNTA E ALTERNATIVAS DE RESPOSTA</h3>
	</div>

<div class="card-body">

<div class="form-row">
	<div class="form-group col-md-3">
		<label><strong>Categoria:</strong>
			<?php echo $objCategoria->nomeCategoria($pergunta->id_categoria) ;?>
		</label>
	</div>
	<div class="form-group col-md-12">
		<label><strong>Pergunta:</strong></label>
		<p><?php echo $pergunta->pergunta;?></p>
	</div>
	<div class="form-group col-md-12">
		<label><strong>Resposta Correta:</strong></label>
		<p><?php  echo $respostaCorreta->resposta ;?> </p>
	</div>
	<?php
		$x = 1;
		foreach($respostasErradas as $respostaErrada) {
	?>
	<div class="form-group col-md-12">
		<label><strong>Opção Errada <?php echo $x;?></strong></label>
		<p><?php echo $respostaErrada->resposta ?></p>
	</div>
	<?php
		$x++;
	   } //fecha o loop
	?>
</div>

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