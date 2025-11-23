<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}

$nome_usuario = htmlspecialchars($_SESSION['login']);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modelo do Banco de Dados - Perigo Tech</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700;900&display=swap');

        * { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --primary-color: #ad6224ff;
            --card-bg: #ff7300ff;
            --text-color: #000000;
            --text-muted: #111111;
            --body-bg: black;
            --body-text: white;
            --container-bg: #1c1c1c;
        }

        body.light-mode {
            --body-bg: #ffffff;
            --body-text: #000000;
            --card-bg: #e0e0e0;
            --text-color: #000000;
            --text-muted: #333333;
            --container-bg: #f4f4f4;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: var(--body-bg);
            color: var(--body-text);
            line-height: 1.6;
            transition: background-color 0.3s, color 0.3s;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .container { max-width: 1330px; margin: 0 auto; padding: 0 20px; }

        .main-header {
            background-color: var(--card-bg);
            padding: 1rem 0;
            border-bottom: 1px solid #333;
        }

        .main-header .container {
            display: flex; justify-content: space-between; align-items: center;
        }

        .logo {
            font-size: 1.8rem; font-weight: 900; color: var(--text-color); text-decoration: none;
        }
        .logo span { color: var(--primary-color); }

        .btn-voltar {
            text-decoration: none; color: var(--text-color); font-weight: bold; font-size: 1.1rem;
        }
        .btn-voltar:hover { color: #994907ff; }

        main { 
            flex-grow: 1; padding: 2rem 0; text-align: center;
        }

        .model-wrapper {
            background: var(--container-bg);
            padding: 20px;
            border-radius: 10px;
            border: 2px solid var(--primary-color);
            display: inline-block; 
            max-width: 100%;
            margin: 100px;
        }

        .model-wrapper h1 {
            color: var(--primary-color);
            margin-bottom: 20px;
        }

        .model-wrapper img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
            box-shadow: 0 0 15px rgba(0,0,0,0.5);
        }

        .accessibility-menu {
            position: fixed; bottom: 20px; right: 20px;
            background: rgba(0, 0, 0, 0.8); padding: 10px;
            border-radius: 8px; border: 1px solid var(--primary-color);
            z-index: 2000; display: flex; flex-direction: column; gap: 5px;
        }
        .accessibility-btn {
            background: transparent; border: 1px solid #fff; color: #fff;
            padding: 5px 10px; border-radius: 4px; cursor: pointer; font-weight: bold;
        }
        .accessibility-btn:hover { background: var(--primary-color); border-color: var(--primary-color); }

        .main-footer {
            background-color: var(--card-bg); padding: 1rem 0; text-align: center; margin-top: auto; color: var(--text-color);
        }
    </style>
</head>

<body>

    <header class="main-header">
        <div class="container">
            <a href="loja.php" class="logo">Perigo <span>Tech</span></a>
            <a href="loja.php" class="btn-voltar"><i class="fas fa-arrow-left"></i> Voltar para a Loja</a>
        </div>
    </header>

    <main class="container">
        <div class="model-wrapper">
            <h1>Modelo de Entidade-Relacionamento (DER)</h1>
            <img src="img/der_banco.png" alt="Diagrama do Banco de Dados Perigo Tech">
            <p style="margin-top: 10px; color: var(--body-text);">Estrutura do banco de dados utilizada no sistema.</p>
        </div>
    </main>

    <footer class="main-footer">
        <div class="container">
            &copy; 2025 Perigo Tech. Todos os direitos reservados.
        </div>
    </footer>

    <div class="accessibility-menu">
        <button id="toggle-theme" class="accessibility-btn">🌓 Tema</button>
        <button id="increase-font" class="accessibility-btn">A+</button>
        <button id="decrease-font" class="accessibility-btn">A-</button>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const body = document.body;
            const btnToggle = document.getElementById('toggle-theme');
            const btnInc = document.getElementById('increase-font');
            const btnDec = document.getElementById('decrease-font');

            // Tema
            btnToggle.addEventListener('click', () => {
                body.classList.toggle('light-mode');
                const isLight = body.classList.contains('light-mode');
                localStorage.setItem('theme', isLight ? 'light' : 'dark');
            });
            if (localStorage.getItem('theme') === 'light') body.classList.add('light-mode');

            // Fonte
            let currentFont = 100;
            btnInc.addEventListener('click', () => {
                if (currentFont < 150) { currentFont += 10; document.documentElement.style.fontSize = currentFont + '%'; }
            });
            btnDec.addEventListener('click', () => {
                if (currentFont > 70) { currentFont -= 10; document.documentElement.style.fontSize = currentFont + '%'; }
            });
        });
    </script>
</body>
</html>
