<?php
session_start();

// Limpando todas as variáveis de sessão
$_SESSION = [];

// Deleta o cookie de sessão, se usado
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destrói a sessão
session_destroy();

header('Location: testeLogin.php');
exit();
