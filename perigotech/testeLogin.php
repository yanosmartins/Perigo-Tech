<?php
session_start();

if (isset($_POST['submit']) && !empty($_POST['login']) && !empty($_POST['senha'])) {

    include_once('config.php');
    $login = $_POST['login'];
    $senha = $_POST['senha'];


    $sql = "SELECT * FROM usuarios WHERE login = '$login' and senha = '$senha'";
    
    $result = $conexao->query($sql);

    unset($_SESSION['senha']);
    if (mysqli_num_rows($result) < 1) {
        echo "Login inválido! ";
        unset($_SESSION['login']);
        header('Location: login.php');
        exit();
    } else {
        $user = $result->fetch_assoc();
        $_SESSION['id'] = $user['id'];
        $_SESSION['nome'] = $user['nome'];
        $_SESSION['login'] = $login;

        if ($user['tipo'] == 'master') {
            $_SESSION['admin'] = true;
            // header('Location: 2fa.php');
            // exit();
        } else {
            $_SESSION['admin'] = false;
            // header('Location: 2fa.php');
            // exit();
        }
        header('Location: 2fa.php');
    }
} else {
    echo "Login inválido! ";
    header('Location: login.php');
}
