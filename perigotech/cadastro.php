<?php
session_start();
include_once('config.php');

function validaCPF($cpf)
{
    $cpf = preg_replace('/[^0-9]/is', '', $cpf);

    if (strlen($cpf) != 11) return false;
    if (preg_match('/(\d)\1{10}/', $cpf)) return false;

    for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) {
            return false;
        }
    }
    return true;
}

$mensagem_erro = '';
if (isset($_SESSION['msg'])) {
    $mensagem_erro = $_SESSION['msg'];
    unset($_SESSION['msg']);
}

if (isset($_POST['submit'])) {

    $nome          = $_POST['nome'] ?? '';
    $email         = $_POST['email'] ?? '';
    $telefone      = $_POST['telefone'] ?? '';
    $telFixo       = $_POST['telFixo'] ?? '';
    $endereco      = $_POST['endereco'] ?? '';
    $data_nasc     = $_POST['datanascimento'] ?? '';
    $sexo          = $_POST['sexo'] ?? '';
    $cep           = $_POST['cep'] ?? '';
    $cpf           = $_POST['cpf'] ?? '';
    $login         = $_POST['login'] ?? '';
    $senha_plana   = $_POST['senha'] ?? '';
    $confirmaSenha = $_POST['confirmaSenha'] ?? '';
    $nome_mae      = $_POST['nome_mae'] ?? '';

    $erros = [];

    if (empty($nome) || empty($login) || empty($senha_plana) || empty($email) || empty($endereco) || empty($telefone) || empty($data_nasc) || empty($sexo) || empty($cep) || empty($cpf) || empty($nome_mae)) {
        $erros[] = "Preencha todos os campos obrigatórios.";
    }

    if (strlen($nome) < 15 || strlen($nome) > 80) {
        $erros[] = "Nome: Deve ter entre 15 e 80 caracteres.";
    }
    if (!preg_match("/^[a-zA-ZÀ-ÿ\s]+$/", $nome)) {
        $erros[] = "Nome: Deve conter apenas letras e espaços.";
    }

    if (!validaCPF($cpf)) {
        $erros[] = "CPF inválido (Dígito verificador incorreto).";
    }

    if (!preg_match("/^\+55 \(\d{2}\) \d{5}-\d{4}$/", $telefone)) {
        $erros[] = "Telefone Celular: Formato incorreto. Esperado: +55 (XX) XXXXX-XXXX.";
    }

    if (!empty($telFixo) && !preg_match("/^\+55 \(\d{2}\) \d{4}-\d{4}$/", $telFixo)) {
        $erros[] = "Telefone Fixo: Formato incorreto. Esperado: +55 (XX) XXXX-XXXX.";
    }

    if (strlen($login) !== 6) {
        $erros[] = "Login: Deve ter exatamente 6 caracteres.";
    }
    if (!ctype_alpha($login)) {
        $erros[] = "Login: Deve conter apenas letras (sem números).";
    }

    if (strlen($senha_plana) !== 8) {
        $erros[] = "Senha: Deve ter exatamente 8 caracteres.";
    }
    if (!ctype_alpha($senha_plana)) {
        $erros[] = "Senha: Deve conter apenas letras.";
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

        $telefone_limpo = preg_replace('/[^0-9]/', '', $telefone);
        $telFixo_limpo = preg_replace('/[^0-9]/', '', $telFixo);

        $sql = "INSERT INTO usuarios 
                (nome, email, telefone, endereco, data_nascimento, sexo, cep, cpf, login, senha, nome_mae, tipo)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'comum')";

        $stmt = $conexao->prepare($sql);

        if ($stmt === false) {
            $_SESSION['msg'] = "Erro interno no banco: " . $conexao->error;
            header("Location: cadastro.php");
            exit;
        }

        $stmt->bind_param(
            "sssssssssss",
            $nome,
            $email,
            $telefone_limpo,
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
                $_SESSION['msg'] = "Erro: Login, CPF ou Email já cadastrado.";
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
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700;900&display=swap');

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

        #mensagem {
            display: none;
            padding: 14px 18px;
            margin-top: 12px;
            font-size: 15px;
            font-weight: 600;
            border-radius: 6px;
        }

        @keyframes sumirSozinho {
            0% {
                opacity: 0;
                transform: translateY(-6px);
            }

            10% {
                opacity: 1;
                transform: translateY(0);
            }

            90% {
                opacity: 1;
                transform: translateY(0);
            }

            100% {
                opacity: 0;
                transform: translateY(-6px);
                pointer-events: none;
            }
        }

        .com-timer {
            animation: sumirSozinho 10s forwards;
        }

        .alert-erro {
            background: #ff4d4d;
            color: #fff;
            border-left: 6px solid #8b0000;
        }

        .alert-sucesso {
            background: #00c851;
            color: #fff;
            border-left: 6px solid #02571b;
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
            <img src="img/Gemini_Generated_Image_km51uskm51uskm51.png" alt="Imagem login" />
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
                        <strong>Atenção:</strong><br>
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
                        <input id="cep" name="cep" type="text" placeholder="Digite seu CEP" required maxlength="9" />
                    </div>

                    <div class="input-box">
                        <label for="telefone">Telefone Celular</label>
                        <input id="telefone" name="telefone" type="tel" placeholder="+55 (99) 99999-9999" required value="+55 (" />
                    </div>

                    <div class="input-box">
                        <label for="endereco">Endereço Completo</label>
                        <input id="endereco" name="endereco" type="text" placeholder="Digite seu endereço" required />
                    </div>

                    <div class="input-box">
                        <label for="telFixo">Telefone Fixo</label>
                        <input id="telFixo" name="telFixo" type="tel" placeholder="+55 (99) 9999-9999" value="+55 (" />
                    </div>

                    <div class="Sexo">
                        <label>Sexo</label><br />
                        <input type="radio" id="sexoM" name="sexo" value="Masculino" required /> Masculino
                        <input type="radio" id="sexoF" name="sexo" value="Feminino" /> Feminino
                    </div>

                    <div class="input-box">
                        <label for="datanascimento">Data de Nascimento</label>
                        <input id="datanascimento" name="datanascimento" type="date" required max="<?php echo date('Y-m-d'); ?>" />
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

        function mostrarMensagem(texto, tipo) {
            mensagem.textContent = texto;
            mensagem.className = '';
            void mensagem.offsetWidth;
            mensagem.classList.add(tipo, 'com-timer');
            mensagem.style.display = 'block';
        }

        // MÁSCARAS 

        function aplicarMascaraCPF(valor) {
            return valor.replace(/\D/g, '').replace(/(\d{3})(\d)/, '$1.$2').replace(/(\d{3})(\d)/, '$1.$2').replace(/(\d{3})(\d{1,2})$/, '$1-$2');
        }

        function aplicarMascaraCelular(valor) {
            let digitos = valor.replace(/\D/g, '').replace(/^55/, '');
            if (digitos.length > 11) digitos = digitos.slice(0, 11);

            let formatado = digitos;
            if (digitos.length > 1) formatado = formatado.replace(/^(\d{2})(\d)/g, '($1) $2');
            if (formatado.length > 9) formatado = formatado.replace(/(\d{5})(\d)/, '$1-$2');

            return "+55 " + formatado;
        }

        function aplicarMascaraFixo(valor) {

            let digitos = valor.replace(/\D/g, '').replace(/^55/, '');
            if (digitos.length > 10) digitos = digitos.slice(0, 10);

            let formatado = digitos;
            if (digitos.length > 1) formatado = formatado.replace(/^(\d{2})(\d)/g, '($1) $2');
            if (formatado.length > 8) formatado = formatado.replace(/(\d{4})(\d)/, '$1-$2');
            return "+55 " + formatado;
        }

        function aplicarMascaraCEP(valor) {
            return valor.replace(/\D/g, '').replace(/(\d{5})(\d)/, '$1-$2');
        }

        document.getElementById('cpf').addEventListener('input', e => {
            e.target.value = aplicarMascaraCPF(e.target.value);
        });

        document.addEventListener('DOMContentLoaded', function() {
            const telefoneInput = document.getElementById('telefone');
            const telFixoInput = document.getElementById('telFixo');

            if (telefoneInput) {
                telefoneInput.value = aplicarMascaraCelular(telefoneInput.value);
            }

            if (telFixoInput) {
                telFixoInput.value = aplicarMascaraFixo(telFixoInput.value);
            }
        });

        document.getElementById('telefone').addEventListener('input', e => {
            e.target.value = aplicarMascaraCelular(e.target.value);
        });
        document.getElementById('telFixo').addEventListener('input', e => {
            e.target.value = aplicarMascaraFixo(e.target.value);
        });
        document.getElementById('cep').addEventListener('input', e => {
            e.target.value = aplicarMascaraCEP(e.target.value);
        });

        // Consulta CEP 
        document.getElementById('cep').addEventListener('blur', function() {
            const cep = this.value.replace(/\D/g, '');
            if (cep.length !== 8) {
                mostrarMensagem("⚠ Por favor, insira um CEP válido com 8 dígitos.", "alert-erro");
                return;
            }
            fetch(`https://viacep.com.br/ws/${cep}/xml/`)
                .then(response => response.text())
                .then(xmlString => {
                    const xml = new DOMParser().parseFromString(xmlString, "application/xml");
                    if (xml.getElementsByTagName("erro")[0]) {
                        mostrarMensagem("⚠ CEP não encontrado.", "alert-erro");
                        document.getElementById('endereco').value = '';
                        return;
                    }
                    const logradouro = xml.querySelector("logradouro")?.textContent || "";
                    const bairro = xml.querySelector("bairro")?.textContent || "";
                    const localidade = xml.querySelector("localidade")?.textContent || "";
                    const uf = xml.querySelector("uf")?.textContent || "";
                    document.getElementById('endereco').value = `${logradouro}, ${bairro}, ${localidade} - ${uf}`;
                    mostrarMensagem("✔ Endereço encontrado com sucesso!", "alert-sucesso");
                })
                .catch(() => {
                    mostrarMensagem("⚠ Erro ao consultar o CEP. Tente novamente.", "alert-erro");
                    document.getElementById('endereco').value = '';
                });
        });
    </script>
</body>

</html>
