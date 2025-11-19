<?php
session_start();
$msg_erro = "";

if (isset($_GET['erro'])) {
    if ($_GET['erro'] == '1') {
        $msg_erro = "Login ou senha incorretos. Tente novamente.";
    } elseif ($_GET['erro'] == '3') {
        $msg_erro = "3 tentativas de 2FA falharam. Por favor, realize o login novamente.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>LOGIN</title>
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700;900&display=swap');

    body {
      height: 100vh;
      margin: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      background-image: url(img/Gemini_Generated_Image_km51uskm51uskm51.png );
      background-position: center;
      background-repeat: no-repeat;
      background-size: cover;
      background-attachment: fixed;
    }

    .container {
      width: 350px;
      padding: 2rem;
      background: rgba(255, 255, 255, 0.9);
      box-shadow: 5px 5px 18px rgba(0, 0, 0, 0.2);
      border-radius: 20px;
      display: flex;
      flex-direction: column;
    }

    .form-image {
      display: none;
    }

    form h1 {
      text-align: center;
      margin-bottom: 1.5rem;
      color: #333;
      position: relative;
    }

    form h1::after {
      content: "";
      display: block;
      width: 60px;
      height: 3px;
      background: #ff8c00;
      margin: 0.5rem auto 0;
      border-radius: 5px;
    }

    .erro-msg {
        background-color: #ffe0e0;
        color: #d8000c;
        border: 1px solid #d8000c;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 1.5rem;
        text-align: center;
        font-size: 0.9rem;
        font-weight: bold;
        width: 100%;
        box-sizing: border-box;
    }

    .input-box {
      position: relative;
      margin-bottom: 1.2rem;
    }

    .input-box input {
      width: 100%;
      padding: 0.8rem 2.5rem 0.8rem 0.8rem;
      box-sizing: border-box;
      border: 1px solid #333;
      border-radius: 8px;
      font-size: 0.95rem;
      outline: none;
      transition: border 0.3s, background 0.3s;
    }

    .input-box input:focus {
      border-color: #ff8c00;
    }

    .input-box input:hover {
      background: rgba(220, 169, 110, 0.3);
    }

    .input-box i {
      position: absolute;
      right: 10px;
      top: 50%;
      transform: translateY(-50%);
      font-size: 1.2rem;
      color: #555;
    }

    .lembrar-senha {
      display: flex;
      justify-content: center;
      align-items: center;
      font-size: 0.85rem;
      margin-bottom: 1.5rem;
    }

    .lembrar-senha button {
        background: none;
        border: none;
        cursor: pointer;
        padding: 0;
    }

    .lembrar-senha a {
      text-decoration: none;
      color: #ff8c00;
      font-weight: 500;
    }

    .lembrar-senha a:hover {
      text-decoration: underline;
    }

    button.login {
      width: 100%;
      padding: 0.9rem;
      background: #ff8c00;
      border: none;
      border-radius: 8px;
      color: #fff;
      font-size: 1rem;
      font-weight: 600;
      cursor: pointer;
      transition: background 0.3s;
    }

    .login1 {
      border: none;
      width: 92%;
      margin-top: 10px;
    }

    .login1 a {
      width: 100%;
      background: #ff8c00;
      color: #fff;
      padding: 0.9rem;
      border: none;
      border-radius: 8px;
      font-size: 1rem;
      font-weight: 600;
      cursor: pointer;
      text-decoration: none;
      display: flex;
      justify-content: center;
      align-items: center;
      transition: background 0.3s;
    }
    
    .login1 a:hover, button.login:hover {
        background: #c27524;
    }

    @media screen and (max-width: 400px) {
      .container {
        width: 90%;
        padding: 1.5rem;
      }
    }
  </style>
</head>

<body>
  <main class="container">
    <form action="testeLogin.php" method="POST" id="form-login">
      <h1>LOGIN</h1>

      <?php if (!empty($msg_erro)): ?>
          <div class="erro-msg">
              <?php echo $msg_erro; ?>
          </div>
      <?php endif; ?>
      <div class="input-box">
        <input id="login" name="login" type="text" placeholder="login" required />
        <i class="bx bxs-user"></i>
      </div>

      <div class="input-box">
        <input id="senha" name="senha" type="password" placeholder="senha" required />
        <i class="bx bxs-lock-alt"></i>
      </div>

      <div class="lembrar-senha">
        <button type="button" onclick="abrirEsqueciSenha()"><a>Esqueci a Senha</a></button>
      </div>

      <button type="submit" name="submit" class="login">ENTRAR</button>
      
      <div class="login1">
          <a href="cadastro.php">CADASTRE-SE</a>
      </div>

    </form>
  </main>

</body>
<script>
  function abrirEsqueciSenha() {
    const width = 400;
    const height = 500;
    const left = (screen.width / 2) - (width / 2);
    const top = (screen.height / 2) - (height / 2)
    window.open('esqueciSenha.php', 'esqueciaenha', `width=${width},height=${height},top=${top},left=${left},resizable=yes,scrollbars=yes`);
  }
</script>

</html>
