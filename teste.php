<?php
session_start();
require_once('inc/classes.php');
// $objEmail = new Email();
// $objPergunta = new Pergunta();
// $pergunta = $objPergunta->sortearPergunta(2);
// $opcoes = $objPergunta->opcoesDeResposta($pergunta->id_pergunta);

// $msg   = 'Pergunta: '.$pergunta->pergunta.'<br>';

  // echo '<pre>';
  // echo 'Pergunta: '.$pergunta->pergunta.'<br>';
  // echo '<ol type="A">';
  // foreach ($opcoes as $resposta) {
  // 	echo '<li>';
  // 	echo '<input type="radio" name="resposta" value="'.$resposta->id_alternativa.'">';
  //   echo $resposta->resposta;
  //       $msg  .= 'Opcao: '.$resposta->resposta.'<br>' ;
  // 	echo '</li>';
  // }
  // echo '</ol>';
  // print_r($opcoes);
  // print_r($_SESSION);
  // echo '<hr>';
  	// echo 'Resposta: ';
  	// $a = $objPergunta->verificarResposta(100,$_SESSION['id_usuario']);
  	// if($a){
  	// 	echo 'ACERTOUUUU!!!!';
  	// }else{
  	// 	echo 'ERRROOOOUUUU!!!!';
  	// }
  // echo '</pre>';


//enviar a mensagem de teste
//$objEmail->enviar('alunos@t86.com.br','Alunos',$msg,'Pergunta do Quiz','thomas.melo@terra.com.br','Thomas');
//$objEmail->enviar('thomas.cmelo@sp.senac.br','Thomas Melo','<h1>teste turma 86</h1>');

// base64_encode // criptografa
// base64_decode // descriptografa
      // echo '<br>';
      echo '<pre>';
      // $salt2 = date('zsdYmdmWyds');
      // $salt1 = date('isYmdmzydiW');
      // $salt = array(
      //                 $salt1,
      //                 $salt2
      //              );
      // print_r($salt);

      $id = '11';
      // $token = base64_encode($salt1.$id.$salt2);
      $token = Helper::encrypta($id);
      echo $id;
      echo '<br>';
      echo $token;
      echo '<br>';
      // $descriptografa = base64_decode($token);
      $descriptografa = Helper::decrypta($token);
      echo $descriptografa;
      echo '<br>';
      
      // echo str_replace($salt,"",$descriptografa);
      echo '<br>';
      

      // $objUsuario->ativarUsuario($id);
      
      // $objUsuario = new Usuario();
      // $email = 'joze@joze.com.br';
      // echo '<h1>'.$objUsuario->recuperarSenha($email).'</h1>';

?>
