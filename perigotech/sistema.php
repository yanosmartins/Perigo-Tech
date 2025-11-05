<?php
include_once('config.php');
session_start();

$admin_users = ['admin', 'master'];
if (!isset($_SESSION['login']) || empty($_SESSION['login'])) {
    unset($_SESSION['login']);
    header('Location: login.php');
    exit();
}
if (!in_array($_SESSION['login'], $admin_users)) {
    header('Location: loja.php');
    exit();
}
$usuario = htmlspecialchars($_SESSION['login'], ENT_QUOTES, 'UTF-8');

// ===== FILTROS =====
$filtro_id = isset($_GET['id']) ? trim($_GET['id']) : '';
$filtro_nome = isset($_GET['nome']) ? trim($_GET['nome']) : '';

$sql = "SELECT * FROM usuarios WHERE 1=1";
if ($filtro_id !== '') {
    $sql .= " AND id = " . intval($filtro_id);
}
if ($filtro_nome !== '') {
    $nomeEscapado = $conexao->real_escape_string($filtro_nome);
    $sql .= " AND nome LIKE '%$nomeEscapado%'";
}

$result = $conexao->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
<title>Sistema</title>
<style>
/* (mantém teu CSS original) */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}
body {
    background-color: #1e1e1e;
    color: #fff;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 10px;
}
h1 { color: #ffa500; margin-bottom: 5px; }
a { color: #ff9900; text-decoration: none; font-weight: bold; transition: 0.3s; }
a:hover { color: #ffb347; }
.container { width: 90%; margin-top: 20px; }
table { width: 100%; border-collapse: collapse; background-color: #2e2e2e; border: 2px solid #ff9900; }
table thead tr { background-color: #ff9900; color: #1e1e1e; }
table th, table td { padding: 10px; text-align: center; border: 1px solid #ffa500; word-wrap: break-word; }
table tbody tr:nth-child(even) { background-color: #3a3a3a; }
table tbody tr:hover { background-color: #ffb347; color: #1e1e1e; }
.filter-form {
    display: flex;
    gap: 10px;
    margin-bottom: 15px;
    justify-content: center;
}
.filter-form input {
    padding: 5px;
    border-radius: 5px;
    border: 1px solid #ccc;
}
.filter-form button {
    background-color: #ff7300;
    border: none;
    color: white;
    padding: 6px 15px;
    border-radius: 5px;
    cursor: pointer;
}
</style>
</head>
<body>
<h1>Bem-vindo ao Sistema</h1>
<p>Olá, <?php echo $usuario; ?>! Você está logado no sistema.</p>
<p><a href="logout.php">Sair</a> | <a href="loja.php">Voltar</a></p>

<div class="container">
    <!-- 🔍 FILTROS -->
    <form method="GET" class="filter-form">
        <input type="text" name="id" placeholder="Filtrar por ID" value="<?= htmlspecialchars($filtro_id) ?>">
        <input type="text" name="nome" placeholder="Filtrar por Nome" value="<?= htmlspecialchars($filtro_nome) ?>">
        <button type="submit">Filtrar</button>
        <a href="admin.php" class="btn btn-secondary">Limpar</a>
    </form>

    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Nome</th>
                <th>CPF</th>
                <th>Email</th>
                <th>Telefone</th>
                <th>Endereço</th>
                <th>Data Nasc</th>
                <th>Sexo</th>
                <th>CEP</th>
                <th>Login</th>
                <th>Senha</th>
                <th>Nome Mãe</th>
                <th>Ativo</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php while($user = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= $user['id'] ?></td>
                    <td><?= htmlspecialchars($user['nome']) ?></td>
                    <td><?= htmlspecialchars($user['cpf']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td><?= htmlspecialchars($user['telefone']) ?></td>
                    <td><?= htmlspecialchars(mb_strimwidth($user['endereco'], 0, 30, "...")) ?></td>
                    <td><?= htmlspecialchars(date('d/m/Y', strtotime($user['data_nascimento']))) ?></td>
                    <td><?= htmlspecialchars($user['sexo']) ?></td>
                    <td><?= htmlspecialchars($user['cep']) ?></td>
                    <td><?= htmlspecialchars($user['login']) ?></td>
                    <td><?= htmlspecialchars($user['senha']) ?></td>
                    <td><?= htmlspecialchars($user['nome_mae']) ?></td>
                    <td>
                        <a href="toggleAtivo.php?id=<?= $user['id'] ?>&ativo=<?= $user['status'] ? 0 : 1 ?>" 
                           class="btn btn-sm <?= $user['status'] ? 'btn-success' : 'btn-secondary' ?>">
                           <?= $user['status'] ? 'Ativo' : 'Inativo' ?>
                        </a>
                    </td>
                    <td>
                        <a class="btn btn-sm btn-primary" href="edit.php?id=<?= $user['id'] ?>">Editar</a>
                        <a class="btn btn-sm btn-warning" href="limparSenha.php?id=<?= $user['id'] ?>"
                           onclick="return confirm('Deseja limpar a senha deste usuário?');">Limpar Senha</a>
                        <a class="btn btn-sm btn-danger" href="delete.php?id=<?= $user['id'] ?>"
                           onclick="return confirm('Tem certeza que deseja excluir este usuário?');">Excluir</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
