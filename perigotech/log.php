<?php
session_start();
include_once('config.php');

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
<html lang="pt-br">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Tela de Logs (Master)</title>
<style>
/* ======== Estilo Geral ======== */
body {
    background-color: #1a1a1a;
    color: #ff9f1c;
    font-family: "Poppins", sans-serif;
    margin: 0;
    padding: 0;
    min-height: 100vh;
}

/* Cabeçalho */
header {
    background-color: #000;
    color: #ff9f1c;
    text-align: center;
    padding: 20px;
    font-size: 1.8rem;
    letter-spacing: 1px;
    border-bottom: 2px solid #ff9f1c;
    box-shadow: 0 0 15px rgba(255, 159, 28, 0.3);
}

/* Container principal */
.container {
    width: 90%;
    max-width: 1000px;
    margin: 40px auto;
    background-color: #111;
    border-radius: 10px;
    padding: 30px;
    box-shadow: 0 0 25px rgba(255, 159, 28, 0.15);
}

/* Título */
h1 {
    text-align: center;
    color: #ff9f1c;
    margin-bottom: 25px;
    font-weight: 600;
    text-shadow: 0 0 8px rgba(255, 159, 28, 0.5);
}

/* ======== Formulário de busca ======== */
.search-form {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 25px;
}

.search-controls {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    align-items: center;
}

.search-actions {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    align-items: center;
}

select, input[type="text"] {
    padding: 10px 15px;
    border: 1px solid #ff9f1c;
    border-radius: 8px;
    outline: none;
    font-size: 1rem;
    background-color: #222;
    color: #ff9f1c;
    transition: 0.3s ease;
}

select:hover, input[type="text"]:focus {
    box-shadow: 0 0 10px #ff9f1c;
}

/* Botões */
button {
    background-color: #ff9f1c;
    color: #000;
    font-weight: 600;
    padding: 10px 20px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
}

button:hover {
    background-color: #ffb347;
    transform: scale(1.05);
}

/* Botão de PDF */
.export-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
    background: linear-gradient(90deg, #ff9f1c, #ffb347);
    color: #000;
    padding: 10px 12px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 500;
    font-size: 0.95rem;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 0 10px rgba(255, 159, 28, 0.25);
}

.export-btn:hover {
    transform: scale(1.05);
    box-shadow: 0 0 20px rgba(255, 159, 28, 0.45);
}

/* Botão de voltar */
.back-btn {
    display: inline-block;
    background-color: #000;
    color: #ff9f1c;
    padding: 10px 18px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    border: 2px solid #ff9f1c;
    transition: all 0.3s ease;
    box-shadow: 0 0 10px rgba(255, 159, 28, 0.2);
}

.back-btn:hover {
    background-color: #ff9f1c;
    color: #000;
    transform: scale(1.05);
    box-shadow: 0 0 15px rgba(255, 159, 28, 0.5);
}

/* ======== Tabela ======== */
table {
    width: 100%;
    border-collapse: collapse;
    border: 1px solid #ff9f1c;
    margin-top: 15px;
    font-size: 0.95rem;
}

th, td {
    padding: 12px;
    text-align: left;
}

th {
    background-color: #000;
    color: #ff9f1c;
    text-transform: uppercase;
    letter-spacing: 1px;
}

td {
    background-color: #222;
    border-top: 1px solid rgba(255, 159, 28, 0.3);
}

tr:hover td {
    background-color: #333;
}

/* ======== Responsividade ======== */
@media (max-width: 768px) {
    .search-form {
        flex-direction: column;
        align-items: stretch;
    }

    .search-controls, .search-actions {
        flex-direction: column;
        width: 100%;
        gap: 8px;
    }

    .export-btn, .back-btn, button {
        width: 100%;
        text-align: center;
    }

    table {
        font-size: 0.85rem;
    }

    th, td {
        padding: 8px;
    }
}
</style>
</head>
<body>
<header>Logs de Autenticação - Acesso Master</header>
<div class="container">
<form method="GET" class="search-form">
    <div class="search-controls">
        <input type="text" name="q" placeholder="Pesquisar..." value="<?= htmlspecialchars($q) ?>">
        <select name="tipo">
            <option value="todos" <?= $tipo === 'todos' ? 'selected' : '' ?>>Todos</option>
            <option value="nome" <?= $tipo === 'nome' ? 'selected' : '' ?>>Nome</option>
            <option value="cpf" <?= $tipo === 'cpf' ? 'selected' : '' ?>>CPF</option>
        </select>
        <button type="submit">Filtrar</button>
    </div>
    <div class="search-actions">
        <a href="gerar_pdf.php" class="export-btn">📄 Baixar PDF</a>
        <a href="loja.php" class="back-btn">⬅ Voltar à Página Inicial</a>
    </div>
</form>

<table>
    <thead>
        <tr><th>Data / Hora</th><th>Nome</th><th>CPF</th><th>2FA</th></tr>
    </thead>
    <tbody>
    <?php if (isset($res) && $res && $res->num_rows > 0): ?>
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
</div>
</body>
</html>
