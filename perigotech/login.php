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
      width: 10%;
      height: 500px;
      display: flex;
      box-shadow: 5px 5px 18px rgba(0, 0, 0, 0.2);
      border-radius: 20px;
      overflow: hidden;
      background: #fff;
    }

    /* Área da imagem (lado esquerdo) */
    .form-image {
      width: 50%;
      height: 100%;
      display: flex;
      justify-content: center;
      align-items: center;
      overflow: hidden;
    }

    /* A imagem se adapta sem distorcer */
    .form-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      /* cobre toda a área */
      border-radius: 0;
      /* remove borda arredondada para encaixar */
    }

    .container {
      width: 350px;
      padding: 2rem;
      background: rgba(255, 255, 255, 0.9);
      box-shadow: 5px 5px 18px rgba(0, 0, 0, 0.2);
      border-radius: 20px;
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

    .input-box {
      position: relative;
      margin-bottom: 1.2rem;
    }

    .input-box input {
      width: 79%;
      padding: 0.8rem 2.5rem 0.8rem 0.8rem;
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
      justify-content: space-between;
      align-items: center;
      font-size: 0.85rem;
      margin-bottom: 1.5rem;
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
      margin-left: -5px;
    }

    .login1 a {
      width: 100%;
      background: #ff8c00;
      color: #fff;
      padding: 0.2rem;
      border: none;
      border-radius: 8px;
      font-size: 1rem;
      font-weight: 600;
      cursor: pointer;
      text-decoration: none;
      color: white;
      display: flex;
      justify-content: center;
      align-items: center;

    }

    button.login:hover {
      background: #c27524;
    }

    /* Dark mode opcional */
    body.dark {
      background: #222;
    }

    body.dark .container {
      background: #333;
      color: #fff;
    }

    body.dark input {
      border-color: #555;
      background: #444;
      color: #fff;
    }

    body.dark button.login {
      background: #ff8c00;
    }

    @media screen and (max-width: 400px) {
      .container {
        width: 90%;
        padding: 1.5rem;
      }
    }

    @media screen and (max-width: 900px) {
      .form-image {
        display: none;
        /* Esconde a imagem no mobile */
      }

      .container {
        width: 90%;
        height: auto;
      }
    }
  </style>
</head>

<body>
  <div class="form-image">
    <img src="img/ChatGPT Image 12_09_2025, 18_41_39.png" alt="Imagem login" />
  </div>


  <main class="container">

    <form action="testeLogin.php" method="POST" id="form-login">
      <h1>LOGIN</h1>

      <div class="input-box">
        <input id="login" name="login" type="text" placeholder="login" required />
        <i class="bx bxs-user"></i>
      </div>

      <div class="input-box">
        <input id="senha" name="senha" type="password" placeholder="senha" required />
        <i class="bx bxs-lock-alt"></i>
      </div>

      <div class="lembrar-senha">
        <button><a onclick="abrirEsqueciSenha()">Esqueci a Senha</button></a>

      </div>

      <button type="submit" name="submit" class="login">ENVIAR</button>
      <br> <br>
      <button class="login1"><a href="cadastro.php">CADASTRA-SE</a> </button>

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
