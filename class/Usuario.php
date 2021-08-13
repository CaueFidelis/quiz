<?php

class Usuario
{

    protected $salt;
    protected $pdo;

     function __construct()
     {
         $this->pdo  = Conexao::conexao();
         $this->salt = 'Batata123';
     }


     /**
      * listar
      *
      * @return array
      */
     public function listar()
     {
         $sql = $this->pdo->prepare('SELECT * FROM usuarios ORDER BY nome');
         $sql->execute();
         return $sql->fetchAll(PDO::FETCH_OBJ);
     }

     /**
      * cadastrar
      *
      * @param array $dados
      * @return int - id_usuario
      */
     public function cadastrar($dados)
     {
         $sql = $this->pdo->prepare('INSERT INTO usuarios
                                    (nome, email, senha, nascimento, nivel_acesso)
                                    VALUES
                                    (:nome, :email, :senha, :nascimento, :nivel_acesso)
                                  ');
        //tratar os dados
        $nome  = strtoupper(trim($dados['nome']));
        $email = strtolower(trim($dados['email']));
        $nascimento = trim($dados['nascimento']);
        $senha = crypt($dados['senha'],$this->salt);
        $nivel_acesso = 2; //  1- Usuário | 2 - Administrador

        $sql->bindParam(':nome',$nome);
        $sql->bindParam(':email',$email);
        $sql->bindParam(':nascimento',$nascimento);
        $sql->bindParam(':senha',$senha);
        $sql->bindParam(':nivel_acesso',$nivel_acesso);

        $sql->execute();

        //pegar o id do usuário - ou a PK do registro
        return $this->pdo->lastInsertId();

     }

     /**
     * nomeUsuario - retorna nome
     * @param  int $id_usuario
     * @return string
     */
    public function nomeUsuario($id_usuario)
    {
        //montar o SELECT ou o SQL
        $sql = $this->pdo->prepare('SELECT nome FROM usuarios
                                     WHERE id_usuario = :id_usuario
                                   ');
        //mesclar os dados/atributos
        $sql->bindParam(':id_usuario',$id_usuario);
        //executar o SQL
        $sql->execute();
        //retornart os dados
        $usuario = $sql->fetch(PDO::FETCH_OBJ);

        return $usuario->nome;

    }


    /**
     * pontuacao - retorna pontuação do usuário
     * @param  int $id_usuario
     * @return int
     */
    public function pontuacao($id_usuario)
    {
        //montar o SELECT ou o SQL
        $sql = $this->pdo->prepare('SELECT pontuacao FROM usuarios
                                     WHERE id_usuario = :id_usuario
                                   ');
        //mesclar os dados/atributos
        $sql->bindParam(':id_usuario',$id_usuario);
        //executar o SQL
        $sql->execute();
        //retornart os dados
        $usuario = $sql->fetch(PDO::FETCH_OBJ);

        return $usuario->pontuacao;

    }

    /**
     * Mostra a lista de usuários ordenada por pontuacao
     * @return array
     */
    public function classificacao()
    {
       $sql = $this->pdo->prepare('SELECT nome, pontuacao FROM usuarios ORDER BY pontuacao DESC');
       $sql->execute();
       return $sql->fetchall(PDO::FETCH_OBJ); 
    }


/*
* ------------------------------------------------
*  AREA DE METODOS REFERENTES AO LOGIN
* ------------------------------------------------
*/

    /**
     * logar 
     * @param  string $email 
     * @param  string $senha 
     * @return bool true || false        
     */
    public function logar($email,$senha)
    {
        $senhaCriptografada = crypt($senha,$this->salt);
        $email = trim(strtolower($email));

       //Criar o SQL
       $sql = $this->pdo->prepare('
                                 SELECT * FROM usuarios
                                 WHERE
                                    email = :email
                                 AND
                                    senha = :senha
                                 ');
        //Mesclar os dados
        $sql->bindParam(':email',$email);
        $sql->bindParam(':senha',$senhaCriptografada);

        //executar
        $sql->execute();

        //verificar se retorna algum registro
        if($sql->rowCount() == 1){
            //pegar os dados retornados
            $resultado = $sql->fetch(PDO::FETCH_OBJ);
            // verificar se o usuario está ativo
            if( $resultado->ativo == 1 ){
                //criar as sessões
                $_SESSION['usuario']    = $resultado->nome;
                $_SESSION['id_usuario'] = $resultado->id_usuario;
                $_SESSION['nivel']      = $resultado->nivel_acesso;
                $_SESSION['logado']     = true;
                return true;
            } else {
                $_SESSION['logado']      = false;
                $_SESSION['usuario']     = $resultado->nome;
                $_SESSION['msgBloqueio'] = 'Seu acesso está bloqueado, procure o administrador!';
                return false;
            }
            //vai retornar TRUE, pois deu tudo certo
            
        }else{
            //destruir as variáveis de sessão
            $_SESSION['logado'] = false;
            session_unset(); // desregistrar
            session_destroy(); // destruir
            return false;
        }
    }


    /**
     * bloquear Usuario
     * @param  int $id_usuario
     * @return void
     */
    public function bloquearUsuario($id_usuario)
    {
        $sql = $this->pdo->prepare('UPDATE usuarios
                                    SET ativo = :ativo
                                    WHERE id_usuario = :id_usuario
                                    ');
        $ativo = 0;
        $sql->bindParam(':id_usuario',$id_usuario);
        $sql->bindParam(':ativo',$ativo);
        $sql->execute();
    }

    /**
     * desbloquear Usuario
     * @param  int $id_usuario
     * @return void
     */
    public function desbloquearUsuario($id_usuario)
    {
        $sql = $this->pdo->prepare('UPDATE usuarios
                                    SET ativo = :ativo
                                    WHERE id_usuario = :id_usuario
                                    ');
        $ativo = 1;
        $sql->bindParam(':id_usuario',$id_usuario);
        $sql->bindParam(':ativo',$ativo);
        $sql->execute();
    }


    /**
     * ativar Usuario
     * @param  string $token - id do usuário criptografado
     * @return true || false  
     */
    public function ativarUsuario($token)
    {
        $id_usuario = intval(base64_decode($token)); // descriptografa
        //verificar se é um número inteiro
        if( ! is_int($id_usuario) ){
            return false;
         }
        
        $sql = $this->pdo->prepare('UPDATE usuarios
                                    SET ativo = :ativo
                                    WHERE id_usuario = :id_usuario
                                    ');
        $ativo = 1;
        $sql->bindParam(':id_usuario',$id_usuario);
        $sql->bindParam(':ativo',$ativo);
        $sql->execute();

        if($sql->rowCount() == 1){
                return true;
        }else{
                return false;
        }
        // base64_encode // criptografa
        // base64_decode // descriptografa
    }

    /**
     * recuperar Senha
     * @param  string $email
     * @return string  - (E) para usuário não localizado, (B) para usuário bloqueado , (S) - sucesso
     */
    public function recuperarSenha($email)
    {
        $email = strtolower(trim($email));

        $sql = $this->pdo->prepare('SELECT * FROM usuarios
                                    WHERE email = :email
                                  ');
        $sql->bindParam(':email',$email);
        $sql->execute();

        // verificar se o e-mail está cadastrado
        // se o resultado for menor que 1, não possui cadastro
        if($sql->rowCount() < 1){
            return 'e';
        }
        //possui cadastro.
        $usuario = $sql->fetch(PDO::FETCH_OBJ);
        // verificar se está bloqueado
        if($usuario->ativo == 0){
            return 'b';
        }else{
            // gerar uma nova senha
            $novaSenha = date('His');
            $senha = crypt($novaSenha,$this->salt);
            //atualizar a senha do usuario
            $sqlAtualizar = $this->pdo->prepare('UPDATE usuarios SET
                                                 senha = :senha
                                                 WHERE id_usuario = :id_usuario
                                                 ');
            $sqlAtualizar->bindParam(':senha',$senha);
            $sqlAtualizar->bindParam(':id_usuario', $usuario->id_usuario);
            $sqlAtualizar->execute();

            // enviar o e-mail para o usuário
            $objEmail = new Email();

            //Montar a Mensagem
            $msg  = 'Olá '.$usuario->nome.'<br>';
            $msg .= 'Sua nova senha é: '.$novaSenha.'<br>';
            $msg .= 'Equipe T86';

            // enviar a MSG
            $objEmail->enviar(
                               'site@quizt86.com.br',
                                'Quiz T86',
                                $msg,
                                'Recuperação de Senha - Quiz T86',
                                $email,
                                $usuario->nome
                            );
            return 's';

        }

    }


    


} //fecha a classe
?>