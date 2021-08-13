<?php
// Classes
require_once('inc/classes.php');
//verificar se é administrador
@session_start();
Helper::isAdministrador($_SESSION['nivel']);

// ESTANCIAR OS OBJETOS
 $objCategoria = new Categoria();


//  VERIFICAR SE O FORMULARIO FOI POSTADO 
//  E SE É UMA EDIÇÃO OU CADASTRO
if(isset($_POST['btnCadastrar'])){

	$objCategoria->cadastrar($_POST);
	header('location:categorias.php');
}

if(isset($_POST['btnAtualizar'])){
	$objCategoria->editar($_POST);
	header('location:categorias.php');
}


 //  verificar se existe a variavel GET[id]
 //  se ela existir, uma categoria está sendo editada
 //  senão, uma categoria está sendo criada
 
 if(isset($_GET['id']) ){
 	$edicao    = true;
 	$categoria = $objCategoria->show($_GET['id']);
 }else{

 	$edicao = false;
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
			    <h3> <i class="fas fa-align-justify"></i> 
			    <?php 
			    if($edicao){
			    	echo 'EDIÇÃO';
			    }else{
			    	echo 'CADASTRO';
			    }
			    ?> 
			    DE CATEGORIA</h3>
			  </div>
			
				<div class="card-body">
					<form action="?" method="post" accept-charset="utf-8">
                        <!-- OCULTO -->
                        <?php
                        	if($edicao){
                        		echo '<input type="hidden" name="id_categoria" value="'.$_GET['id'].'">';
                        	}
                        ?>
                        <!-- OCULTO -->
						<div class="form-row">
							<div class="form-group col-md-6">
								<label for="categoria">Categoria</label>
								<input  class="form-control" type="text" id="categoria" name="categoria" 
								<?php
										// if() o que será feito se verdadeiro 
										// ternario
										// if()else() em uma unica linha
										// (condição) ? ( o que fazer se verdadeiro ) : ( o que fazer se falso )
										 ($edicao)?( print 'value="'.$categoria->categoria.'"'):(print 'value=""');
										?>
								required >
							</div>
							<div class="form-group col-md-2">
								<labe>&nbsp;</label>
								<?php 
								    if($edicao){
								    	echo '<input class="form-control btn btn-warning mt-1" type="submit" name="btnAtualizar" value=" Atualizar">';
								    }else{
								    	echo '<input class="form-control btn btn-success mt-1" type="submit" name="btnCadastrar" value=" Cadastrar">';
								    }
							    ?>
					
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