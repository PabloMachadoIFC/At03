<?php
require_once('../../conf/conf.inc.php');
require_once('../classes/Servidor.class.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$acao = "";
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $acao = isset($_GET['acao']) ? $_GET['acao'] : "";
        break;
    case 'POST':
        $acao = isset($_POST['acao']) ? $_POST['acao'] : "";
        break;
}

$dados = array();
switch ($acao) {
    case 'excluir':
        $id = isset($_GET['id']) ? $_GET['id'] : 0;
        $professor = new Servidor('', '', '', '', '', '', '');
        $professor->excluir('professor', $id);
        break;
    case 'salvar':
        {
            
            $id = isset($_POST['id']) ? $_POST['id'] : 0;
            if ($id == 0)
            {
                // echo "SALVAR";
                $professor = new Servidor('', '', '', '', '', '', '');
                $nome = isset($_POST['nome']) ? $_POST['nome'] : '';
                $rg = isset($_POST['rg']) ? $_POST['rg'] : '';
                $login = isset($_POST['login']) ? $_POST['login'] : '';
                $senha = isset($_POST['senha']) ? $_POST['senha'] : '';
                $siape = isset($_POST['siape']) ? $_POST['siape'] : '';
                $dtAdmissao = isset($_POST['dtAdmissao']) ? $_POST['dtAdmissao'] : '';
        
                $informacoes = array(
                    'id' => $id,
                    'nome' => $nome,
                    'rg' => $rg,
                    'login' => $login,
                    'senha' => $senha,
                    'siape' => $siape,
                    'dtAdmissao' => $dtAdmissao
                );

                $professor = new Servidor($id, $nome, $rg, $login, $senha, $siape, $dtAdmissao);
                $professor->inserir('professor', $informacoes);
                break;
            }
            elseif ($id != 0){
                // var_dump($_POST);
                // echo "EDITAR";
                $nome = isset($_POST['nome']) ? $_POST['nome'] : '';
                $rg = isset($_POST['rg']) ? $_POST['rg'] : '';
                $login = isset($_POST['login']) ? $_POST['login'] : '';
                $senha = isset($_POST['senha']) ? $_POST['senha'] : '';
                $siape = isset($_POST['siape']) ? $_POST['siape'] : '';
                $dtAdmissao = isset($_POST['dtAdmissao']) ? $_POST['dtAdmissao'] : '';
        
                $informacoes = array(
                    'id' => $id,
                    'nome' => $nome,
                    'rg' => $rg,
                    'login' => $login,
                    'senha' => $senha,
                    'siape' => $siape,
                    'dtAdmissao' => $dtAdmissao
                );
                $professor = new Servidor($id, $nome, $rg, $login, $senha, $siape, $dtAdmissao);
                $professor->editar('professor', $informacoes, $id);
                // var_dump($professor);
            }
            break;
        }
        
    case 'editar':
    {
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        $professor = new Servidor('', '', '', '', '', '', '');
        $dados = $professor->buscarPorId($id);
        break;
    }

}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Professores</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css">
</head>
<body>
    <a href="../../index.php">Voltar</a>
<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h1 class="text-center">Professores</h1>
            <form method="POST" action="index.php">
                <input type="text" class="form-control" id='id' name='id' value="<?= ($acao == 'editar' && $dados !== null && null !== $dados->getId()) ? $dados->getId() : '0'; ?>" readonly>

                <div class="mb-3">
                    <label for="nome" class="form-label">Nome</label>
                    <input type="text" class="form-control" id="nome" name="nome" value="<?= ($acao == 'editar' && null !== $dados->getNome()) ? $dados->getNome() : ''; ?>">
                </div>

                <div class="mb-3">
                    <label for="rg" class="form-label">RG</label>
                    <input type="text" class="form-control" id="rg" name="rg" value="<?= ($acao == 'editar' && null !== $dados->getRg()) ? $dados->getRg() : ''; ?>">
                </div>

                <div class="mb-3">
                    <label for="login" class="form-label">Login</label>
                    <input type="text" class="form-control" id="login" name="login" value="<?= ($acao == 'editar' && null !== $dados->getLogin()) ? $dados->getLogin() : ''; ?>">
                </div>

                <div class="mb-3">
                    <label for="senha" class="form-label">Senha</label>
                    <input type="password" class="form-control" id="senha" name="senha" value="<?= ($acao == 'editar' && null !== $dados->getSenha()) ? $dados->getSenha() : ''; ?>">
                </div>

                <div class="mb-3">
                    <label for="siape" class="form-label">SIAPE</label>
                    <input type="text" class="form-control" id="siape" name="siape" value="<?= ($acao == 'editar' && null !== $dados->getsiape()) ? $dados->getsiape() : ''; ?>">
                </div>

                <div class="mb-3">
                    <label for="dtAdmissao" class="form-label">Data de Admissao</label>
                    <input type="date" class="form-control" id="dtAdmissao" name="dtAdmissao" value="<?= ($acao == 'editar' && null !== $dados->getdtAdmissao()) ? $dados->getdtAdmissao() : ''; ?>">
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary" name="acao" value="salvar">
                        <?= ($acao == 'editar') ? 'Editar Professor' : 'Criar Professor'; ?>
                    </button>
                </div>


            </form>

            <table class="table mt-5">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>RG</th>
                    <th>Login</th>
                    <th>Senha</th>
                    <th>Matrícula</th>
                    <th>Data de Admissão</th>
                    <th>Ações</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $professor = new Servidor('', '', '', '', '', '', ''); // Preencha com os valores adequados
                $consulta = $professor->buscarTodos();
                while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
                    echo "
                    <tr>
                        <td>{$linha['id']}</td>
                        <td>{$linha['nome']}</td>
                        <td>{$linha['rg']}</td>
                        <td>{$linha['login']}</td>
                        <td>{$linha['senha']}</td>
                        <td>{$linha['siape']}</td>
                        <td>{$linha['dtAdmissao']}</td>
                        <td><a class='btn btn-warning' href='index.php?acao=editar&id={$linha['id']}'>Editar</a>
                        <a class='btn btn-danger' onClick='return excluir();' href='index.php?acao=excluir&id={$linha['id']}'>Excluir</a></td>
                    </tr>\n";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
