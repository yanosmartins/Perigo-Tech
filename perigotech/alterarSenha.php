<?php
session_start();
include_once('config.php');

if (!isset($_SESSION['id']) || !isset($_SESSION['nome'])) {
    header("Location: login.php");
    exit();
}

$erro = '';
$sucesso = '';

if (isset($_POST['alterar'])) {
    $senha_atual = $_POST['senha_atual'] ?? '';
    $nova_senha = $_POST['nova_senha'] ?? '';
    $conf_senha = $_POST['conf_senha'] ?? '';

    
    if (empty($senha_atual) || empty($nova_senha) || empty($conf_senha)) {
        $erro = "Todos os campos devem ser preenchidos!";
    } elseif ($nova_senha !== $conf_senha) {
        $erro = "A nova senha e a confirmação não coincidem!";
    } else {
        
        $id = $_SESSION['id'];
        $sql = "SELECT senha FROM usuarios WHERE id = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->bind_result($senha_hash_banco);
        $stmt->fetch();
        $stmt->close();

        if (!password_verify($senha_atual, $senha_hash_banco)) {
            $erro = "Senha atual incorreta!";
        } else {
            
            $nova_senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);
            $sql = "UPDATE usuarios SET senha = ? WHERE id = ?";
            $stmt = $conexao->prepare($sql);
            $stmt->bind_param("si", $nova_senha_hash, $id); 
            
            if ($stmt->execute()) {
                $sucesso = "Senha alterada com sucesso!";
            } else {
                $erro = "Erro ao atualizar senha. Tente novamente.";
            }
            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Alterar Senha</title>
<style>

body {
    background-image: url(img/Gemini_Generated_Image_km51uskm51uskm51.png );
    font-family: 'Poetsen One', sans-serif;
    background-color: #000;
    color: #fff;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}
.form-container {
    background-color: #dad5d5df;
    padding: 30px;
    border-radius: 20px;
    width: 350px;
    box-shadow: 5px 5px 15px rgba(255, 115, 0, 0.5);
}
.form-container h2 {
    text-align: center;
    color: #ff8c00;
    margin-bottom: 20px;
}
.form-container input[type="password"], 
.form-container input[type="submit"] {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border-radius: 5px;
    border: 1px solid #000;
}
.form-container input[type="submit"] {
    background-color: #ff8c00;
    color: #fff;
    font-weight: bold;
    cursor: pointer;
    border: none;
    transition: 0.3s;
}
.form-container input[type="submit"]:hover {
    background-color: #c27524;
}
.mensagem {
    text-align: center;
    font-weight: bold;
}
.erro { color: #ff4d4d; }
.sucesso { color: #4dff4d; }
</style>
</head>
<body>

<div class="form-container">
    <h2>Alterar Senha</h2>
    <form method="POST">
        <input type="password" name="senha_atual" placeholder="Senha Atual" required>
        <input type="password" name="nova_senha" placeholder="Nova Senha" required>
        <input type="password" name="conf_senha" placeholder="Confirmar Nova Senha" required>
        <input type="submit" name="alterar" value="Alterar Senha">
    </form>
    <?php if ($erro): ?>
        <div class="mensagem erro"><?= $erro ?></div>
    <?php elseif ($sucesso): ?>
        <div class="mensagem sucesso"><?= $sucesso ?></div>
    <?php endif; ?>
    <p style="text-align:center;"><a href="loja.php" style="color:#ff7300;">Voltar à Loja</a></p>
</div>

</body>
</html>
