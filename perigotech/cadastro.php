<?php
session_start();
include_once('config.php');

$mensagem_erro = '';
if (isset($_SESSION['msg'])) {
  $mensagem_erro = $_SESSION['msg'];
  unset($_SESSION['msg']);
}


if (isset($_POST['submit'])) {
  $nome        = $_POST['nome'] ?? '';
  $email       = $_POST['email'] ?? '';
  $telefone    = $_POST['telefone'] ?? '';
  $endereco    = $_POST['endereco'] ?? '';
  $data_nasc   = $_POST['datanascimento'] ?? '';
  $sexo        = $_POST['sexo'] ?? '';
  $cep         = $_POST['cep'] ?? '';
  $cpf         = $_POST['cpf'] ?? '';
  $login       = $_POST['login'] ?? '';
  $senha_plana = $_POST['senha'] ?? '';
  $confirmaSenha = $_POST['confirmaSenha'] ?? '';
  $nome_mae    = $_POST['nome_mae'] ?? '';

  $erros = [];

  if (strlen($nome) < 15 || strlen($nome) > 80) {
    $erros[] = "Nome: Deve ter entre 15 e 80 caracteres.";
  }

  if (!preg_match('/^[a-zA-Z\s]+$/', $nome)) {
    $erros[] = "Nome: Deve conter apenas letras e espaços.";
  }

  if (strlen($login) !== 6) {
    $erros[] = "Login: Deve ter exatamente 6 caracteres.";
  }
  if (!ctype_alpha($login)) {
    $erros[] = "Login: Deve conter apenas letras (sem números ou símbolos).";
  }

  if (strlen($senha_plana) !== 8) {
    $erros[] = "Senha: Deve ter exatamente 8 caracteres.";
  }
  if (!ctype_alpha($senha_plana)) {
    $erros[] = "Senha: Deve conter apenas letras (sem números ou símbolos).";
  }

  if ($senha_plana !== $confirmaSenha) {
    $erros[] = "As senhas não coincidem.";
  }

  if (!empty($erros)) {
    $_SESSION['msg'] = implode("<br>", $erros);
    header("Location: cadastro.php");
    exit;
  } else {
    
    $senha_hash = password_hash($senha_plana, PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios 
                  (nome, email, telefone, endereco, data_nascimento, sexo, cep, cpf, login, senha, nome_mae, tipo)
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'comum')";

    $stmt = $conexao->prepare($sql);

    if ($stmt === false) {
      $_SESSION['msg'] = "Erro ao preparar a query: " . $conexao->error;
      header("Location: cadastro.php");
      exit;
    }

    $stmt->bind_param(
      'sssssssssss',
      $nome,
      $email,
      $telefone,
      $endereco,
      $data_nasc,
      $sexo,
      $cep,
      $cpf,
      $login,
      $senha_hash,
      $nome_mae
    );

    if ($stmt->execute()) {
      $_SESSION['msg'] = "Cadastro realizado com sucesso!";
      header("Location: login.php");
      exit;
    } else {
      if ($conexao->errno == 1062) {
        $_SESSION['msg'] = "Erro: O Login ou CPF/Email informado já existe.";
      } else {
        $_SESSION['msg'] = "Erro ao cadastrar: " . $stmt->error;
      }
      header("Location: cadastro.php");
      exit;
    }
  }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1.0" />
  <title>Cadastro</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Poetsen+One&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

    * {
      padding: 0;
      margin: 0;
      box-sizing: border-box;
      font-family: "Poetsen One", sans-serif;
    }

    body {
      width: 100%;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      background-image: url(img/Gemini_Generated_Image_km51uskm51uskm51.png );
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
    }

    .container {
      width: 75%;
      height: 95vh;
      display: flex;
      box-shadow: 5px 5px 18px rgba(255, 255, 255, 0.866);
      border-radius: 30px;
      overflow: hidden;
    }

    .form-image {
      width: 50%;
      display: flex;
      justify-content: center;
      align-items: center;
      background-color: transparent;
      padding: 1rem;
    }

    .form-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      border-radius: 30px 0 0 30px;
    }

    .form {
      width: 50%;
      background-color: #dad5d5df;
      padding: 2rem;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
    }

    .form-header {
      margin-bottom: 2rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      position: relative;
    }

    .form-header h1::after {
      content: '';
      display: block;
      width: 5rem;
      height: 0.3rem;
      background-color: #ff8c00;
      margin: 0 auto;
      border-radius: 10px;
    }

    .login-button {
      display: flex;
      align-items: center;
    }

    .login-button button {
      border: none;
      background-color: #ff8c00;
      padding: 0.5rem 1rem;
      border-radius: 9px;
      margin-left: 1rem;
      cursor: pointer;
      color: #fff;
      font-weight: 550;
    }

    .login-button button:hover {
      background-color: #c27524;
    }

    .input-group {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      gap: 1rem;
    }

    .input-box {
      margin-bottom: 1.1rem;
      width: 45%;
      display: flex;
      flex-direction: column;
    }

    .input-box input {
      padding: 0.4rem;
      border: 1px solid #000;
      border-radius: 5px;
      outline: none;
      font-size: 0.9rem;
      transition: 0.3s;
    }

    .input-box input:hover {
      background-color: rgba(220, 169, 110, 0.2);
    }

    .input-box input:focus-visible {
      outline: 1px solid #ff8c00;
    }

    .input-box label,
    .gender-title h6 {
      font-size: 0.9rem;
      font-weight: 500;
      color: #000;
    }

    .input-box input::placeholder {
      font-size: 0.8rem;
      color: #1f1616ae;
    }

    .erro-backend {
      background-color: #ffe0e0;
      color: #d8000c;
      border: 1px solid #d8000c;
      padding: 10px;
      border-radius: 5px;
      margin-bottom: 1.5rem;
      text-align: left;
      font-size: 0.9rem;
      width: 100%;
    }

    @media screen and (max-width: 1330px) {
      .form-image {
        display: none;
      }

      .container {
        width: 60%;
      }

      .form {
        width: 100%;
        border-radius: 30px;
      }
    }

    @media screen and (max-width: 500px) {
      .container {
        width: 90%;
        height: auto;
        margin: 2rem 0;
        flex-direction: column;
      }

      .input-box {
        width: 100%;
      }
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="form-image">
      <img src="img/ChatGPT Image 12_09_2025, 18_41_39.png" alt="Imagem login" />
    </div>

    <div class="form">
      <form id="cadastroForm" action="cadastro.php" method="POST">
        <div class="form-header">
          <div class="title">
            <h1>CADASTRE-SE</h1>
          </div>

          <div class="login-button">
            <button type="submit" name="submit">ENVIAR</button>
            <button type="reset">LIMPAR</button>
          </div>
        </div>

        <?php if (!empty($mensagem_erro)): ?>
          <div class="erro-backend">
            <strong>O cadastro falhou:</strong><br>
            <?php echo $mensagem_erro; ?>
          </div>
        <?php endif; ?>
        <div class="input-group">
          <div class="input-box">
            <label for="nome">Nome Completo</label>
            <input id="nome" name="nome" type="text" placeholder="Digite seu nome completo" required />
          </div>

          <div class="input-box">
            <label for="email">Email</label>
            <input id="email" name="email" type="email" placeholder="Digite seu email" required />
          </div>

          <div class="input-box">
            <label for="senha">Senha</label>
            <input id="senha" name="senha" type="password" placeholder="Digite sua senha" required />
          </div>

          <div class="input-box">
            <label for="confirmaSenha">Confirmar Senha</label>
            <input id="confirmaSenha" name="confirmaSenha" type="password" placeholder="Confirme sua senha" required />
          </div>

          <div class="input-box">
            <label for="login">Login</label>
            <input id="login" name="login" type="text" placeholder="Crie seu Login" required />
          </div>

          <div class="input-box">
            <label for="cep">CEP</label>
            <input id="cep" name="cep" type="text" placeholder="Digite seu CEP" />
          </div>

          <div class="input-box">
            <label for="telefone">Telefone Celular</label>
            <input id="telefone" name="telefone" type="tel" placeholder="(99) 99999-9999" required />
          </div>

          <div class="input-box">
            <label for="endereco">Endereço Completo</label>
            <input id="endereco" name="endereco" type="text" placeholder="Digite seu endereço" required />
          </div>

          <div class="input-box">
            <label for="telFixo">Telefone Fixo</label>
            <input id="telFixo" name="telFixo" type="tel" placeholder="(99) 9999-9999" />
          </div>

          <div class="Sexo">
            <label>Sexo</label><br />
            <input type="radio" id="sexoM" name="sexo" value="Masculino" required /> Masculino
            <input type="radio" id="sexoF" name="sexo" value="Feminino" /> Feminino
          </div>

          <div class="input-box">
            <label for="datanascimento">Data de Nascimento</label>
            <input id="datanascimento" name="datanascimento" type="date" required maxlength="10" />
          </div>

          <div class="input-box">
            <label for="cpf">CPF</label>
            <input id="cpf" name="cpf" type="text" placeholder="000.000.000-00" required maxlength="14" />
          </div>

          <div class="input-box">
            <label for="nome_mae">Nome da sua mãe</label>
            <input id="nome_mae" name="nome_mae" type="text" placeholder="Nome da sua mãe" required />
          </div>
        </div>

        <p id="mensagem" aria-live="polite"></p>
      </form>
    </div>
  </div>

  <script>
    const form = document.getElementById('cadastroForm');
    const mensagem = document.getElementById('mensagem');

    form.addEventListener('submit', function(e) {
      const senha = document.getElementById('senha').value;
      const confirmaSenha = document.getElementById('confirmaSenha').value;

      if (senha !== confirmaSenha) {
        e.preventDefault();
        mensagem.textContent = 'As senhas não coincidem.';
        mensagem.style.color = 'red';
        return;
      }
    });

    form.addEventListener('reset', function() {
      mensagem.textContent = '';
      mensagem.style.color = '';
    });

    function mascaraCPF(valor) {
      return valor
        .replace(/\D/g, '')
        .replace(/(\d{3})(\d)/, '$1.$2')
        .replace(/(\d{3})(\d)/, '$1.$2')
        .replace(/(\d{3})(\d{1,2})$/, '$1-$2');
    }

    function mascaraTelCelular(valor) {
      valor = valor.replace(/\D/g, '');
      if (valor.length > 11) valor = valor.slice(0, 11);
      valor = valor.replace(/^(\d{2})(\d)/g, '($1) $2');
      valor = valor.replace(/(\d{5})(\d)/, '$1-$2');
      return valor;
    }

    function mascaraTelFixo(valor) {
      valor = valor.replace(/\D/g, '');
      if (valor.length > 10) valor = valor.slice(0, 10);
      valor = valor.replace(/^(\d{2})(\d)/g, '($1) $2');
      valor = valor.replace(/(\d{4})(\d)/, '$1-$2');
      return valor;
    }

    document.getElementById('cpf').addEventListener('input', function(e) {
      e.target.value = mascaraCPF(e.target.value);
    });

    document.getElementById('telefone').addEventListener('input', function(e) {
      e.target.value = mascaraTelCelular(e.target.value);
    });

    document.getElementById('telFixo').addEventListener('input', function(e) {
      e.target.value = mascaraTelFixo(e.target.value);
    });

    document.getElementById('cep').addEventListener('blur', function() {
      const cep = this.value.replace(/\D/g, '');
      if (cep.length === 8) {
        fetch(`https://viacep.com.br/ws/${cep}/json/`)
          .then(response => response.json())
          .then(data => {
            if (!data.erro) {
              document.getElementById('endereco').value =
                `${data.logradouro}, ${data.bairro}, ${data.localidade} - ${data.uf}`;
            } else {
              alert('CEP não encontrado.');
              document.getElementById('endereco').value = '';
            }
          })
          .catch(() => {
            alert('Erro ao buscar o CEP.');
          });
      } else {
        alert('Por favor, insira um CEP válido de 8 dígitos.');
      }
    });
  </script>
</body>

</html>
