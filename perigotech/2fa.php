<?php
session_start();
include_once('config.php');

if (!isset($_SESSION['idusuarios'])) {
  header('Location: login.php');
  exit();
}

$perguntas = [
  'cpf' => 'Qual seu CPF?',
  'endereco' => 'Qual seu endereço?',
  'nome_mae' => 'Qual o nome da sua mãe?'
];

if (!isset($_SESSION['2fa_pergunta'])) {
  $_SESSION['2fa_pergunta'] = array_rand($perguntas);
}
$campo = $_SESSION['2fa_pergunta'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = $_SESSION['idusuarios'];
  $sql = "SELECT cpf, endereco, nome_mae FROM cadastro_tech WHERE idusuarios = ?";
  $stmt = $conexao->prepare($sql);
  $stmt->bind_param('i', $id);
  $stmt->execute();
  $result = $stmt->get_result();
  $dados = $result->fetch_assoc();

  $resposta = isset($_POST[$campo]) ? trim($_POST[$campo]) : '';
  $ok = strcasecmp($resposta, $dados[$campo]) === 0;

  if ($ok) {
    $_SESSION['2fa_autenticado'] = true;
    unset($_SESSION['2fa_pergunta']);
    header('Location: loja.php');
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
        body { font-family: Arial, sans-serif; background-image: url(img/Gemini_Generated_Image_km51uskm51uskm51.png ); }
        .container { max-width: 400px; margin: 60px auto; background: #fff; padding: 2rem; border-radius: 10px; box-shadow: 0 0 10px #ccc; }
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
        <?php if (isset($erro)): ?>
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
