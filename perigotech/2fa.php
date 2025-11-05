<?php
session_start();
include_once('config.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}

// Perguntas de 2FA
$perguntas = [
    'cpf' => 'Qual seu CPF?',
    'endereco' => 'Qual seu endereço?',
    'nome_mae' => 'Qual o nome da sua mãe?'
];

// Escolhe pergunta aleatória se ainda não tiver sido definida
if (!isset($_SESSION['2fa_pergunta'])) {
    $_SESSION['2fa_pergunta'] = array_rand($perguntas);
}
$campo = $_SESSION['2fa_pergunta'];

// Busca os dados do usuário
$id = $_SESSION['id'];
$stmt = $conexao->prepare("SELECT cpf, endereco, nome_mae, tipo_user FROM cadastro_tech WHERE idusuarios = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$dados = $result->fetch_assoc();

// Inicializa variável de erro
$erro = '';

// Verifica a resposta enviada
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $resposta = isset($_POST[$campo]) ? trim($_POST[$campo]) : '';
    if ($resposta === $dados[$campo]) {
        $_SESSION['2fa_autenticado'] = true;
        unset($_SESSION['2fa_pergunta']);

        // Registra o log **uma única vez**
        $stmtLog = $conexao->prepare("INSERT INTO auth_logs (usuario_nome, usuario_cpf, segundo_fator, data_login) VALUES (?, ?, ?, NOW())");
        $stmtLog->bind_param(
            "sss",
            $_SESSION['nome'],
            $dados['cpf'],
            $perguntas[$campo]
        );
        $stmtLog->execute();

        // Redireciona de acordo com o tipo de usuário
        if ($dados['tipo_user'] === 'master') {
            header('Location: sistema.php');
        } else {
            header('Location: loja.php');
        }
        exit();
    } else {
        $erro = 'Resposta incorreta. Tente novamente.';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Autenticação de 2 Fatores</title>
<style>
body {
  font-family: Arial, sans-serif;
  background-image: url(img/Gemini_Generated_Image_km51uskm51uskm51.png);
  background-size: cover;
  background-position: center;
}
.container {
  max-width: 400px;
  margin: 60px auto;
  background: #fff;
  padding: 2rem;
  border-radius: 10px;
  box-shadow: 0 0 10px #ccc;
}
h2 { text-align: center; color: #ff7300; }
label { font-weight: bold; margin-top: 1rem; display: block; }
input[type="text"] { width: 100%; padding: 0.5rem; margin-top: 0.3rem; border-radius: 5px; border: 1px solid #ccc; }
button { background: #ff7300; color: #fff; border: none; padding: 0.7rem 1.5rem; border-radius: 5px; margin-top: 1.5rem; cursor: pointer; font-weight: bold; }
.erro { color: red; text-align: center; margin-bottom: 1rem; }
</style>
</head>
<body>
<div class="container">
<h2>Autenticação de 2 Fatores</h2>
<?php if (!empty($erro)): ?>
  <div class="erro"><?= htmlspecialchars($erro) ?></div>
<?php endif; ?>
<form method="POST">
  <label for="<?= $campo ?>"><?= $perguntas[$campo] ?></label>
  <input type="text" name="<?= $campo ?>" id="<?= $campo ?>" required>
  <button type="submit">Confirmar</button>
</form>
</div>
</body>
</html>
