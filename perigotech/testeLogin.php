<?php
session_start();
include_once('config.php'); // conexão com o banco

if (isset($_POST['submit']) && !empty($_POST['login']) && !empty($_POST['senha'])) {

    $login = $_POST['login'];
    $senha = $_POST['senha'];

    // Consulta o usuário no banco
    $stmt = $conexao->prepare("SELECT * FROM cadastro_tech WHERE login = ? AND senha = ?");
    $stmt->bind_param("ss", $login, $senha);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows < 1) {
        // Usuário não cadastrado
        header('Location: login.php?erro=nao_cadastrado');
        exit();
    } else {
        $user = $result->fetch_assoc();

        // Define variáveis de sessão
        $_SESSION['id'] = $user['idusuarios'];
        $_SESSION['nome'] = $user['nome'];
        $_SESSION['login'] = $user['login'];
        $_SESSION['tipo_user'] = $user['tipo_user'];
        $_SESSION['log_registrado'] = false; // flag para impedir log duplicado

        // Redireciona para o 2FA
        header('Location: 2fa.php');
        exit();
    }
} else {

    header('Location: login.php?erro=1');
    exit();
}
?>
