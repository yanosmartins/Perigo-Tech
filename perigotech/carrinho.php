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

$total_itens_carrinho = 0;
if (isset($_SESSION['carrinho']) && !empty($_SESSION['carrinho'])) {
    $total_itens_carrinho = array_sum($_SESSION['carrinho']);
}

if (!isset($_SESSION['login'])) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <title>Carrinho</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700;900&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-color: #ad6224ff;
            --dark-bg: #ffffff;
            --card-bg: #ff7300ff;
            --text-color: #000000;
            --text-muted: #111111;
            --accent-color: #ff7300;
            --body-bg: #000000;
            --body-text: #ffffff;
        }

        body.light-mode {
            --body-bg: #ffffff;
            --body-text: #000000;
        }

        body.light-mode .cart {
            background-color: #f4f4f4;
            color: #000;
        }

        body.light-mode .cart-details h3 {
            color: #000;
        }

        body.light-mode .cart-item {
            border-bottom: 1px solid #ccc;
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
            /* Transição suave */
        }

        main {
            flex-grow: 1;
        }

        html {
            scroll-behavior: smooth;
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
            transition: color 0.3s ease;
        }

        .main-nav a:hover {
            color: #994907ff;
        }

        .header-icons {
            display: flex;
            align-items: center;
        }

        .header-icons a {
            color: var(--text-color);
            text-decoration: none;
            font-size: 1.2rem;
            margin-left: 20px;
            position: relative;
        }

        .header-icons a span {
            position: absolute;
            top: -8px;
            right: -10px;
            background-color: var(--accent-color);
            color: white;
            font-size: 0.7rem;
            border-radius: 50%;
            padding: 2px 5px;
        }

        .header-icons :hover {
            color: #994907ff;
            transition: color 0.3s ease;
        }

        .btn-primary {
            background-color: transparent;
            color: var(--primary-color);
            padding: 10px 20px;
            border: 2px solid var(--primary-color);
            border-radius: 5px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            width: auto;
            margin-top: 1rem;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary:hover {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-secondary,
        .btn-secondary-mais,
        .btn-secondary-menos {
            background-color: transparent;
            color: var(--primary-color);
            padding: 8px 15px;
            border: 2px solid var(--primary-color);
            border-radius: 5px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            margin: 0;
        }

        .btn-secondary:hover,
        .btn-secondary-menos:hover,
        .btn-secondary-mais:hover {
            background-color: var(--primary-color);
            color: white;
        }

        .cart {
            background: #1c1c1c;
            padding: 2rem;
            border-radius: 10px;
            color: white;
            margin-top: 1rem;
        }

        .cart-item {
            display: flex;
            align-items: center;
            border-bottom: 1px solid #333;
            padding: 1.5rem 0;
            gap: 20px;
        }

        .cart-img {
            width: 100px;
            height: 100px;
            object-fit: contain;
            border-radius: 8px;
            background: #fff;
            padding: 5px;
            flex-shrink: 0;
        }

        .cart-details {
            flex: 1;
        }

        .cart-details h3 {
            margin-bottom: .5rem;
            font-size: 1.1rem;
            color: inherit;
        }

        .cart-details .price {
            color: var(--primary-color);
            font-weight: bold;
            margin-bottom: 1rem;
        }

        .cart-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .cart-actions span {
            font-size: 1.2rem;
            font-weight: bold;
            margin: 0 10px;
            color: inherit;
        }

        .cart-item-subtotal {
            text-align: right;
            min-width: 120px;
        }

        .cart-item-subtotal p {
            font-size: 0.9rem;
            color: #aaa;
        }

        .cart-total {
            margin-top: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .total-finalizar {
            text-align: right;
        }

        .cart-total h2 {
            margin-bottom: 1rem;
            color: var(--primary-color);
        }

        .btn-danger {
            background-color: transparent;
            color: #ff4d4d;
            margin-top: 80px;
            padding: 10px 20px;
            border: 2px solid #ff4d4d;
            border-radius: 5px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-danger:hover {
            background-color: #ff4d4d;
            color: white;
        }

        /* --- Rodapé --- */
        .main-footer {
            background-color: var(--card-bg);
            padding: 3rem 0 1rem;
            border-top: 1px solid #333;
            margin-top: auto;
            color: #000;
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
            color: #000000;
        }

        .footer-section ul {
            list-style: none;
        }

        .footer-section ul li a {
            color: var(--text-muted);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-section ul li a:hover {
            color: var(--primary-color);
        }

        .social-icons a {
            color: var(--text-color);
            font-size: 1.5rem;
            margin: 0 10px;
        }

        .social-icons :hover {
            color: #994907ff;
            transition: color 0.3s ease;
        }

        .footer-bottom {
            text-align: center;
            padding-top: 1rem;
            border-top: 1px solid #333;
            color: var(--text-muted);
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

        /* --- RESPONSIVIDADE --- */
        @media (min-width: 768px) {
            .main-nav {
                display: flex;
            }

            .footer-content {
                grid-template-columns: repeat(3, 1fr);
                text-align: left;
            }
        }

        @media (max-width: 768px) {
            .cart-item {
                flex-direction: column;
                align-items: flex-start;
                text-align: left;
            }

            .cart-img {
                width: 300px;
                height: 300px;
                margin-bottom: 10px;
            }

            .cart-details {
                width: 100%;
            }

            .cart-actions {
                justify-content: flex-start;
                margin-top: 30px;
            }

            .cart-item-subtotal {
                text-align: left;
                margin-top: 15px;
                width: 100%;
                border-top: 1px solid #333;
                padding-top: 10px;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .cart-total {
                flex-direction: column;
                text-align: center;
                align-items: stretch;
            }

            .total-finalizar {
                text-align: center;
                margin-top: 20px;
            }

            .btn-secondary.remove {
                margin-left: 0 !important;
                width: 100%;
            }

            .cart-actions form {
                display: inline-block;
            }
        }
    </style>
</head>

<body>
    <header class="main-header">
        <div class="container">
            <a href="loja.php" class="logo">Perigo <span>Tech</span></a>
            <nav class="main-nav">
                <span>
                    <a href="loja.php#">Início</a>
                    <a href="loja.php#prod_destaq"> Em Destaque</a>
                    <a href="loja.php#perif">Periféricos</a>
                    <a href="loja.php#pc_completo">PCs</a>
                    <a href="loja.php#fontes">Fontes</a>
                    <a href="loja.php#placas">Placas</a>
                </span>
            </nav>
            <div class="header-icons">
                <a href="carrinho.php" aria-label="Carrinho"><i class="fas fa-shopping-cart"></i> <span><?php echo $total_itens_carrinho; ?></span></a>
                <a href="#" aria-label="Login"><i class="fas fa-user"></i></a>
                <?php if (isset($_SESSION['login'])) : ?>
                    <span style="font-size: 1rem; font-weight: 700; color: #000; white-space: nowrap; margin-left: 15px;">
                        Olá, <?php echo htmlspecialchars($_SESSION['login']); ?>!
                    </span>
                    <a href="logout.php" aria-label="Sair" title="Sair"><i class="fas fa-sign-out-alt"></i></a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <main class="container" style="padding: 3rem 0;">
        <h1 style="text-align:center; color: var(--primary-color); margin-bottom: 2rem;">
            🛒 Meu Carrinho
        </h1>

        <div class="cart">
            <?php
            $total_geral = 0;

            if (empty($_SESSION['carrinho'])) :
                echo '<p style="text-align: center; font-size: 1.2rem;">Seu carrinho está vazio.</p>';
                echo '<div style="text-align: center; margin-top: 2rem;"><a href="loja.php" class="btn-primary" style="width: auto;">Voltar para a Loja</a></div>';
            else :
                $ids_produtos = implode(',', array_keys($_SESSION['carrinho']));
                // Validação para evitar erro SQL se array vazio
                if (empty($ids_produtos)) $ids_produtos = "0";

                $sql = "SELECT * FROM produtos WHERE id_prod IN ($ids_produtos)";
                $result = $conn->query($sql);

                if ($result && $result->num_rows > 0) :
                    while ($produto = $result->fetch_assoc()) :
                        $id = $produto['id_prod'];
                        $quantidade = $_SESSION['carrinho'][$id];
                        $subtotal = $produto['preco'] * $quantidade;
                        $total_geral += $subtotal;
            ?>

                        <div class="cart-item">
                            <img src="./img/<?php echo htmlspecialchars($produto['img']); ?>" alt="<?php echo htmlspecialchars($produto['nome']); ?>" class="cart-img">

                            <div class="cart-details">
                                <h3><?php echo htmlspecialchars($produto['nome']); ?></h3>
                                <p class="price">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></p>

                                <div class="cart-actions">
                                    <form action="gerenciar_carrinho.php" method="POST" style="margin: 0;">
                                        <input type="hidden" name="id_prod" value="<?php echo $id; ?>">
                                        <input type="hidden" name="acao" value="remover_um">
                                        <button type="submit" class="btn-secondary-menos">-</button>
                                    </form>

                                    <span><?php echo $quantidade; ?></span>

                                    <form action="gerenciar_carrinho.php" method="POST" style="margin: 0;">
                                        <input type="hidden" name="id_prod" value="<?php echo $id; ?>">
                                        <input type="hidden" name="acao" value="adicionar">
                                        <button type="submit" class="btn-secondary-mais">+</button>
                                    </form>

                                    <form action="gerenciar_carrinho.php" method="POST" style="margin: 0;">
                                        <input type="hidden" name="id_prod" value="<?php echo $id; ?>">
                                        <input type="hidden" name="acao" value="remover_produto">
                                        <button type="submit" class="btn-secondary remove" style="margin-left: 15px;">Remover</button>
                                    </form>
                                </div>
                            </div>

                            <div class="cart-item-subtotal">
                                <p>Subtotal</p>
                                <h4 style="color: var(--primary-color);">R$ <?php echo number_format($subtotal, 2, ',', '.'); ?></h4>
                            </div>
                        </div>

                <?php
                    endwhile;
                endif;
                ?>

                <div class="cart-total">
                    <form action="gerenciar_carrinho.php" method="POST" style="margin: 0;">
                        <input type="hidden" name="acao" value="limpar">
                        <button type="submit" class="btn-danger">Esvaziar Carrinho</button>
                    </form>

                    <div class="total-finalizar">
                        <h2>Total: R$ <?php echo number_format($total_geral, 2, ',', '.'); ?></h2>
                        <a href="checkout.php" class="btn-primary">Finalizar Compra</a>
                    </div>
                </div>
            <?php endif; ?>

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
                        <li><a href="#">Sobre Nós</a></li>
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
            <div class="footer-bottom">
                &copy; 2025 Perigo Tech. Todos os direitos reservados.
            </div>
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

            // Acessibilidade
            btnToggle.addEventListener('click', () => {
                body.classList.toggle('light-mode');
                const isLight = body.classList.contains('light-mode');
                localStorage.setItem('theme', isLight ? 'light' : 'dark');
            });

            if (localStorage.getItem('theme') === 'light') {
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
