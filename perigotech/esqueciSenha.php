<?php
session_start();
include_once('config.php');

$erro = '';
$sucesso = '';

if (isset($_POST['alterar'])) {
    $login = $_POST['login'] ?? '';
    $nova_senha = $_POST['nova_senha'] ?? '';
    $confirma_senha = $_POST['confirma_senha'] ?? '';

    if (empty($login) || empty($nova_senha) || empty($confirma_senha)) {
        $erro = "Preencha todos os campos!";
    } elseif ($nova_senha !== $confirma_senha) {
        $erro = "As senhas não coincidem!";
    } else {

        $sql = "SELECT id FROM usuarios WHERE login = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("s", $login);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {

            $stmt->bind_result($id);
            $stmt->fetch();
            $stmt->close();

            $nova_senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);

            $sql_update = "UPDATE usuarios SET senha = ? WHERE id = ?";
            $stmt_update = $conexao->prepare($sql_update);

            $stmt_update->bind_param("si", $nova_senha_hash, $id);

            if ($stmt_update->execute()) {
                $sucesso = "Senha alterada com sucesso! Você já pode fechar esta janela.";
            } else {
                $erro = "Erro ao atualizar a senha: " . $stmt_update->error;
            }
            $stmt_update->close();
        } else {
            $erro = "Login não encontrado!";
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

        .form-container input[type="text"],
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

        .erro {
            color: #ff4d4d;
        }

        .sucesso {
            color: #4dff4d;
        }
    </style>
</head>

<body>

    <div class="form-container">
        <h2>Alterar Senha</h2>
        <form method="POST">
            <input type="text" name="login" placeholder="Digite seu login" required>
            <input type="password" name="nova_senha" placeholder="Nova senha" required>
            <input type="password" name="confirma_senha" placeholder="Confirme a nova senha" required>
            <input type="submit" name="alterar" value="Alterar Senha">
        </form>

        <?php if ($erro): ?>
            <div class="mensagem erro"><?= $erro ?></div>
        <?php elseif ($sucesso): ?>
            <div class="mensagem sucesso"><?= $sucesso ?></div>
        <?php endif; ?>

        <p style="text-align:center; color:#ff7300; margin-top: 10px;">Pode fechar esta janela após alterar.</p>
    </div>

</body>

</html>
