<?php
session_start();
include_once('config.php'); // conexão com o banco

if (isset($_POST['submit']) && !empty($_POST['login']) && !empty($_POST['senha'])) {

    $login = $_POST['login'];
    $senha = $_POST['senha'];

    $stmt = $conexao->prepare("SELECT * FROM usuarios WHERE login = ? AND senha = ?");
    $stmt->bind_param("ss", $login, $senha);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows < 1) {
        // Usuário não cadastrado ou senha incorreta
        header('Location: login.php?erro=1');
        exit();
    } else {
        $user = $result->fetch_assoc();
        $_SESSION['id'] = $user['id'];
        $_SESSION['nome'] = $user['nome'];
        $_SESSION['login'] = $user['login'];
        $_SESSION['cpf'] = $user['cpf'];
        $_SESSION['tipo'] = $user['tipo'];

        // Inicializa variável de log
        $_SESSION['log_registrado'] = false;

        // Redireciona para 2FA
        header('Location: 2fa.php');
        exit();
    }
} else {
    header('Location: login.php?erro=1');
    exit();
}
?>
