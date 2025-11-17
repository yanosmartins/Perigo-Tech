<?php
session_start();
include_once('config.php');

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}

// Perguntas de 2FA
$perguntas = [
    'cpf' => 'Qual seu CPF?',
    'endereco' => 'Qual seu endereço?',
    'nome_mae' => 'Qual o nome da sua mãe?'
];

// Escolhe pergunta aleatória E INICIA O CONTADOR
if (!isset($_SESSION['2fa_pergunta'])) {
    $_SESSION['2fa_pergunta'] = array_rand($perguntas);
    $_SESSION['2fa_tentativas'] = 0; // Inicia o contador de falhas
}
$campo = $_SESSION['2fa_pergunta'];

// Busca dados do usuário
$id = $_SESSION['id'];
$stmt = $conexao->prepare("SELECT cpf, endereco, nome_mae FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$dados = $result->fetch_assoc();

// Ajuste do horário de São Paulo
date_default_timezone_set('America/Sao_Paulo');
$data_login = date('Y-m-d H:i:s');

// Verifica a resposta enviada
$resposta = isset($_POST[$campo]) ? trim($_POST[$campo]) : '';
$ok = ($resposta === $dados[$campo]);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($ok) {
        $_SESSION['2fa_autenticado'] = true;

        // Registra log apenas uma vez
        if (!isset($_SESSION['log_registrado']) || $_SESSION['log_registrado'] === false) {
            $stmt_log = $conexao->prepare("INSERT INTO auth_logs (usuario_id, usuario_nome, usuario_cpf, segundo_fator, data_login) VALUES (?, ?, ?, ?, ?)");
            $stmt_log->bind_param("issss", $_SESSION['id'], $_SESSION['nome'], $_SESSION['cpf'], $perguntas[$campo], $data_login);
            $stmt_log->execute();
            $_SESSION['log_registrado'] = true;
        }

        // Limpa a sessão 2FA
        unset($_SESSION['2fa_pergunta']);
        unset($_SESSION['2fa_tentativas']);

        if (isset($_SESSION['tipo']) && $_SESSION['tipo'] === 'master') {
            header('Location: sistema.php');
        } else {
            header('Location: loja.php');
        }
        exit();
    } else {
        $_SESSION['2fa_tentativas']++;

        if ($_SESSION['2fa_tentativas'] >= 3) {

            unset($_SESSION['id']);
            unset($_SESSION['nome']);
            unset($_SESSION['login']);
            unset($_SESSION['cpf']);
            unset($_SESSION['tipo']);
            unset($_SESSION['log_registrado']);
            unset($_SESSION['2fa_pergunta']);
            unset($_SESSION['2fa_tentativas']);

            header('Location: login.php?erro=3');
            exit();
        } else {
            $tentativas_restantes = 3 - $_SESSION['2fa_tentativas'];
            $erro = "Resposta incorreta. Você tem mais $tentativas_restantes tentativa(s).";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Autenticação de 2 Fatores</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url(img/Gemini_Generated_Image_km51uskm51uskm51.png);
            background-size: cover;
            background-position: center;
        }

        .container {
            max-width: 400px;
            margin: 60px auto;
            background: #fff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 10px #ccc;
        }

        h2 {
            text-align: center;
            color: #ff7300;
        }

        label {
            font-weight: bold;
            margin-top: 1rem;
            display: block;
        }

        input[type="text"] {
            width: 100%;
            padding: 0.5rem;
            margin-top: 0.3rem;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button {
            background: #ff7300;
            color: #fff;
            border: none;
            padding: 0.7rem 1.5rem;
            border-radius: 5px;
            margin-top: 1.5rem;
            cursor: pointer;
            font-weight: bold;
        }

        .erro {
            color: red;
            text-align: center;
            margin-bottom: 1rem;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Autenticação de 2 Fatores</h2>
        <?php if (isset($erro)): ?>
            <div class="erro"><?= htmlspecialchars($erro) ?></div>
        <?php endif; ?>
        <form method="POST">
            <label for="<?= $campo ?>"><?= $perguntas[$campo] ?></label>

            <input type="text" name="<?= $campo ?>" id="<?= $campo ?>" required
                <?php if ($campo === 'cpf'): ?>
                maxlength="14"
                <?php endif; ?>>
            <button type="submit">Confirmar</button>
        </form>
    </div>

    <script>
        function mascaraCPF(valor) {
            return valor
                .replace(/\D/g, '')
                .replace(/(\d{3})(\d)/, '$1.$2')
                .replace(/(\d{3})(\d)/, '$1.$2')
                .replace(/(\d{3})(\d{1,2})$/, '$1-$2');
        }

        const campoAtual = '<?php echo $campo; ?>';

        if (campoAtual === 'cpf') {
            const inputCPF = document.getElementById('cpf');

            if (inputCPF) {
                inputCPF.addEventListener('input', function(e) {
                    e.target.value = mascaraCPF(e.target.value);
                });
            }
        }
    </script>
</body>

</html>
