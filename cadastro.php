<?php
    if(isset($_POST['submit']))
    {

    include_once('config.php');
      $nome = $_POST['nome'];
      $email = $_POST['email'];
      $telefone = $_POST['telefone'];
      $endereco = $_POST['endereco'];
      $data_nasc = $_POST['datanascimento'];
      $sexo = $_POST['sexo'];
      $cep = $_POST['cep']; 
      $cpf = $_POST['cpf'];


    $result = mysqli_query($conexao, "INSERT INTO cadastro_tech(nome,email,telefone,endereco,data_nasc,sexo,cep,cpf) VALUES ('$nome','$email','$telefone','$endereco','$data_nasc','$sexo','$cep','$cpf')");

    }


?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>  
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1.0" />
  <title>Cadastro</title>
   <link rel="stylesheet" href="style.css" />
</head>
<body>
  <div class="container">
    <div class="form-image">
      <img src="ChatGPT Image 12_09_2025, 18_41_39.png" alt="imagem cadastro" />
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
            <input id="cep" name="cep" type="text" placeholder="Digite seu CEP" required />
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
            <input id="datanascimento" name="datanascimento" type="date" required />
          </div>

          <div class="input-box">
            <label for="cpf">CPF</label>
            <input id="cpf" name="cpf" type="text" placeholder="000.000.000-00" required />
          </div>

          <div class="input-box">
            <label for="nomeMaterno">Nome Materno</label>
            <input id="nomeMaterno" name="nomeMaterno" type="text" placeholder="Nome Materno" required />
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

    mensagem.textContent = 'Cadastro realizado com sucesso!';
    mensagem.style.color = 'green';

    setTimeout(() => {
      window.location.href = 'login.html';
    }, 2000);
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

