<?php
 class Pergunta {

    protected $pdo;

    function __construct()
    {
        $this->pdo = Conexao::conexao();
    }


    	/**
    	 * cadastrar
    	 * @param  array $dados - Todos os campos do formulario
    	 *                         enviados por $_POST
    	 * @return int   - PK do registro inserido no banco
    	 */
    	public function cadastrar($dados)
    	{
    		//SQL
			$sqlPergunta = $this->pdo->prepare('
									    INSERT INTO perguntas
									    (id_usuario, id_categoria, pergunta)
									    values
									    (:id_usuario, :id_categoria, :pergunta)
									   ');
			// tratar os dados
			$pergunta = trim($dados['pergunta']);
			//mesclar os dados
			$sqlPergunta->bindParam(':id_usuario',$dados['id_usuario']);
			$sqlPergunta->bindParam(':id_categoria',$dados['id_categoria']);
			$sqlPergunta->bindParam(':pergunta',$pergunta);

			$sqlPergunta->execute();
			//pegar o id da pergunta
			$id_pergunta = $this->pdo->lastInsertId();
			
			
			// cadastrar a resposta correta
			$sqlRespostaCorreta = $this->pdo->prepare('INSERT INTO alternativas
														(id_pergunta, resposta, correta)
													VALUES
														(:id_pergunta, :resposta, :correta)
													');
			//tratar os dados
			$respostacorreta = trim($dados['correta']);
			$correta = 1;
			//mesclar os dados
			$sqlRespostaCorreta->bindParam(':id_pergunta',$id_pergunta);
			$sqlRespostaCorreta->bindParam(':resposta',$respostacorreta);
			$sqlRespostaCorreta->bindParam(':correta',$correta);
			$sqlRespostaCorreta->execute();

			// cadastrar as alternativas INCORRETAS
			foreach($dados['errada'] as $errada) {
				$sqlRespostaErrada = $this->pdo->prepare('INSERT INTO alternativas
														(id_pergunta, resposta)
														VALUES
														(:id_pergunta, :resposta)');
				//tratar os dados
				$respostaErrada = trim($errada);
				//mesclar os dados
				$sqlRespostaErrada->bindParam(':id_pergunta',$id_pergunta);
				$sqlRespostaErrada->bindParam(':resposta',$respostaErrada);

				$sqlRespostaErrada->execute();
			}

			return $id_pergunta;
    	}


    	/**
    	 * listar 
    	 * @return array
    	 */
    	public function listar()
    	{
    		//montar o SELECT ou o SQL
    		$sql = $this->pdo->prepare('SELECT * FROM perguntas ORDER BY id_pergunta');
    		//executar a consulta
    		$sql->execute();
    		//pegar os dados retornados
        	$dados = $sql->fetchall(PDO::FETCH_OBJ);
    		return $dados;
    	}

    	// 1 - RETORNAR OS DADOS DA PERGUNTA
    	//   id_pergunta, id_usuario, id_categoria, pergunta
    	// 2 - RETORNAR A RESPOSTA CORRETA
    	// 3 - RETORNAR AS RESPOSTA ERRADAS
    	
    	/**
    	 * mostrarPergunta - mostra os dados da pergunta
    	 * @param  int $id_pergunta 
    	 * @return array - com os dados da tabela pergunta
    	 */
    	public function mostrarPergunta($id_pergunta)
    	{
    		$sql = $this->pdo->prepare('SELECT * FROM perguntas
									    WHERE id_pergunta = :id_pergunta
    								  ');
    		$sql->bindParam(':id_pergunta',$id_pergunta);
    		$sql->execute();

    		return $sql->fetch(PDO::FETCH_OBJ);
    	}

        /**
         * mostrarAlternativaCorreta
         * @param  int $id_pergunta
         * @return array
         */
        public function mostrarAlternativaCorreta($id_pergunta)
        {
            $sql = $this->pdo->prepare('SELECT * FROM alternativas
                                         WHERE id_pergunta = :id_pergunta
                                         AND correta = 1
                                      ');
            $sql->bindParam(':id_pergunta',$id_pergunta);
            $sql->execute();
            return $sql->fetch(PDO::FETCH_OBJ); 

        }

        /**
         * mostrarAlternativasErradas description
         * @author Thomas Melo
         * @date   21-05-2020
         * @param  int $id_pergunta
         * @return array
         */
        public function mostrarAlternativasErradas($id_pergunta)
        {
            $sql = $this->pdo->prepare('SELECT * FROM alternativas
                                         WHERE id_pergunta = :id_pergunta
                                         AND correta = 0
                                      ');
            $sql->bindParam(':id_pergunta',$id_pergunta);
            $sql->execute();
            return $sql->fetchall(PDO::FETCH_OBJ);
        }


        /**
         * atualizar
         * @param  int $id_pergunta
         * @param  array $dados
         * @return int  - PK DA PERGUNTA
         */
        public function atualizar($id_pergunta,$dados)
        {
            //ATUALIZAR A PERGUNTA
            $sqlPergunta = $this->pdo->prepare('UPDATE perguntas SET 
                                                pergunta = :pergunta,
                                                id_categoria = :id_categoria
                                                WHERE
                                                id_pergunta = :id_pergunta
                                             ');
            // tratar os dados
            $pergunta = trim($dados['pergunta']);
            //mesclar os dados
            $sqlPergunta->bindParam(':id_categoria',$dados['id_categoria']);
            $sqlPergunta->bindParam(':pergunta',$pergunta);
            $sqlPergunta->bindParam(':id_pergunta',$id_pergunta);
            $sqlPergunta->execute();

            //apagar todas as alternativas de resposta dessa pergunta
            $sqlExcluir = $this->pdo->prepare('DELETE FROM alternativas 
                                                WHERE id_pergunta = :id_pergunta');
            $sqlExcluir->bindParam(':id_pergunta', $id_pergunta);
            $sqlExcluir->execute();

            // cadastro as "novas" alternativas
            // cadastrar a resposta correta
            $sqlRespostaCorreta = $this->pdo->prepare('INSERT INTO alternativas
                                                        (id_pergunta, resposta, correta)
                                                    VALUES
                                                        (:id_pergunta, :resposta, :correta)
                                                    ');

            //tratar os dados
            $respostacorreta = trim($dados['correta']);
            $correta = 1;
            //mesclar os dados
            $sqlRespostaCorreta->bindParam(':id_pergunta',$id_pergunta);
            $sqlRespostaCorreta->bindParam(':resposta',$respostacorreta);
            $sqlRespostaCorreta->bindParam(':correta',$correta);
            $sqlRespostaCorreta->execute();
            // cadastrar as alternativas INCORRETAS
            foreach($dados['errada'] as $errada) {
                $sqlRespostaErrada = $this->pdo->prepare('INSERT INTO alternativas
                                                        (id_pergunta, resposta)
                                                        VALUES
                                                        (:id_pergunta, :resposta)');

                //tratar os dados
                $respostaErrada = trim($errada);
                //mesclar os dados
                $sqlRespostaErrada->bindParam(':id_pergunta',$id_pergunta);
                $sqlRespostaErrada->bindParam(':resposta',$respostaErrada);

                $sqlRespostaErrada->execute();
            }
            return $id_pergunta;
        }


        /**
         * opcoesDeResposta - Mostrar as opções de resposta para
         *                     uma determinada pergunta, sendo
         *                     a alternativa correta e 4 alternativas 
         *                     incorretas
         * @param  INT $id_pergunta
         * @return array
         */
        public function opcoesDeResposta($id_pergunta)
        {
            //opções de resposta
            $opcoes  = array(); // todas as respostas
            $erradas = array(); // apenas as erradas
            // alternativas INCORRETAS
            $sql = $this->pdo->prepare(' SELECT * FROM alternativas
                                         WHERE id_pergunta = :id_pergunta
                                         AND correta = 0
                                         ORDER BY rand()
                                         LIMIT 4
                                        ');

            $sql->bindParam(':id_pergunta',$id_pergunta);
            $sql->execute();
            $erradas[] = $sql->fetchall(PDO::FETCH_OBJ);
            // incluir as respostas erradas nas opções
            foreach ($erradas as $errada) {
                foreach ($errada as $value){
                    $opcoes[] = $value;
                }
            }
            // Pegar a resposta correta
            $opcoes[] = $this->mostrarAlternativaCorreta($id_pergunta);
            // embaralhar as opçoes
            shuffle($opcoes);
            // retornar
            return $opcoes;
        }


       /**
        * verificarResposta 
        * @param  INT $resposta - id da resposta selecionada
        * @param  INT $id_usuario 
        * @return bool
        */
       public function verificarResposta($resposta,$id_usuario)
        {
           // verificar se a resposta está correta
           $sqlResposta = $this->pdo->prepare('SELECT correta FROM alternativas
                                                WHERE id_alternativa = :id_alternativa
                                              ');
           $sqlResposta->bindParam(':id_alternativa',$resposta);
           $sqlResposta->execute();
           $resposta = $sqlResposta->fetch(PDO::FETCH_OBJ);
           // se a resposta estiver correta
           // incrementar a pontuação do usuário
           if($resposta->correta == 1){
            $sql = $this->pdo->prepare('UPDATE usuarios
                                         SET pontuacao = pontuacao + 1
                                         WHERE
                                         id_usuario = :id_usuario
                                        ');
            $sql->bindParam(':id_usuario',$id_usuario);
            $sql->execute();
            return true;
           } else {
                return false;
           }
        } 

        /**
         * Sorteia as perguntas de forma aleatória
         * @param  INT $id_categoria
         * @return array
         */
        public function sortearPergunta($id_categoria='')
        {
            if($id_categoria != ''){
                $sql = $this->pdo->prepare('SELECT * FROM perguntas
                                            WHERE id_categoria = :id_categoria
                                            ORDER BY rand()
                                            LIMIT 1
                                          ');
                $sql->bindParam(':id_categoria',$id_categoria);

            } else {
                $sql = $this->pdo->prepare('SELECT * FROM perguntas
                                            ORDER BY rand()
                                            LIMIT 1
                                          ');
            }

            // executar a consulta SQL
            $sql->execute();
            return $sql->fetch(PDO::FETCH_OBJ);
        }


 }
?>