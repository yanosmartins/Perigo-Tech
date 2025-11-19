<?php
session_start();
include_once('config.php');

if (isset($_POST['submit']) && !empty($_POST['login']) && !empty($_POST['senha'])) {

    $login = $_POST['login'];
    $senha_digitada = $_POST['senha'];

    $stmt = $conexao->prepare("SELECT * FROM usuarios WHERE login = ?");
    $stmt->bind_param("s", $login);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        
        $user = $result->fetch_assoc();
        $senha_hash_salva = $user['senha'];

        if (password_verify($senha_digitada, $senha_hash_salva)) {
            
            $_SESSION['id'] = $user['id']; 
            $_SESSION['nome'] = $user['nome'];
            $_SESSION['login'] = $user['login'];
            $_SESSION['cpf'] = $user['cpf'];
            $_SESSION['tipo'] = $user['tipo'];
            $_SESSION['log_registrado'] = false;

            header('Location: 2fa.php');
            exit();

        } else {

            header('Location: login.php?erro=1');
            exit();
        }

    } else {
        header('Location: login.php?erro=1');
        exit();
    }
} else {
    header('Location: login.php?erro=1');
    exit();
}
?>
