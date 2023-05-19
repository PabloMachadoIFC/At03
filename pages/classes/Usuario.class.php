<?php

require_once('Database.class.php');

class Usuario extends Database
{
    private $id;
    private $nome;
    private $rg;
    private $login; // email
    private $senha;
    private $turma;

    public function __construct($pid = '', $pnome = '', $prg = '', $plogin = '', $psenha = '', $pturma = '')
    {
        $this->setId($pid);
        $this->setNome($pnome);
        $this->setRg($prg);
        $this->setLogin($plogin);
        $this->setSenha($psenha);
        $this->setTurma($pturma);
    }
    public function inserir($tabela, $dados)
    {
        $db = new Database();
        $db->inserir($tabela, $dados);
    }
    public function buscarPorId($id)
{
    $db = new Database();
    $conexao = $db->criarConexao();

    $sql = "SELECT * FROM usuario WHERE id = :id";
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $usuario = new Usuario(
            $row['id'],
            $row['nome'],
            $row['rg'],
            $row['login'],
            $row['senha'],
            $row['turma']
        );

        return $usuario;
    }

    return null;
}

    
public function editar($tabela, $dados, $condicao)
{
    $db = new Database();
    $db->editar($tabela, $dados, $condicao);
}

    public function excluir($tabela, $id)
    {
        $db = new Database();
        $db->excluir($tabela, $id);
    }

    public function buscarTodos()
    {
        $db = new Database();
        $conexao = $db->criarConexao();

        $sql = "SELECT * FROM usuario";
        $stmt = $conexao->query($sql);

        return $stmt;
    }
    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Get the value of nome
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Set the value of nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     * Get the value of rg
     */
    public function getRg()
    {
        return $this->rg;
    }

    /**
     * Set the value of rg
     */
    public function setRg($rg)
    {
        $this->rg = $rg;
    }

    /**
     * Get the value of login
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set the value of login
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    /**
     * Get the value of senha
     */
    public function getSenha()
    {
        return $this->senha;
    }

    /**
     * Set the value of senha
     */
    public function setSenha($senha)
    {
        $this->senha = $senha;
    }

    /**
     * Get the value of turma
     */
    public function getTurma()
    {
        return $this->turma;
    }

    /**
     * Set the value of turma
     */
    public function setTurma($turma)
    {
        $this->turma = $turma;
    }
}
?>
