<?php
require_once('../../conf/conf.inc.php');
require_once('../classes/Usuario.class.php');

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
        $usuario = new Usuario('', '', '', '', '', '', '');
        $usuario->excluir('usuario', $id);
        break;
    case 'salvar':
        {
            
            $id = isset($_POST['id']) ? $_POST['id'] : 0;
            if ($id == 0)
            {
                // echo "SALVAR";
                $usuario = new Usuario('', '', '', '', '', '', '');
                $nome = isset($_POST['nome']) ? $_POST['nome'] : '';
                $rg = isset($_POST['rg']) ? $_POST['rg'] : '';
                $login = isset($_POST['login']) ? $_POST['login'] : '';
                $senha = isset($_POST['senha']) ? $_POST['senha'] : '';
                $turma = isset($_POST['turma']) ? $_POST['turma'] : '';
        
                $informacoes = array(
                    'id' => $id,
                    'nome' => $nome,
                    'rg' => $rg,
                    'login' => $login,
                    'senha' => $senha,
                    'turma' => $turma
                );

                $usuario = new Usuario($id, $nome, $rg, $login, $senha, $turma);
                $usuario->inserir('usuario', $informacoes);
                break;
            }
            elseif ($id != 0){
                // var_dump($_POST);
                // echo "EDITAR";
                $nome = isset($_POST['nome']) ? $_POST['nome'] : '';
                $rg = isset($_POST['rg']) ? $_POST['rg'] : '';
                $login = isset($_POST['login']) ? $_POST['login'] : '';
                $senha = isset($_POST['senha']) ? $_POST['senha'] : '';
                $turma = isset($_POST['turma']) ? $_POST['turma'] : '';
        
                $informacoes = array(
                    'id' => $id,
                    'nome' => $nome,
                    'rg' => $rg,
                    'login' => $login,
                    'senha' => $senha,
                    'turma' => $turma
                );
                $usuario = new Usuario($id, $nome, $rg, $login, $senha, $turma);
                $usuario->editar('usuario', $informacoes, $id);
                // var_dump($usuario);
            }
            break;
        }
        
    case 'editar':
    {
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        $usuario = new Usuario('', '', '', '', '', '', '');
        $dados = $usuario->buscarPorId($id);
        break;
    }

}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Usuarios</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css">
</head>
<body>
<a href="../../index.php">Voltar</a>
<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h1 class="text-center">Usuarios</h1>
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
                    <label for="turma" class="form-label">Turma</label>
                    <input type="text" class="form-control" id="turma" name="turma" value="<?= ($acao == 'editar' && null !== $dados->getTurma()) ? $dados->getTurma() : ''; ?>">
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary" name="acao" value="salvar">
                        <?= ($acao == 'editar') ? 'Editar Usuario' : 'Criar Usuario'; ?>
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
                    <th>Turma</th>
                    <th>Ações</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $usuario = new Usuario('', '', '', '', '', '', ''); // Preencha com os valores adequados
                $consulta = $usuario->buscarTodos();
                while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
                    echo "
                    <tr>
                        <td>{$linha['id']}</td>
                        <td>{$linha['nome']}</td>
                        <td>{$linha['rg']}</td>
                        <td>{$linha['login']}</td>
                        <td>{$linha['senha']}</td>
                        <td>{$linha['turma']}</td>
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
