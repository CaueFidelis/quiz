<?php 
/**
 * Categoria de Perguntas
 */
class Categoria extends Conexao
{

    //ATRIBUTOS
	public $categoria;
	public $pdo; // guardar a conexão

    public function __construct()
    {
        $this->pdo = Conexao::conexao();
    }


    /**
     * listar - lista todas as categorias
     * @return array
     */
    public function listar(){
    	//montar o SELECT ou o SQL
    	$sql = $this->pdo->prepare('SELECT * FROM categorias ORDER BY categoria');

    	//executar a consulta
    	$sql->execute();
    	//pegar os dados retornados
        $dados = $sql->fetchall(PDO::FETCH_OBJ);

    	return $dados;
    }


    /**
     * cadastrar
     * @param  array $dados
     * @return int   id_cagetoria
     */
    public function cadastrar($dados)
    {
        //SQL
        $sql = $this->pdo->prepare('INSERT INTO categorias
                                        (categoria)
                                    VALUES
                                        (:categoria)
                                    ');
        // Tratar os dados recebidos
        // TRIM - remove os espaços vazios antes e depois da string
        // UCFIRST - Coloca a primeira letra em caixa alta
        $categoria = ucfirst(trim($dados['categoria']));

        //mesclar os dados
        $sql->bindParam(':categoria',$categoria);
        //executar
        $sql->execute();

        //retorna a PK do registro inserido
        return $this->pdo->lastInsertId();
    }


    /**
     * editar
     * @param  array $dados 
     * @return int
     */
    public function editar($dados)
    {
        //SQL
        $sql = $this->pdo->prepare('UPDATE categorias SET
                                        categoria   = :categoria
                                    WHERE
                                       id_categoria = :id_categoria
                                     ');
        // Tratar os dados recebidos
        // TRIM - remove os espaços vazios antes e depois da string
        $categoria = ucfirst(trim($dados['categoria']));
        $id_categoria = Helper::decrypta($dados['id_categoria']);

        //mesclar os dados
        $sql->bindParam(':categoria',$categoria);
        $sql->bindParam(':id_categoria',$id_categoria);
        
        //executar
        $sql->execute();
        return $dados['id_categoria'];
    }


    /**
     * apagar 
     * @param  string $id_categoria - criptografado
     * @return void
     */
    public function apagar($id_categoria)
    {
        //descriptografar
        $id_categoria = Helper::decrypta($id_categoria);

        // atualizar todas as perguntas da categoria que será excluída
        // para a categoria padrão que é a GERAL id = 1
        $id_geral = 1;
        $sqlPerguntas = $this->pdo->prepare('UPDATE perguntas SET 
                                            id_categoria = :id_geral
                                            WHERE 
                                            id_categoria = :id_categoria
                                            ');

        $sqlPerguntas->bindParam(':id_categoria',$id_categoria);
        $sqlPerguntas->bindParam(':id_geral',$id_geral);
        $sqlPerguntas->execute();

        // realizar a exclusão
        $sql = $this->pdo->prepare('DELETE FROM categorias WHERE id_categoria = :id_categoria');
        $sql->bindParam(':id_categoria',$id_categoria);
        $sql->execute();
    }

    /**
     * show - retorna os dados de uma categoria
     * @param  string $id_categoria - criptografado
     * @return array / obj
     */
    public function show($id_categoria)
    {
        //descriptografar
        $id_categoria = Helper::decrypta($id_categoria);

        //montar o SELECT ou o SQL
        $sql = $this->pdo->prepare('SELECT * FROM categorias
                                     WHERE id_categoria = :id_categoria
                                   ');

        //mesclar os dados/atributos
        $sql->bindParam(':id_categoria',$id_categoria);

        //executar o SQL
        $sql->execute();

        //retornart os dados
        return $sql->fetch(PDO::FETCH_OBJ);

    }


    /**
     * nomeCategoria - retorna nome
     * @param  int $id_categoria
     * @return string
     */
    public function nomeCategoria($id_categoria)
    {
        //montar o SELECT ou o SQL
        $sql = $this->pdo->prepare('SELECT categoria FROM categorias
                                     WHERE id_categoria = :id_categoria
                                   ');

        //mesclar os dados/atributos
        $sql->bindParam(':id_categoria',$id_categoria);
        //executar o SQL
        $sql->execute();
        //retornart os dados
        $categoria = $sql->fetch(PDO::FETCH_OBJ);

        return $categoria->categoria;

    }

}

?>