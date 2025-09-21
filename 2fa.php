<?php
session_start();

// Se o usuário não estiver logado, redireciona para o login
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

$emailUsuario = $_SESSION['email']; // pega o e-mail do usuário logado
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Autenticação 2FA</title>
</head>

<body class="dark">
  <!-- Botão de alternar tema no canto superior direito -->
  <button class="theme-toggle" id="toggleTheme">☀️</button>

  <div class="container">
    <h2>Verificação 2FA</h2>
    
    <!-- Pergunta aleatória -->
    <div id="question" class="question"></div>
    
    <!-- Formulário de resposta -->
    <form id="form2fa">
      <input type="text" id="answer" placeholder="Digite sua resposta..." required>
      <button type="submit">Enviar</button>
    </form>
    
    <!-- Mensagem de erro -->
    <div id="message" class="error"></div>
  </div>

<style>
/* CSS Base */
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

    /* Container central */
    .container {
      padding: 30px;
      border-radius: 12px;
      text-align: center;
      width: 350px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.2);
      transition: background-color 0.3s, box-shadow 0.3s, color 0.3s;
    }

    h2 {
      margin-bottom: 20px;
    }

    .question {
      margin: 20px 0;
      font-size: 18px;
      font-weight: bold;
    }

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

    input::placeholder {
      transition: color 0.3s;
    }

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

    .error {
      margin-top: 10px;
      font-size: 14px;
      transition: color 0.3s;
    }

    /* ===== Botão de alternar tema ===== */
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

    /* ===== Tema escuro ===== */
    body.dark {
      background-color: #0d1117;
      color: #c9d1d9;
    }

    body.dark .container {
      background-color: #161b22;
      box-shadow: 0 4px 15px rgba(0,0,0,0.5);
      color: #c9d1d9;
    }

    body.dark input {
      background-color: #0d1117;
      color: #c9d1d9;
      border-color: #30363d;
    }

    body.dark input::placeholder {
      color: #8b949e;
    }

    body.dark button {
      background-color: #238636;
      color: white;
    }

    body.dark button:hover {
      background-color: #2ea043;
    }

    body.dark .error {
      color: #f85149;
    }

    body.dark .theme-toggle {
      background-color: #c9d1d9;
      color: #0d1117;
    }

    /* ===== Tema claro ===== */
    body.light {
      background-color: #f5f5f5;
      color: #0d1117;
    }

    body.light .container {
      background-color: #ffffff;
      box-shadow: 0 4px 15px rgba(0,0,0,0.15);
      color: #0d1117;
    }

    body.light input {
      background-color: #fff;
      color: #0d1117;
      border-color: #ccc;
    }

    body.light input::placeholder {
      color: #888;
    }

    body.light button {
      background-color: #4CAF50;
      color: white;
    }

    body.light button:hover {
      background-color: #45a049;
    }

    body.light .error {
      color: red;
    }

    body.light .theme-toggle {
      background-color: #0d1117;
      color: #f5f5f5;
    }
  </style>

<script>
    // ==== Perguntas possíveis ====
    const perguntas = [
      { id: "mae", texto: "Qual o nome da sua mãe?" },
      { id: "nascimento", texto: "Qual a data do seu nascimento?" },
      { id: "cep", texto: "Qual o CEP do seu endereço?" }
    ];

    // Seleciona pergunta aleatória
    let perguntaAtual = perguntas[Math.floor(Math.random() * perguntas.length)];
    document.getElementById("question").innerText = perguntaAtual.texto;

    let tentativas = 0;

    // ==== Validação do formulário ====
    document.getElementById("form2fa").addEventListener("submit", async (e) => {
      e.preventDefault();
      const resposta = document.getElementById("answer").value.trim();
      const messageDiv = document.getElementById("message");

      if (!resposta) {
        messageDiv.innerText = "⚠️ Preencha a resposta.";
        return;
      }

      const usuarioEmail = "<?php echo $emailUsuario; ?>";

      const res = await fetch("verificar_2fa.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ pergunta: perguntaAtual.id, resposta, email: usuarioEmail })
      });

      const data = await res.json();

      if (data.sucesso) {
        alert("✅ Autenticação bem-sucedida!");
        window.location.href = "/dashboard.php";
      } else {
        tentativas++;
        if (tentativas >= 3) {
          alert("3 tentativas sem sucesso! Favor realizar Login novamente.");
          window.location.href = "/login.php";
        } else {
          messageDiv.innerText = `❌ Resposta incorreta. Tentativa ${tentativas}/3`;
          document.getElementById("answer").value = "";
        }
      }
    });

    // ==== Alternar tema escuro/claro ====
    const toggleBtn = document.getElementById("toggleTheme");
    toggleBtn.addEventListener("click", () => {
      document.body.classList.toggle("dark");
      document.body.classList.toggle("light");

      // Troca o ícone do botão
      if (document.body.classList.contains("dark")) {
        toggleBtn.textContent = "☀️"; // Sol para tema escuro
      } else {
        toggleBtn.textContent = "🌙"; // Lua para tema claro
      }
    });
  </script>

</body>
</html>
