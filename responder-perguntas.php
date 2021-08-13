<?php
// Classes
session_start();
require_once('inc/classes.php');
$objCategoria = new Categoria();
$objPergunta  = new Pergunta();
$objUsuario   = new Usuario();

$perguntaSorteada = '';
$resultado = '';
$mensagem  = '';
// verificar se uma categoria foi escolhida e sortear uma pergunta
if(isset($_POST['btnSortear'])){

	if($_POST['id_categoria'] != 0){
		$perguntaSorteada = $objPergunta->sortearPergunta($_POST['id_categoria']);
	}else{
		$perguntaSorteada = $objPergunta->sortearPergunta();
	}
}

// verificar se a resposta está correta
if(isset($_POST['btnResponder'])){
	$resultado = $objPergunta->verificarResposta($_POST['resposta'],$_SESSION['id_usuario']);
	$mensagem  = 'ok';
}



?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QUIZ - T86 - RESPONDER PERGUNTAS</title>
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
			<h1><i class="fas fa-question-circle"></i> RESPONDER PERGUNTAS </h1>
        </div>
        <?php
        //  CONTROLA DE MOSTRA O SORTEIO DA PERGUNTA OU A PERGUNTA
        //print_r($_SESSION);
        ?>
		<div class="col-md-12">
			<!-- MENSAGEM DE ACERTO OU ERRO -->
			<?php
				if($mensagem != ''){
			?>
			<div class="form-row">
				<?php
					if($resultado){
				?>
					<div class="col-md-12 alert alert-success">
						<strong>Parabéns ! Você acertou. Agora você tem
							<?php echo $objUsuario->pontuacao($_SESSION['id_usuario']);  ?>
							pontos 
						</strong>
					</div>
				<?php
				  } else {
				?>
					<div class="col-md-12 alert alert-danger">
						<strong>Lamento ! Você errou. Continua com 
							<?php echo $objUsuario->pontuacao($_SESSION['id_usuario']);  ?>
							pontos
						</strong>
					</div>
				<?php
					}
				?>
			</div>
			<?php
				} //fecha o if
			?>
			<!-- / MENSAGEM DE ACERTO OU ERRO -->

			<?php 
				if($perguntaSorteada == ''){
			?>
			<!-- /MOSTRA O SORTEIO DA PERGUNTA -->
			<form action="?" method="post" accept-charset="utf-8">
				<div class="form-row border rounded p-2">
					<div class="form-group col-md-3">
						<label class="font-weight-bold" for="id_categoria">Escolha a Categoria da Pergunta*</label>
						<select class="form-control" name="id_categoria" id="id_categoria" required>
						<option value="0">Qualquer Categoria</option>
						<?php
						$categorias = $objCategoria->listar();
						foreach($categorias as $categoria) {
							echo'<option value="'.$categoria->id_categoria.'">'.$categoria->categoria.'</option>';
						}
						?>
						</select>
					</div>
					<div class="form-group col-md-3">
						<label for="">&nbsp;</label>
						<input class="form-control btn btn-primary" type="submit" name="btnSortear" value="Sortear uma pergunta">
					</div>
				</div>
			</form>
		    <!-- /MOSTRA O SORTEIO DA PERGUNTA -->
			<?php
				} else {
					$opcoes = $objPergunta->opcoesDeResposta($perguntaSorteada->id_pergunta);
			?>
		    <!-- MOSTRA E PERGUNTA -->
		    <form action="?" method="post" accept-charset="utf-8">
		    	<div class="form-group col-md-12">
		    		<label class="font-weight-bold">Pergunta:</label>
					<p class="font-weight-bold"> <?php echo $perguntaSorteada->pergunta; ?> </p>
				</div>
				<div class="form-group col-md-12">
					<ol type="A">
						<?php
							$x = 1;
							foreach ($opcoes as $opcao) {
						?>
						<li>
							<div class="form-check">
							<input class="form-check-input" type="radio" name="resposta" id="opcao<?php echo $x;?>" value="<?php echo $opcao->id_alternativa; ?>"<?php if($x==1){ echo 'required'; } ?> >
							<label class="form-check-label" for="opcao<?php echo $x;?>">
							<?php echo $opcao->resposta ?>
						    </label>
							</div>
						</li>
					   <?php
					   		$x++;
							}
					   ?>

					</ol>
				</div>

		    	<div class="form-group col-md-3">
				 	<input class="form-control btn btn-warning" type="submit" name="btnResponder" value="Responder">
				</div>
		    </form>
		    <!-- /MOSTRA E PERGUNTA -->
		<?php } //fecha o else ?>
		</div>		
		<!-- /MOSTRA E PERGUNTA -->
		
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