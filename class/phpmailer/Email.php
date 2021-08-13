<?php
/**
 * @ ATENÇÃO  Requer a classe phpmailer
 */
include_once("Phpmailer.php");
 /**
 * @name Email
 * @author THOMAS MELO
 * @date 10/04/2013
 */

//  CRIAR CONTANTES
define("SMTP",     		"smtp.mailtrap.io");
define("USERNAMEEMAIL", "480955ed078635");
define("SENHAEMAIL", 	"1f9e36d668edec");
define("EMAIL", 		"contato@turma86.com.br");

class Email{
	
	### ATRIBUTOS
	public 		$mailer;
	protected 	$smtp;
	protected 	$username;
	protected 	$senha;
	
	### CONSTRUTOR PADRÃO #######################
	public function __construct(){
		$this->smtp 	= SMTP;
		$this->username = USERNAMEEMAIL;
		$this->senha	= SENHAEMAIL;
		$this->mailer = new PHPMailer();
		$this->mailer->IsSMTP();	// Informando a classe para usar SMTP
		$this->mailer->IsHTML(true);
		$this->mailer->CharSet 		= 'UTF-8'; // Charset da mensagem (opcional)

		//configuração do host e smtp
		$this->mailer->SMTPAuth 	= true;  			// Ativar a autenticação SMTP
		$this->mailer->Host       	= $this->smtp;  	// servidor de SMTP
		$this->mailer->Port       	= 2525;          	// Porta de envio
		$this->mailer->Username   	= $this->username; 	// usuario para autenticação no servidor smtp
		$this->mailer->Password   	= $this->senha;		// senha do usuario para autenticação

		$this->mailer->SMTPDebug 	= 2;				// Ativar SMTP depuração
														// 0 = off (para uso em produção)
														// 1 = mensagens do cliente
														// 2 = cliente e servidor
		
		//configuração do e-mail padrão de envio
		// Define o endereço de email de onde vai partir da mensagem
		// Em geral é igual ao Username
		$this->mailer->SetFrom(EMAIL, 'Turma 86');
		
	}
	#### FECHA CONSTRUTOR PADRÃO ###################
	
	###  METODO DE ENVIO #####################
	/**
	 * @name enviar
	 * @access public
	 * @date 10/04/2013
	 * @author THOMAS MELO
	 * @param $emailPara		- STRING - E-mail que irá receber a mensagem
	 * @param $nomePara			- STRING - Nome de quem irá receber a mensagem
	 * @param $emailParaResposta- STRING - E-mail que está enviando a mensagem, que deverá receber a resposta da mensagem
	 * @param $nomeParaResposta	- STRING - Nome de quem mandou a mensagem e receberá a resposta
	 * @param $assunto			- STRING - Assunto do Email
	 * @param $mensagen			- STRING - Corpo do Email
	 * @return void
	 */	

	public function enviar(
							$emailParaResposta,
							$nomeParaResposta,
							$mensagem,
							$assunto="Contato Pelo Site",
							$emailPara='site@turma86.sitedeteste.com.br',
							$nomePara="Turma 86",
							$anexo=""){

		//configurar o e-mail de resposta (ReplyTo)
		$this->mailer->AddReplyTo($emailParaResposta,$nomeParaResposta);

		//configurar o e-mail que está enviando a mensagem (To)
		$this->mailer->AddAddress($emailPara,$nomePara);

		//assunto
		$this->mailer->Subject    = $assunto;

		//texto alternativo, caso o leitor de e-mail não suporte html
		$this->mailer->AltBody    = "Para ver a mensagem, por favor use um visualizador de e-mail compatível com HTML!"; // optional, comment out and test

		// mensagem em HTML
		$this->mailer->MsgHTML($mensagem);

		//verificar se existe um anexo
		if($anexo!=''){
			$dir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/arquivos/';
			$a = $this->anexar($anexo, $dir);
			$this->mailer->AddAttachment($a);
		}

		//realizar o envio
		$resultado = $this->mailer->Send();
		//print_r($this->mailer);
		//limpar os campos de remententes e anexos
		$this->mailer->ClearAddresses();
		$this->mailer->ClearAllRecipients();
		$this->mailer->ClearReplyTos();
		$this->mailer->ClearAttachments();
		return $resultado;
	}
	### FECHA METODO DE ENVIO #####################

	### METODO PARA ANEXAR ARQUIVO #################
	/*
    * @name: anexar
    * @author: Thomas Melo
    * @date 10/04/2013
    * @access public
    * @param String $arquivo	- campo vindo do formulario $_FILES[]
    * @param String $diretorio	- caminho da pasta onde o arquivo sera armazenado
	*							Ex.: arquivos ou banners
    * @return String 			diterorio/arquivo
    */
    public function anexar($arquivo, $diretorio ="uploads/arquivos"){

        $extensao = substr($arquivo['name'], -4);
		//verifica se a extensao e do tipo docx, xlsx, etc
		if($extensao[0] == '.'){
			$extensao = substr($arquivo['name'], -3);
		}else{
			$extensao = $extensao;
		}
		//o arquivo recebera como nome a data e hora ddmmaaaammss
        $arquivo['name'] = date('dmYHis') . '.' . $extensao;
        $uploadfile = $diretorio.'/'.$arquivo['name'];
		//o arquivo recebera como nome a data e hora ddmmaaaammss
        // $arquivo['name'] = date('dmYHis') . '.' . $extensao;
        // $uploadfile = "$diretorio/$arquivo[name]";
		chmod ($uploadfile, 0755);

        move_uploaded_file($arquivo['tmp_name'], $uploadfile);
		chmod($uploadfile, 0664);
		return $uploadfile;
    }
	### FIM PARA METODO ANEXAR ARQUIVO #############

}//fecha a classe
?>