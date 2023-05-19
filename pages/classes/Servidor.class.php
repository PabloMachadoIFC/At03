<?php
        require_once('Usuario.class.php');

        class Servidor extends Usuario{
                private $siape;
                private $dtAdmissao;

                public function __construct($pid,$pnome,$prg,$plogin,$psenha,$psiape,$pdt) { 
                        parent:: __construct($pid,$pnome,$prg,$plogin,$psenha);
                        $this->setSiape($psiape);
                        $this->setDtAdmissao($pdt);
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
            
                $sql = "SELECT * FROM professor WHERE id = :id";
                $stmt = $conexao->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();
            
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
                if ($row) {
                    $servidor = new Servidor(
                        $row['id'],
                        $row['nome'],
                        $row['rg'],
                        $row['login'],
                        $row['senha'],
                        $row['siape'],
                        $row['dtAdmissao']
                    );
            
                    return $servidor;
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
            
                    $sql = "SELECT * FROM professor";
                    $stmt = $conexao->query($sql);
            
                    return $stmt;
                }
                /**
                 * Get the value of siape
                 */
                public function getSiape()
                {
                                return $this->siape;
                }

                /**
                 * Set the value of siape
                 */
                public function setSiape($siape): self
                {
                                $this->siape = $siape;

                                return $this;
                }

                /**
                 * Get the value of dtAdmissao
                 */
                public function getDtAdmissao()
                {
                                return $this->dtAdmissao;
                }

                /**
                 * Set the value of dtAdmissao
                 */
                public function setDtAdmissao($dtAdmissao): self
                {
                                $this->dtAdmissao = $dtAdmissao;

                                return $this;
                }
        }

?>