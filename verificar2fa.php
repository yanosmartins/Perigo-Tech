<?php
session_start();
include "config.php"; // Conexão com o banco

// Verifica se o usuário está logado
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

$email = $_SESSION['email']; // pega email do usuário logado
$pergunta = $_SESSION['pergunta_2fa'] ?? null;
$resposta = trim($_POST['answer'] ?? '');
$tentativas = $_SESSION['tentativas_2fa'] ?? 0;

// Mensagem de feedback
$mensagem = "";

// Processa a resposta
if ($pergunta && $resposta !== "") {
    // Busca o usuário no banco
    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();
        $correto = false;

        // Valida a resposta com SQL e PHP
        switch ($pergunta) {
            case "mae":
                if (strcasecmp($usuario["nome_mae"], $resposta) == 0) $correto = true;
                break;
            case "nascimento":
                if ($usuario["data_nasc"] == $resposta) $correto = true;
                break;
            case "cep":
                if ($usuario["cep"] == $resposta) $correto = true;
                break;
        }

        if ($correto) {
            // Sucesso
            unset($_SESSION['pergunta_2fa'], $_SESSION['tentativas_2fa']);
            header("Location: dashboard.php");
            exit;
        } else {
            // Erro
            $tentativas++;
            $_SESSION['tentativas_2fa'] = $tentativas;

            if ($tentativas >= 3) {
                unset($_SESSION['pergunta_2fa'], $_SESSION['tentativas_2fa']);
                header("Location: login.php");
                exit;
            } else {
                $mensagem = "❌ Resposta incorreta. Tentativa $tentativas/3";
                $_SESSION['mensagem_2fa'] = $mensagem;
                header("Location: 2fa.php");
                exit;
            }
        }
    } else {
        // Usuário não encontrado
        unset($_SESSION['pergunta_2fa'], $_SESSION['tentativas_2fa']);
        header("Location: login.php");
        exit;
    }
} else {
    // Resposta vazia ou pergunta não definida
    $_SESSION['mensagem_2fa'] = "⚠️ Preencha a resposta.";
    header("Location: 2fa.php");
    exit;
}
