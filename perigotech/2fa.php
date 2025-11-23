<?php
session_start();
include_once('config.php');

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}


$perguntas = [
    'cpf' => 'Qual seu CPF?',
    'endereco' => 'Qual seu endereço?',
    'nome_mae' => 'Qual o nome da sua mãe?'
];

if (!isset($_SESSION['2fa_pergunta'])) {
    $_SESSION['2fa_pergunta'] = array_rand($perguntas);
    $_SESSION['2fa_tentativas'] = 0; 
}
$campo = $_SESSION['2fa_pergunta'];

$id = $_SESSION['id'];
$stmt = $conexao->prepare("SELECT cpf, endereco, nome_mae FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$dados = $result->fetch_assoc();

$resposta = isset($_POST[$campo]) ? trim($_POST[$campo]) : '';

$ok = ($resposta === $dados[$campo]);

date_default_timezone_set('America/Sao_Paulo');
$data_login = date('Y-m-d H:i:s');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($ok) {

        $_SESSION['2fa_autenticado'] = true;

        if (!isset($_SESSION['log_registrado']) || $_SESSION['log_registrado'] === false) {
            $stmt_log = $conexao->prepare("INSERT INTO auth_logs (usuario_id, usuario_nome, usuario_cpf, segundo_fator, data_login) VALUES (?, ?, ?, ?, ?)");
            $stmt_log->bind_param("issss", $_SESSION['id'], $_SESSION['nome'], $_SESSION['cpf'], $perguntas[$campo], $data_login);
            $stmt_log->execute();
            $_SESSION['log_registrado'] = true;
        }

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

            $msg = "3 tentativas sem sucesso! Favor realizar Login novamente.";
            header('Location: erro.php?msg=' . urlencode($msg));
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
        :root {
            --primary-color: #ff7300;
            --bg-card: #fff;
            --text-color: #000;
            --input-bg: #fff;
            --input-border: #ccc;
            --shadow-color: #ccc;
        }

        body.dark-mode {
            --bg-card: #1c1c1c;
            --text-color: #fff;
            --input-bg: #333;
            --input-border: #555;
            --shadow-color: #000;
        }

        body {
            font-family: Arial, sans-serif;
            background-image: url(img/Gemini_Generated_Image_km51uskm51uskm51.png);
            background-size: cover;
            background-position: center;
            font-size: 100%; 
        }

        .container {
            max-width: 400px;
            margin: 60px auto;
            background: var(--bg-card);
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 10px var(--shadow-color);
            color: var(--text-color);
        }

        h2 {
            text-align: center;
            color: var(--primary-color);
        }

        label {
            font-weight: bold;
            margin-top: 1rem;
            display: block;
            color: var(--text-color);
        }

        input[type="text"] {
            width: 100%;
            padding: 0.5rem;
            margin-top: 0.3rem;
            border-radius: 5px;
            border: 1px solid var(--input-border);
            background-color: var(--input-bg);
            color: var(--text-color);
            box-sizing: border-box;
        }

        button {
            background: var(--primary-color);
            color: #fff;
            border: none;
            padding: 0.7rem 1.5rem;
            border-radius: 5px;
            margin-top: 1.5rem;
            cursor: pointer;
            font-weight: bold;
            width: 100%;
        }

        .erro {
            color: red;
            text-align: center;
            margin-bottom: 1rem;
        }

        .accessibility-menu {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: rgba(0, 0, 0, 0.8);
            padding: 10px;
            border-radius: 8px;
            border: 1px solid var(--primary-color);
            z-index: 2000;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .accessibility-btn {
            background: transparent;
            border: 1px solid #fff;
            color: #fff;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.8rem;
            font-weight: bold;
            width: auto;
            margin-top: 0;
        }

        .accessibility-btn:hover {
            background: var(--primary-color);
            border-color: var(--primary-color);
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
                <?php if ($campo === 'cpf'): ?> maxlength="14" <?php endif; ?>
            >
            
            <button type="submit">Confirmar</button>
        </form>
    </div>

    <div class="accessibility-menu">
        <button id="toggle-theme" class="accessibility-btn">🌓 Tema</button>
        <button id="increase-font" class="accessibility-btn">A+</button>
        <button id="decrease-font" class="accessibility-btn">A-</button>
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

        // ACESSIBILIDADE
        document.addEventListener('DOMContentLoaded', () => {
            const body = document.body;
            const btnToggle = document.getElementById('toggle-theme');
            const btnInc = document.getElementById('increase-font');
            const btnDec = document.getElementById('decrease-font');

            btnToggle.addEventListener('click', () => {
                body.classList.toggle('dark-mode');
                const isDark = body.classList.contains('dark-mode');
                localStorage.setItem('theme_2fa', isDark ? 'dark' : 'light');
            });

            if (localStorage.getItem('theme_2fa') === 'dark') {
                body.classList.add('dark-mode');
            } else if (localStorage.getItem('theme') === 'dark') {
                body.classList.add('dark-mode');
            }

            let currentFont = 100;
            btnInc.addEventListener('click', () => {
                if (currentFont < 150) {
                    currentFont += 10;
                    document.documentElement.style.fontSize = currentFont + '%';
                }
            });
            btnDec.addEventListener('click', () => {
                if (currentFont > 70) {
                    currentFont -= 10;
                    document.documentElement.style.fontSize = currentFont + '%';
                }
            });
        });
    </script>
</body>
</html>
