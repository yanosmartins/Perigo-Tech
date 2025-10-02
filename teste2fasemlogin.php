<?php
session_start();
include "config.php"; // Conexão com o banco

// ===== SIMULA USUÁRIO LOGADO PARA TESTE =====
$_SESSION['email'] = "teste@teste.com"; // substitua pelo email existente no seu banco
$emailUsuario = $_SESSION['email'];

// Perguntas possíveis
$perguntas = [
    "mae" => "Qual o nome da sua mãe?",
    "nascimento" => "Qual a data do seu nascimento?",
    "cep" => "Qual o CEP do seu endereço?"
];

// ===== Gera pergunta aleatória a cada F5 =====
$chaves = array_keys($perguntas);
$perguntaAtual = $chaves[array_rand($chaves)];

$mensagem = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $resposta = trim($_POST['answer']);
    $tentativas = $_SESSION['tentativas_2fa'] ?? 0;

    if (empty($resposta)) {
        $mensagem = "⚠️ Preencha a resposta.";
    } else {
        // Consulta a resposta correta no banco
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = ? LIMIT 1");
        $stmt->bind_param("s", $emailUsuario);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $usuario = $resultado->fetch_assoc();

        $correto = false;
        if ($usuario) {
            if ($perguntaAtual === "mae" && strtolower($resposta) === strtolower($usuario['nome_mae'])) {
                $correto = true;
            } elseif ($perguntaAtual === "nascimento" && $resposta === $usuario['data_nascimento']) {
                $correto = true;
            } elseif ($perguntaAtual === "cep" && $resposta === $usuario['cep']) {
                $correto = true;
            }
        }

        if ($correto) {
            $mensagem = "✅ Autenticação bem-sucedida! (Simulado)";
            // Reset tentativas
            unset($_SESSION['tentativas_2fa']);
        } else {
            $tentativas++;
            $_SESSION['tentativas_2fa'] = $tentativas;

            if ($tentativas >= 3) {
                $mensagem = "❌ 3 tentativas incorretas. (Simulado)";
                unset($_SESSION['tentativas_2fa']);
            } else {
                $mensagem = "❌ Resposta incorreta. Tentativa {$tentativas}/3";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Teste 2FA</title>
  <style>
    body { font-family: Arial; display:flex; justify-content:center; align-items:center; height:100vh; margin:0; transition:0.3s; position:relative;}
    .container { padding:30px; border-radius:12px; text-align:center; width:350px; box-shadow:0 4px 15px rgba(0,0,0,0.2);}
    h2 { margin-bottom:20px; }
    .question { margin:20px 0; font-size:18px; font-weight:bold; }
    input { width:100%; padding:10px; font-size:16px; margin-bottom:15px; border-radius:8px; border:1px solid; text-align:center; }
    button { width:100%; padding:12px; border:none; border-radius:8px; font-size:16px; cursor:pointer; font-weight:bold; }
    .error { margin-top:10px; font-size:14px; }
    .theme-toggle { position:absolute; top:20px; right:20px; width:40px; height:40px; border-radius:50%; border:none; cursor:pointer; font-size:20px; display:flex; align-items:center; justify-content:center; }

    /* Modo Escuro */
    body.dark { background:#0d1117; color:#c9d1d9; }
    body.dark .container { background:#161b22; color:#c9d1d9; }
    body.dark input { background:#0d1117; color:#c9d1d9; border-color:#30363d; }
    body.dark button { background:#238636; color:white; }
    body.dark .error { color:#f85149; }
    body.dark .theme-toggle { background:#c9d1d9; color:#0d1117; }

    /* Modo Claro */
    body.light { background:#f5f5f5; color:#0d1117; }
    body.light .container { background:#fff; color:#0d1117; }
    body.light input { background:#fff; color:#0d1117; border-color:#ccc; }
    body.light button { background:#4CAF50; color:white; }
    body.light .error { color:red; }
    body.light .theme-toggle { background:#0d1117; color:#f5f5f5; }
  </style>
</head>
<body class="dark">
  <button class="theme-toggle" id="toggleTheme">☀️</button>

  <div class="container">
    <h2>Teste 2FA</h2>
    <div class="question"><?php echo $perguntas[$perguntaAtual]; ?></div>

    <form method="POST">
      <input type="text" name="answer" id="answer" placeholder="Digite sua resposta..." required>
      <button type="submit">Enviar</button>
    </form>

    <div class="error"><?php echo $mensagem; ?></div>
  </div>

  <script>
    const toggleBtn = document.getElementById("toggleTheme");
    toggleBtn.addEventListener("click", () => {
      document.body.classList.toggle("dark");
      document.body.classList.toggle("light");
      toggleBtn.textContent = document.body.classList.contains("dark") ? "☀️" : "🌙";
    });
  </script>
</body>
</html>
