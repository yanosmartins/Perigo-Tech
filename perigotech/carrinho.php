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

if (!isset($_SESSION['nome'])) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

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
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: black;
            color: white;
            line-height: 1.6;

            /* --- CORREÇÃO FOOTER FLUTUANTE --- */
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            /* --- FIM DA CORREÇÃO --- */
        }

        main {
            /* --- CORREÇÃO FOOTER FLUTUANTE --- */
            flex-grow: 1; /* Faz o <main> esticar e preencher o espaço */
        }

        html {
            scroll-behavior: smooth;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* --- Cabeçalho --- */
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
            margin-left: 31px;
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

        .mobile-menu-icon {
            display: block;
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
        }

        /* --- Menu Mobile --- */
        .mobile-nav {
            display: none;
            flex-direction: column;
            background-color: var(--card-bg);
            position: sticky;
            top: 70px;
            z-index: 999;
        }

        .mobile-nav.active {
            display: flex;
        }

        .mobile-nav a {
            color: var(--text-color);
            text-decoration: none;
            padding: 15px 20px;
            border-bottom: 1px solid #333;
            text-align: center;
        }

        .mobile-nav a:hover {
            background-color: var(--primary-color);
        }

        /* --- Botões --- */
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
            padding: 10px 20px;
            border: 2px solid var(--primary-color);
            border-radius: 5px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            margin-top: 1rem;
        }

        .btn-secondary:hover,
        .btn-secondary-menos:hover,
        .btn-secondary-mais:hover {
            background-color: var(--primary-color);
            color: white;
        }
        
        /* --- Rodapé --- */
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

        /* --- Media Queries (Responsividade) --- */
        @media (min-width: 768px) {
            .mobile-menu-icon {
                display: none;
            }

            .main-nav {
                display: flex;
            }

            .footer-content {
                grid-template-columns: repeat(3, 1fr);
                text-align: left;
            }
        }
        
        .cart {
            background: #1c1c1c;
            padding: 2rem;
            border-radius: 10px;
            color: white;
        }

        .cart-item {
            display: flex;
            align-items: center;
            border-bottom: 1px solid #333;
            padding: 1rem 0;
        }

        .cart-img {
            width: 120px;
            height: auto;
            margin-right: 20px;
            border-radius: 8px;
            background: #fff;
            padding: 5px;
        }

        .cart-details {
            flex: 1;
        }

        .cart-details h3 {
            margin-bottom: .5rem;
            color: white;
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
        }

        .cart-actions span {
            font-size: 1.2rem;
            font-weight: bold;
        }

        .cart-total {
            margin-top: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
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
            padding: 10px 20px;
            border: 2px solid #ff4d4d;
            border-radius: 5px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 4.7rem;
            text-decoration: none;
        }

        .btn-danger:hover {
            background-color: #ff4d4d;
            color: white;
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
                <?php if (isset($_SESSION['nome'])) : ?>
                    <span style="font-size: 1rem; font-weight: 700; color: #000; white-space: nowrap; margin-left: 15px;">
                        Olá, <?php echo htmlspecialchars($_SESSION['nome']); ?>!
                    </span>
                    <a href="logout.php" aria-label="Sair" title="Sair"><i class="fas fa-sign-out-alt"></i></a>
                <?php endif; ?>

            </div>
            <button class="mobile-menu-icon" aria-label="Abrir menu">
                <i class="fas fa-bars"></i>
            </button>
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
                $sql = "SELECT * FROM produtos WHERE id_prod IN ($ids_produtos)";
                $result = $conn->query($sql);
                
                if ($result->num_rows > 0) :
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
                            <div class="cart-item-subtotal" style="text-align: right; min-width: 150px;">
                                <p style="font-size: 0.9rem; color: #aaa;">Subtotal</p>
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
            <?php endif;?>
            
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

</body>

</html>

