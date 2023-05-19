<?php
require_once('Usuario.class.php');

class Aluno extends Usuario
{
    private $matricula;
    private $turma;

    public function __construct($pid, $pnome, $prg, $plogin, $psenha, $pmat, $pturma)
    {
        parent::__construct($pid, $pnome, $prg, $plogin, $psenha);
        $this->setMatricula($pmat);
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

    $sql = "SELECT * FROM aluno WHERE id = :id";
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $aluno = new Aluno(
            $row['id'],
            $row['nome'],
            $row['rg'],
            $row['login'],
            $row['senha'],
            $row['matricula'],
            $row['turma']
        );

        return $aluno;
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

        $sql = "SELECT * FROM aluno";
        $stmt = $conexao->query($sql);

        return $stmt;
    }


    /**
     * Get the value of matricula
     */
    public function getMatricula()
    {
        return $this->matricula;
    }

    /**
     * Set the value of matricula
     */
    public function setMatricula($matricula)
    {
        $this->matricula = $matricula;
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
