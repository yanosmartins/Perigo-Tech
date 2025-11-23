<?php
$host = "perigo-tech.cxk4sugqggtc.us-east-2.rds.amazonaws.com";
$user = "admin";
$password = "P1rucomLeucem1a";
$dbname = "perigotech";
$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome_usuario = htmlspecialchars($_SESSION['nome'] ?? 'cliente');
    unset($_SESSION['carrinho']);
    $total_itens_carrinho = 0;

?>
    <!DOCTYPE html>
    <html lang="pt-BR">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Pedido Confirmado! - Perigo Tech</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700;900&display=swap');

            :root {
                --primary-color: #ad6224ff;
                --card-bg: #ff7300ff;
                --text-color: #000000;
                --text-muted: #111111;
                --body-bg: black;
                --body-text: white;
                --container-bg: #1c1c1c;
                --icon-color: #ccc;
            }

            body.light-mode {
                --body-bg: #f0f0f0;
                --body-text: #000;
                --container-bg: #fff;
                --card-bg: #e0e0e0;
                --text-color: #000;
                --text-muted: #333;
                --icon-color: #333;
            }

            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: 'Roboto', sans-serif;
                background-color: var(--body-bg);
                color: var(--body-text);
                line-height: 1.6;
                display: flex;
                flex-direction: column;
                min-height: 100vh;
                transition: background-color 0.3s, color 0.3s;
            }

            main {
                flex-grow: 1;
                display: flex;
                align-items: center;
                justify-content: center;
                text-align: center;
                padding: 2rem 0;
            }

            .container {
                max-width: 1310px;
                margin: 0 auto;
                padding: 0 20px;
            }

            .main-header {
                background-color: var(--card-bg);
                padding: 1rem 0;
                border-bottom: 1px solid #333;
                position: sticky;
                top: 0;
                z-index: 1000;
            }

            .main-header .container {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .logo {
                font-size: 1.8rem;
                font-weight: 900;
                color: var(--text-color);
                text-decoration: none;
            }

            .logo span {
                color: var(--primary-color);
            }

            .main-nav {
                display: none;
            }

            .main-nav a {
                color: var(--text-muted);
                text-decoration: none;
                margin: 0 13px;
                font-weight: 700;
            }

            .main-nav a:hover {
                color: #994907ff;
            }

            .header-icons {
                display: flex;
                align-items: center;
                gap: 15px;
            }

            .header-icons a {
                color: var(--text-color);
                text-decoration: none;
                font-size: 1.2rem;
                margin-left: 20px;
                position: relative;
                transition: color 0.3s ease;
            }

            .header-icons a span {
                position: absolute;
                top: -8px;
                right: -10px;
                background-color: #ff7300;
                color: white;
                font-size: 0.7rem;
                border-radius: 50%;
                padding: 2px 5px;
            }

            .header-icons a:hover {
                color: #994907ff;
            }

            @media (min-width: 768px) {
                .main-nav {
                    display: flex;
                }
            }

            .sucesso-wrapper {
                background: var(--container-bg);
                padding: 3rem;
                border-radius: 10px;
                border: 2px solid var(--primary-color);
                max-width: 600px;
                width: 100%;
                margin: 100px;
            }

            .sucesso-wrapper .icon {
                font-size: 5rem;
                color: var(--primary-color);
                margin-bottom: 1.5rem;
            }

            .sucesso-wrapper h1 {
                font-size: 2.5rem;
                margin-bottom: 1rem;
                color: var(--body-text);
            }

            .sucesso-wrapper p {
                font-size: 1.2rem;
                color: var(--icon-color);
                margin-bottom: 2.5rem;
            }

            .btn-primary {
                background-color: var(--primary-color);
                color: white;
                padding: 12px 25px;
                margin: 5px;
                text-decoration: none;
                border-radius: 5px;
                font-weight: 700;
                transition: background-color 0.3s ease;
                border: none;
                cursor: pointer;
                font-size: 1.1rem;
            }

            .btn-primary:hover {
                background-color: #994907ff;
            }

            .main-footer {
                background-color: var(--card-bg);
                padding: 3rem 0 1rem;
                border-top: 1px solid #333;
            }

            .footer-content {
                display: grid;
                grid-template-columns: 1fr;
                gap: 2rem;
                text-align: center;
                margin-bottom: 2rem;
            }

            .footer-section h4 {
                font-size: 1.2rem;
                margin-bottom: 1rem;
                color: var(--primary-color);
            }

            .footer-section {
                color: var(--text-color);
            }

            .footer-section ul {
                list-style: none;
                padding: 0;
            }

            .footer-section ul li a {
                color: var(--text-muted);
                text-decoration: none;
            }

            .social-icons a {
                color: var(--text-color);
                font-size: 1.5rem;
                margin: 0 10px;
            }

            .footer-bottom {
                text-align: center;
                padding-top: 1rem;
                border-top: 1px solid #333;
                color: var(--text-muted);
            }

            @media (min-width: 768px) {
                .footer-content {
                    grid-template-columns: repeat(3, 1fr);
                    text-align: left;
                }
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
            }

            .accessibility-btn:hover {
                background: var(--primary-color);
                border-color: var(--primary-color);
            }
        </style>
    </head>

    <body>
        <header class="main-header">
            <div class="container">
                <a href="loja.php" class="logo">Perigo <span>Tech</span></a>
                <nav class="main-nav">
                    <a href="loja.php">Início</a>
                </nav>
                <div class="header-icons">
                    <a href="carrinho.php" aria-label="Carrinho"><i class="fas fa-shopping-cart"></i>
                        <span><?php echo $total_itens_carrinho; ?></span></a>
                    <a href="#" aria-label="Login"><i class="fas fa-user"></i></a>
                    <?php if (isset($_SESSION['nome'])): ?>
                        <span style="font-size: 1rem; font-weight: 700; color: var(--text-color); white-space: nowrap; margin-left: 15px;">
                            Olá, <?php echo $nome_usuario; ?>!
                        </span>
                        <a href="logout.php" aria-label="Sair" title="Sair"><i class="fas fa-sign-out-alt"></i></a>
                    <?php endif; ?>
                </div>
            </div>
        </header>

        <main class="container">
            <div class="sucesso-wrapper">
                <div class="icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h1>Pedido Confirmado!</h1>
                <p>Obrigado pela sua compra, <?php echo $nome_usuario; ?>!</p>
                <a href="loja.php" class="btn-primary">Continuar Comprando</a>
                <a href="loja.php" class="btn-primary">Ver Status</a>
            </div>
        </main>

        <footer class="main-footer">
            <div class="container">
                <div class="footer-content">
                    <div class="footer-section">
                        <h4>Perigo Tech</h4>
                        <p>A sua paixão por hardware começa aqui.</p>
                    </div>
                    <div class="footer-section">
                        <h4>Links Rápidos</h4>
                        <ul>
                            <li><a href="#">Contato</a></li>
                            <li><a href="#">Política de Privacidade</a></li>
                            <li><a href="#">Termos de Serviço</a></li>
                        </ul>
                    </div>
                    <div class="footer-section">
                        <h4>Siga-nos</h4>
                        <div class="social-icons">
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
                <div class="footer-bottom">&copy; 2025 Perigo Tech. Todos os direitos reservados.</div>
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

                btnToggle.addEventListener('click', () => {
                    body.classList.toggle('light-mode');
                    const isLight = body.classList.contains('light-mode');
                    localStorage.setItem('theme_checkout', isLight ? 'light' : 'dark');
                });

                if (localStorage.getItem('theme_checkout') === 'light') {
                    body.classList.add('light-mode');
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

<?php
    exit();
} else {

    if (!isset($_SESSION['nome'])) {
        header('Location: login.php');
        exit();
    }

    if (empty($_SESSION['carrinho'])) {
        header('Location: loja.php');
        exit();
    }

    $total_geral = 0;
    $ids_produtos = implode(',', array_keys($_SESSION['carrinho']));
    $sql_carrinho = "SELECT * FROM produtos WHERE id_prod IN ($ids_produtos)";
    $result_carrinho = $conn->query($sql_carrinho);
    if ($result_carrinho->num_rows > 0) {
        while ($produto = $result_carrinho->fetch_assoc()) {
            $id = $produto['id_prod'];
            $quantidade = $_SESSION['carrinho'][$id];
            $total_geral += $produto['preco'] * $quantidade;
        }
    }

    $total_itens_carrinho = array_sum($_SESSION['carrinho']);

?>
    <!DOCTYPE html>
    <html lang="pt-BR">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Finalizar Compra - Perigo Tech</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700;900&display=swap');

            :root {
                --primary-color: #ad6224ff;
                --card-bg: #ff7300ff;
                --text-color: #000000;
                --text-muted: #111111;
                --body-bg: black;
                --body-text: white;
                --container-bg: #1c1c1c;
                --input-bg: #333;
                --input-text: white;
                --border-color: #555;
                --label-color: #ccc;
            }

            body.light-mode {
                --body-bg: #f0f0f0;
                --body-text: #000;
                --container-bg: #fff;
                --card-bg: #e0e0e0;
                --text-color: #000;
                --text-muted: #333;
                --input-bg: #fff;
                --input-text: #000;
                --border-color: #ccc;
                --label-color: #333;
            }

            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: 'Roboto', sans-serif;
                background-color: var(--body-bg);
                color: var(--body-text);
                line-height: 1.6;
                display: flex;
                flex-direction: column;
                min-height: 100vh;
                transition: background-color 0.3s, color 0.3s;
            }

            main {
                flex-grow: 1;
            }

            .container {
                max-width: 1200px;
                margin: 0 auto;
                padding: 0 20px;
            }

            .main-header {
                background-color: var(--card-bg);
                padding: 1rem 0;
                border-bottom: 1px solid #333;
                position: sticky;
                top: 0;
                z-index: 1000;
            }

            .main-header .container {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .logo {
                font-size: 1.8rem;
                font-weight: 900;
                color: var(--text-color);
                text-decoration: none;
            }

            .logo span {
                color: var(--primary-color);
            }

            .main-nav {
                display: none;
            }

            .main-nav a {
                color: var(--text-muted);
                text-decoration: none;
                margin: 0 13px;
                font-weight: 700;
                transition: color 0.3s ease;
            }

            .main-nav a:hover {
                color: #994907ff;
            }

            .header-icons {
                display: flex;
                align-items: center;
                gap: 15px;
            }

            .header-icons a {
                color: var(--text-color);
                text-decoration: none;
                font-size: 1.2rem;
                margin-left: 20px;
                position: relative;
                transition: color 0.3s ease;
            }

            .header-icons a span {
                position: absolute;
                top: -8px;
                right: -10px;
                background-color: #ff7300;
                color: white;
                font-size: 0.7rem;
                border-radius: 50%;
                padding: 2px 5px;
            }

            .header-icons a:hover {
                color: #994907ff;
            }

            @media (min-width: 768px) {
                .main-nav {
                    display: flex;
                }
            }

            #mensagem {
                display: none;
                padding: 14px 18px;
                margin-top: 12px;
                font-size: 15px;
                font-weight: 600;
                border-radius: 6px;
                text-align: left;
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

            .checkout-wrapper {
                display: flex;
                flex-wrap: wrap;
                gap: 2rem;
                padding: 3rem 0;
            }

            .form-section,
            .summary-section {
                background: var(--container-bg);
                padding: 2rem;
                border-radius: 10px;
            }

            .form-section {
                flex: 2;
                min-width: 300px;
            }

            .summary-section {
                flex: 1;
                min-width: 300px;
            }

            h1,
            h2 {
                color: var(--primary-color);
                margin-bottom: 1.5rem;
            }

            main h1 {
                margin-top: 70px;
            }

            .form-grupo {
                margin-bottom: 1.5rem;
            }

            .form-grupo label {
                display: block;
                margin-bottom: 0.5rem;
                color: var(--label-color);
            }

            .form-grupo input {
                width: 100%;
                padding: 0.8rem;
                background: var(--input-bg);
                border: 1px solid var(--border-color);
                border-radius: 5px;
                color: var(--input-text);
                font-size: 1rem;
                transition: border-color 0.3s ease;
            }

            .form-grupo input:not(:placeholder-shown):invalid {
                border-color: #ff4d4d;
            }

            .resumo-item {
                display: flex;
                justify-content: space-between;
                align-items: center;
                border-bottom: 1px solid #333;
                padding: 0.8rem 0;
            }

            .resumo-item span {
                color: var(--label-color);
            }

            .resumo-frete {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 0.8rem 0;
                border-bottom: 1px solid #333;
            }

            .resumo-frete span {
                color: var(--label-color);
            }

            .resumo-frete strong {
                color: #28a745;
                font-weight: 700;
            }

            .resumo-total {
                margin-top: 1.5rem;
                padding-top: 1.5rem;
                border-top: 2px solid var(--primary-color);
                display: flex;
                justify-content: space-between;
                font-size: 1.5rem;
                font-weight: 700;
            }

            .btn-primary {
                background-color: var(--primary-color);
                color: white;
                padding: 12px 25px;
                text-decoration: none;
                border-radius: 5px;
                font-weight: 700;
                transition: background-color 0.3s ease;
                border: none;
                cursor: pointer;
                width: 100%;
                font-size: 1.2rem;
                margin-top: 1.5rem;
                text-align: center;
                display: inline-block;
            }

            .btn-primary:hover {
                background-color: #994907ff;
            }

            .checkout-parcelamento-box {
                margin: 20px 0 0 0;
                padding: 2px;
                border-radius: 10px;
                background: var(--body-bg);
                border: 2px solid #ff7300;
                text-align: center;
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }

            .checkout-parcelamento-box:hover {
                box-shadow: -10px 0 15px rgba(197, 81, 14, 0.5), 10px 0 15px rgba(197, 81, 14, 0.5), 0 10px 15px rgba(197, 81, 14, 0.5);
            }

            .checkout-parcelamento-box>p {
                margin: 2px 0 10px 0;
                font-size: 0.85rem;
                color: var(--body-text);
                font-weight: 500;
            }

            .parcelas-container {
                display: flex;
                flex-direction: column;
                gap: 5px;
            }

            .parcelas-linha-radio {
                display: block;
                position: relative;
            }

            .parcelas-linha-radio input[type="radio"] {
                display: none;
            }

            .parcelas-linha-radio label {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 8px 12px;
                border-radius: 5px;
                cursor: pointer;
                transition: background-color 0.2s ease;
            }

            .parcelas-linha-radio label:hover {
                background-color: var(--border-color);
            }

            .parcelas-linha-radio input[type="radio"]:checked+label {
                background-color: var(--primary-color);
            }

            .parcelas-linha-radio label span,
            .parcelas-linha-radio label strong {
                font-size: 0.9rem;
                color: var(--body-text);
                font-weight: 500;
            }

            .parcelas-linha-radio input[type="radio"]:checked+label span,
            .parcelas-linha-radio input[type="radio"]:checked+label strong {
                color: white;
                font-weight: 700;
            }

            .parcelas-linha-radio label strong {
                font-weight: 700;
            }

            .main-footer {
                background-color: var(--card-bg);
                padding: 3rem 0 1rem;
                border-top: 1px solid #333;
            }

            .footer-content {
                display: grid;
                grid-template-columns: 1fr;
                gap: 2rem;
                text-align: center;
                margin-bottom: 2rem;
            }

            .footer-section h4 {
                font-size: 1.2rem;
                margin-bottom: 1rem;
                color: var(--primary-color);
            }

            .footer-section {
                color: var(--text-color);
            }

            .footer-section ul {
                list-style: none;
                padding: 0;
            }

            .footer-section ul li a {
                color: var(--text-muted);
                text-decoration: none;
            }

            .footer-section a {
                color: var(--text-muted);
                text-decoration: none;
                transition: color 0.3s ease;
            }

            .footer-section a:hover {
                color: #994907ff;
            }

            .social-icons a {
                color: var(--text-color);
                font-size: 1.5rem;
                margin: 0 10px;
            }

            .footer-bottom {
                text-align: center;
                padding-top: 1rem;
                border-top: 1px solid #333;
                color: var(--text-muted);
            }

            @media (min-width: 768px) {
                .footer-content {
                    grid-template-columns: repeat(3, 1fr);
                    text-align: left;
                }
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
            }

            .accessibility-btn:hover {
                background: var(--primary-color);
                border-color: var(--primary-color);
            }
        </style>
    </head>

    <body>
        <header class="main-header">
            <div class="container">
                <a href="loja.php" class="logo">Perigo <span>Tech</span></a>
                <nav class="main-nav">
                    <a href="loja.php">Início</a>
                </nav>
                <div class="header-icons">
                    <a href="carrinho.php" aria-label="Carrinho"><i class="fas fa-shopping-cart"></i>
                        <span><?php echo $total_itens_carrinho; ?></span></a>
                    <a href="#" aria-label="Login"><i class="fas fa-user"></i></a>
                    <?php if (isset($_SESSION['nome'])): ?>
                        <span style="font-size: 1rem; font-weight: 700; color: var(--text-color); white-space: nowrap; margin-left: 15px;">
                            Olá, <?php echo htmlspecialchars($_SESSION['login']); ?>!
                        </span>
                        <a href="logout.php" aria-label="Sair" title="Sair"><i class="fas fa-sign-out-alt"></i></a>
                    <?php endif; ?>
                </div>
            </div>
        </header>

        <main class="container">
            <h1>Finalizar Compra</h1>
            <p id="mensagem" aria-live="polite"></p>
            <form action="checkout.php" method="POST">
                <div class="checkout-wrapper">

                    <section class="form-section">
                        <h2>1. Endereço de Entrega</h2>
                        <div class="form-grupo">
                            <label for="nome_completo">Nome Completo</label>
                            <input type="text" id="nome_completo" name="nome_completo" required placeholder="Seu nome aqui">
                        </div>
                        <div class="form-grupo">
                            <label for="cep">CEP</label>
                            <input type="text" id="cep" name="cep" required placeholder="00000-000" maxlength="9"
                                onkeyup="formatarCEP(this)">
                        </div>
                        <div class="form-grupo">
                            <label for="endereco">Endereço (Rua, Número, Bairro)</label>
                            <input type="text" id="endereco" name="endereco" required
                                placeholder="Av. Principal, 123, Centro">
                        </div>

                        <h2>2. Pagamento</h2>
                        <div class="form-grupo">
                            <label for="cartao">Número do Cartão</label>
                            <input type="text" id="cartao" name="cartao" placeholder="0000 0000 0000 0000" required
                                maxlength="16" onkeyup="formatarCartao(this)">
                        </div>
                        <div class="form-grupo" style="display: flex; gap: 1rem;">
                            <div style="flex: 2;">
                                <label for="validade">Validade</label>
                                <input type="text" id="validade" name="validade" placeholder="MM/AA" required maxlength="5"
                                    onkeyup="formatarData(this)">
                            </div>
                            <div style="flex: 1;">
                                <label for="cvv">CVV</label>
                                <input type="text" id="cvv" name="cvv" placeholder="123" required maxlength="3">
                            </div>
                        </div>
                    </section>

                    <section class="summary-section">
                        <h2>3. Resumo do Pedido</h2>
                        <?php
                        if ($result_carrinho && $result_carrinho->num_rows > 0):
                            $result_carrinho->data_seek(0);
                            while ($produto = $result_carrinho->fetch_assoc()):
                                $id = $produto['id_prod'];
                                $quantidade = $_SESSION['carrinho'][$id];
                        ?>
                                <div class="resumo-item">
                                    <span><?php echo $quantidade; ?>x <?php echo htmlspecialchars($produto['nome']); ?></span>
                                    <strong>R$ <?php echo number_format($produto['preco'] * $quantidade, 2, ',', '.'); ?></strong>
                                </div>
                        <?php
                            endwhile;
                        endif;
                        ?>

                        <div class="resumo-frete">
                            <span>Frete</span>
                            <strong>Grátis</strong>
                        </div>

                        <div class="resumo-total">
                            <span>Total</span>
                            <strong id="display-total-valor">R$
                                <?php echo number_format($total_geral, 2, ',', '.'); ?></strong>
                        </div>

                        <div class="checkout-parcelamento-box">
                            <p>Opções de Pagamento</p>
                            <?php
                            $preco = $total_geral;
                            $maxSemJuros = 6;
                            $maxParcelas = 12;

                            $texto_a_vista = "R$ " . number_format($total_geral, 2, ',', '.');
                            ?>
                            <div class="parcelas-container">

                                <div class="parcelas-linha-radio">
                                    <input type="radio" name="parcela_opcao" id="parcela_1" value="1"
                                        data-texto-total="<?php echo $texto_a_vista; ?>" checked>
                                    <label for="parcela_1">
                                        <span>À Vista</span>
                                        <strong><?php echo $texto_a_vista; ?></strong>
                                    </label>
                                </div>

                                <?php
                                for ($i = 2; $i <= $maxParcelas; $i++) {

                                    $texto_parcela = "";
                                    $texto_juros = "";

                                    if ($i <= $maxSemJuros) {
                                        $valorParcela = $preco / $i;
                                        $texto_parcela = "{$i}x de R$ " . number_format($valorParcela, 2, ',', '.');
                                        $texto_juros = "s/ juros";
                                    } else {
                                        $juros = 3 + (($i - 7) * 0.5);
                                        $valorParcela = ($preco * (1 + $juros / 100)) / $i;
                                        $texto_parcela = "{$i}x de R$ " . number_format($valorParcela, 2, ',', '.');
                                        $texto_juros = "c/ juros (" . number_format($juros, 1, ',', '.') . "%)";
                                    }

                                    echo '<div class="parcelas-linha-radio">';
                                    echo '  <input type="radio" name="parcela_opcao" id="parcela_' . $i . '" value="' . $i . '" 
                                     data-texto-total="' . $texto_parcela . '">';
                                    echo '  <label for="parcela_' . $i . '">';
                                    echo '      <span>' . $texto_parcela . '</span>';
                                    echo '      <strong>' . $texto_juros . '</strong>';
                                    echo '  </label>';
                                    echo '</div>';
                                }
                                ?>
                            </div>
                        </div>

                        <button type="submit" class="btn-primary">Confirmar Compra</button>
                    </section>

                </div>
            </form>
        </main>

        <footer class="main-footer">
            <div class="container">
                <div class="footer-content">
                    <div class="footer-section">
                        <h4>Perigo Tech</h4>
                        <p>A sua paixão por hardware começa aqui.</p>
                    </div>
                    <div class="footer-section">
                        <h4>Links Rápidos</h4>
                        <ul>
                            <li><a href="sobre.php">Sobre Nós</a></li>
                            <li><a href="#">Contato</a></li>
                            <li><a href="#">Política de Privacidade</a></li>
                            <li><a href="#">Termos de Serviço</a></li>
                        </ul>
                    </div>
                    <div class="footer-section">
                        <h4>Siga-nos</h4>
                        <div class="social-icons">
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
                <div class="footer-bottom">&copy; 2025 Perigo Tech. Todos os direitos reservados.</div>
            </div>
        </footer>

        <div class="accessibility-menu">
            <button id="toggle-theme" class="accessibility-btn">🌓 Tema</button>
            <button id="increase-font" class="accessibility-btn">A+</button>
            <button id="decrease-font" class="accessibility-btn">A-</button>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const totalDisplay = document.getElementById('display-total-valor');
                const parcelasInputs = document.querySelectorAll('input[name="parcela_opcao"]');
                const cepInput = document.getElementById('cep');
                const enderecoInput = document.getElementById('endereco');
                const telefoneInput = document.getElementById('telefone');
                const telFixoInput = document.getElementById('telFixo');

                window.mostrarMensagem = function(texto, tipo) {
                    const mensagem = document.getElementById('mensagem');
                    if (!mensagem) return;

                    mensagem.textContent = texto;
                    mensagem.className = '';
                    void mensagem.offsetWidth;
                    mensagem.classList.add(tipo, 'com-timer');
                    mensagem.style.display = 'block';
                };


                parcelasInputs.forEach(input => {
                    input.addEventListener('change', () => {
                        if (input.checked && totalDisplay) {
                            const novoTextoTotal = input.dataset.textoTotal || '';
                            totalDisplay.innerText = novoTextoTotal;
                        }
                    });
                });

                window.formatarData = function(input) {
                    if (!input) return;
                    let v = input.value.replace(/\D/g, '');

                    if (v.length > 2) {
                        v = v.substring(0, 2) + '/' + v.substring(2, 4);
                    }

                    input.value = v;
                };

                window.formatarCartao = function(input) {
                    if (!input) return;
                    let v = input.value.replace(/\D/g, '');

                    v = v.match(/.{1,4}/g)?.join(' ') || v;
                    input.value = v.trim();
                };

                window.formatarCEP = function(input) {
                    if (!input) return;
                    let v = input.value.replace(/\D/g, '');

                    if (v.length > 5) {
                        v = v.substring(0, 5) + '-' + v.substring(5, 8);
                    }

                    input.value = v;
                };


                if (cepInput) {
                    cepInput.addEventListener('blur', () => {
                        const cep = cepInput.value.replace(/\D/g, '');

                        if (cep.length !== 8) {
                            mostrarMensagem('⚠ Por favor, insira um CEP válido com 8 dígitos.', 'alert-erro');
                            return;
                        }

                        fetch(`https://viacep.com.br/ws/${cep}/json/`)
                            .then(response => response.json())
                            .then(data => {
                                if (!data.erro && enderecoInput) {
                                    enderecoInput.value = `${data.logradouro}, ${data.bairro}, ${data.localidade} - ${data.uf}`;
                                    mostrarMensagem('✔ Endereço encontrado com sucesso!', 'alert-sucesso');
                                } else {
                                    mostrarMensagem('⚠ CEP não encontrado.', 'alert-erro');
                                    if (enderecoInput) enderecoInput.value = '';
                                }
                            })
                            .catch(() => {
                                mostrarMensagem('⚠ Erro ao buscar o CEP.', 'alert-erro');
                                if (enderecoInput) enderecoInput.value = '';
                            });
                    });
                }

                // Acessibilidade
                const body = document.body;
                const btnToggle = document.getElementById('toggle-theme');
                const btnInc = document.getElementById('increase-font');
                const btnDec = document.getElementById('decrease-font');

                btnToggle.addEventListener('click', () => {
                    body.classList.toggle('light-mode');
                    const isLight = body.classList.contains('light-mode');
                    localStorage.setItem('theme_checkout', isLight ? 'light' : 'dark');
                });

                if (localStorage.getItem('theme_checkout') === 'light') {
                    body.classList.add('light-mode');
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
<?php
}
?>
