<?php
/**
 * Classe com metodos estáticos
 */
class Helper{

    /**
     * logado - Verifica se o usuário está logado
     *          pela variável de sessão logado
     *          Caso logado == true, pode acessar os conteúdos
     *          caso contrário, será direcionado 
     *          para a página de login
     * @return void
     */
    public static function logado(){
        // iniciar ambiente de sessão
        @session_start();
        //verificar se está logado
        if ($_SESSION['logado'] != true ) {
            // destruir a sessão
            // direcionar para a página de login
            session_destroy();
            header('location:login');
        }
    }

    /**
     * Verificar se é um adminsitrador
     * @param  int $nivel - 1:Usuario, 2:Administrador
     * @return void
     */
    public static function isAdministrador($nivel)
    {
        if($nivel != 2){
            //desloga o usuario
            $_SESSION['logado'] = false;
            //session_unset();
            //session_destroy();
            //envia o usuario para a pagina de login
            //header('login');
        }
    }

    /**
     * Retorna uma string com a primeira letra em Maiuscula
     *
     * @param string $palavra
     * @return string
     */
    public static function primeiraLetraMaiuscula($palavra)
    {
        return ucfirst(strtolower($palavra));
    }

    public static function dataBrasil($data)
    {
        $dt = new DateTime($data);
        return $dt->format('d/m/Y');
    }



    /**
     * Criptografa a informação passada como parametro
     * @param  string $id 
     * @return string
     */
    public static function encrypta($id)
    {
        // criar um $salt
        $salt  = date('zWd');
        $valor = $salt.$id.$salt;
        return base64_encode($valor);
    }

    /**
     * Descriptograr o Token
     * @param  string $token 
     * @return string
     */
    public static function decrypta($token)
    {
        // criar um $salt
        $salt  = date('zWd');
        $descriptografa = base64_decode($token);
        $valor          = str_replace($salt,"",$descriptografa);
        return $valor;

    }


}


?>