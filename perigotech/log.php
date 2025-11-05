<?php
session_start();
include_once('config.php');


// if (!isset($_SESSION['login']) || $_SESSION['login'] !== 'admin') {
//     header('Location: login.php');
//     exit();
// }

$q = isset($_GET['q']) ? trim($_GET['q']) : '';
$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : 'todos';

$where = '';
$params = [];
$types = '';

if ($q !== '' && $tipo !== 'todos') {
    if ($tipo === 'nome') {
        $where = "WHERE usuario_nome LIKE ?";
        $params[] = "%{$q}%";
        $types .= 's';
    } elseif ($tipo === 'cpf') {
        $where = "WHERE usuario_cpf LIKE ?";
        $params[] = "%{$q}%";
        $types .= 's';
    }
}

$sql = "SELECT id, usuario_nome, usuario_cpf, segundo_fator, data_login FROM auth_logs " . $where . " ORDER BY data_login DESC";
$stmt = $conexao->prepare($sql);
if ($stmt) {
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $res = $stmt->get_result();
} else {
    $res = $conexao->query($sql);
}
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Tela de Logs (Master)</title>
<style>
table{border-collapse:collapse;width:100%}
th,td{border:1px solid #ccc;padding:8px;text-align:center}
form{margin-bottom:12px}

</style>
</head>
<body>
<h1>Logs de Autenticação - Acesso Master</h1>
<form method="GET">
    <input type="text" name="q" placeholder="pesquisar..." value="<?= htmlspecialchars($q) ?>">
    <select name="tipo">
        <option value="todos" <?= $tipo === 'todos' ? 'selected' : '' ?>>Todos</option>
        <option value="nome" <?= $tipo === 'nome' ? 'selected' : '' ?>>Nome</option>
        <option value="cpf" <?= $tipo === 'cpf' ? 'selected' : '' ?>>CPF</option>
    </select>
    <button type="submit">Filtrar</button>
    <a href="gerar_pdf.php" class="export-btn">
    <i class="fas fa-file-pdf"></i> Baixar PDF
    <a href="loja.php" class="back-btn">⬅ Voltar à Página Inicial</a>

</a>

</form>

<table>
    <thead><tr><th>Data / Hora</th><th>Nome</th><th>CPF</th><th>2FA</th></tr></thead>
    <tbody>
    <?php if (isset($res) && $res): ?>
        <?php while ($row = $res->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['data_login']) ?></td>
                <td><?= htmlspecialchars($row['usuario_nome']) ?></td>
                <td><?= htmlspecialchars($row['usuario_cpf']) ?></td>
                <td><?= htmlspecialchars($row['segundo_fator']) ?></td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr><td colspan="4">Nenhum registro encontrado.</td></tr>
    <?php endif; ?>
    </tbody>
</table>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <style>
    /* ======== Estilo da Tela de Log ======== */

body {
    background: linear-gradient(135deg, #0b0c10, #1f2833);
    color: #fff;
    font-family: "Poppins", sans-serif;
    margin: 0;
    padding: 0;
    min-height: 100vh;
}

/* Cabeçalho da página */
header {
    background-color: #0b0c10;
    color: #66fcf1;
    text-align: center;
    padding: 20px;
    font-size: 1.8rem;
    letter-spacing: 1px;
    border-bottom: 2px solid #45a29e;
    box-shadow: 0 0 15px rgba(102, 252, 241, 0.3);
}

/* Container principal */
.container {
    width: 90%;
    max-width: 1000px;
    margin: 40px auto;
    background-color: #1f2833;
    border-radius: 10px;
    padding: 30px;
    box-shadow: 0 0 25px rgba(102, 252, 241, 0.15);
}

/* Título */
h2 {
    text-align: center;
    color: #66fcf1;
    margin-bottom: 25px;
    font-weight: 600;
    text-shadow: 0 0 10px rgba(102, 252, 241, 0.4);
}

/* ======== Formulário de busca ======== */
form {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 10px;
    margin-bottom: 25px;
    flex-wrap: wrap;
}

select, input[type="text"] {
    padding: 10px 15px;
    border: 1px solid #45a29e;
    border-radius: 8px;
    outline: none;
    font-size: 1rem;
    background-color: #0b0c10;
    color: #fff;
    transition: 0.3s ease;
}

select:hover, input[type="text"]:focus {
    box-shadow: 0 0 10px #45a29e;
}

/* ======== Botões ======== */
button {
    background-color: #45a29e;
    color: #0b0c10;
    font-weight: 600;
    padding: 10px 20px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
}

button:hover {
    background-color: #66fcf1;
    transform: scale(1.05);
}

/* ======== Container dos botões Filtrar e PDF ======== */
.filter-actions {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 10px;
    margin-top: 15px;
}

/* ======== Botão de Baixar PDF ======== */
.export-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0px;
    background: linear-gradient(90deg, #45a29e, #66fcf1);
    color: #0b0c10;
    padding: 10px 10px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 500;
    font-size: 0.95rem;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 0 10px rgba(102, 252, 241, 0.25);
}

.export-btn:hover {
    transform: scale(1.05);
    box-shadow: 0 0 20px rgba(102, 252, 241, 0.45);
}

/* Ícone dentro do botão PDF */
.export-btn i {
    font-size: 1rem;
    transition: transform 0.3s ease;
}

.export-btn:hover i {
    transform: translateY(-2px);
}

/* ======== Tabela ======== */
table {
    width: 100%;
    border-collapse: collapse;
    border: 1px solid #45a29e;
    margin-top: 15px;
    font-size: 0.95rem;
}

th, td {
    padding: 12px;
    text-align: left;
}

th {
    background-color: #0b0c10;
    color: #66fcf1;
    text-transform: uppercase;
    letter-spacing: 1px;
}

td {
    background-color: #1f2833;
    border-top: 1px solid #45a29e40;
}

tr:hover td {
    background-color: #16232f;
}

/* ======== Responsividade ======== */
@media (max-width: 768px) {
    .container {
        padding: 20px;
    }

    table {
        font-size: 0.85rem;
    }

    th, td {
        padding: 8px;
    }

    form {
        flex-direction: column;
        align-items: stretch;
    }

    .filter-actions {
        flex-direction: column;
    }

    .export-btn, .filter-btn {
        width: 100%;
        text-align: center;
    }
}
    /* ======== Botão de Voltar ======== */
.back-btn {
    display: inline-block;
    background-color: #0b0c10;
    color: #66fcf1;
    padding: 10px 18px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    border: 2px solid #45a29e;
    transition: all 0.3s ease;
    box-shadow: 0 0 10px rgba(102, 252, 241, 0.2);
}

.back-btn:hover {
    background-color: #45a29e;
    color: #0b0c10;
    transform: scale(1.05);
    box-shadow: 0 0 15px rgba(102, 252, 241, 0.5);
}

    </style>
</body>
</html>