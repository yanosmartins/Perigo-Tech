<?php
session_start();
include "config.php"; // Usa o mesmo banco do cadastro

// Se o usuário não estiver logado, redireciona para o login
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

$emailUsuario = $_SESSION['email']; // pega o e-mail do usuário logado

// Perguntas possíveis
$perguntas = [
    "mae" => "Qual o nome da sua mãe?",
    "nascimento" => "Qual a data do seu nascimento?",
    "cep" => "Qual o CEP do seu endereço?"
];

// Seleciona pergunta aleatória se ainda não foi escolhida
if (!isset($_SESSION['pergunta_2fa'])) {
    $chaves = array_keys($perguntas);
    $randomKey = $chaves[array_rand($chaves)];
    $_SESSION['pergunta_2fa'] = $randomKey;
}
$perguntaAtual = $_SESSION['pergunta_2fa'];

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
            // Autenticação bem-sucedida
            unset($_SESSION['pergunta_2fa'], $_SESSION['tentativas_2fa']);
            header("Location: dashboard.php");
            exit;
        } else {
            $tentativas++;
            $_SESSION['tentativas_2fa'] = $tentativas;

            if ($tentativas >= 3) {
                unset($_SESSION['pergunta_2fa'], $_SESSION['tentativas_2fa']);
                header("Location: login.php");
                exit;
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
  <title>Autenticação 2FA</title>
</head>

<style>
body {
      font-family: Arial, sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
      transition: background-color 0.3s, color 0.3s;
      position: relative; 
}
.container {
      padding: 30px;
      border-radius: 12px;
      text-align: center;
      width: 350px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.2);
      transition: background-color 0.3s, box-shadow 0.3s, color 0.3s;
}

h2 { margin-bottom: 20px; }
.question { margin: 20px 0; font-size: 18px; font-weight: bold; }
input { 
  width: 100%; 
  padding: 10px; 
  font-size: 16px; 
  margin-bottom: 15px; 
  border-radius: 8px; 
  border: 1px solid; 
  text-align: center; 
  transition: background-color 0.3s, color 0.3s, border-color 0.3s; 
}
input::placeholder { transition: color 0.3s; }
button { 
  width: 100%; 
  padding: 12px; 
  border: none; 
  border-radius: 8px; 
  font-size: 16px; 
  cursor: pointer; 
  font-weight: bold; 
  transition: background-color 0.3s, color 0.3s; 
}
.error { margin-top: 10px; font-size: 14px; transition: color 0.3s; }
.theme-toggle { 
  position: absolute; 
  top: 20px; 
  right: 20px; 
  width: 40px; 
  height: 40px; 
  border-radius: 50%; 
  border: none; 
  cursor: pointer; 
  font-size: 20px; 
  display: flex; 
  align-items: center; 
  justify-content: center; 
  transition: background-color 0.3s, color 0.3s; 
}

/* Dark Mode */
body.dark { background-color: #0d1117; color: #c9d1d9; }
body.dark .container { background-color: #161b22; box-shadow: 0 4px 15px rgba(0,0,0,0.5); color: #c9d1d9; }
body.dark input { background-color: #0d1117; color: #c9d1d9; border-color: #30363d; }
body.dark input::placeholder { color: #8b949e; }
body.dark button { background-color: #238636; color: white; }
body.dark button:hover { background-color: #2ea043; }
body.dark .error { color: #f85149; }
body.dark .theme-toggle { background-color: #c9d1d9; color: #0d1117; }

/* Light Mode */
body.light { background-color: #f5f5f5; color: #0d1117; }
body.light .container { background-color: #ffffff; box-shadow: 0 4px 15px rgba(0,0,0,0.15); color: #0d1117; }
body.light input { background-color: #fff; color: #0d1117; border-color: #ccc; }
body.light input::placeholder { color: #888; }
body.light button { background-color: #4CAF50; color: white; }
body.light button:hover { background-color: #45a049; }
body.light .error { color: red; }
body.light .theme-toggle { background-color: #0d1117; color: #f5f5f5; }

</style>

<body class="dark">
  <button class="theme-toggle" id="toggleTheme">☀️</button>

  <div class="container">
    <h2>Verificação 2FA</h2>

    <!-- Pergunta aleatória -->
    <div id="question" class="question">
        <?php echo $perguntas[$perguntaAtual]; ?>
    </div>

    <!-- Formulário de resposta -->
    <form method="POST">
      <input type="text" name="answer" id="answer" placeholder="Digite sua resposta..." required>
      <button type="submit">Enviar</button>
    </form>

    <!-- Mensagem de erro -->
    <div id="message" class="error"><?php echo $mensagem; ?></div>
  </div>

<script>
    // ==== Alternar tema escuro/claro ====
    const toggleBtn = document.getElementById("toggleTheme");
    toggleBtn.addEventListener("click", () => {
      document.body.classList.toggle("dark");
      document.body.classList.toggle("light");

      toggleBtn.textContent = document.body.classList.contains("dark") ? "☀️" : "🌙";
    });
</script>

</body>
</html>
