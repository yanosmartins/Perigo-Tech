<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <title>Carrinho</title>
</head>

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
        margin: 0 15px;
        font-weight: 700;
        transition: color 0.3s ease;
    }

    .main-nav a:hover {
        color: #994907ff;
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

    /* --- Seção Hero --- */
    .hero {
        background: linear-gradient(rgba(100, 100, 100, 0.8), rgba(0, 0, 0, 0.9));
        height: 60vh;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
    }

    .hero h1 {
        font-size: 3rem;
        font-weight: 900;
        margin-bottom: 1rem;
        color: white;
    }

    .hero p {
        font-size: 1.2rem;
        margin-bottom: 2rem;
        color: white;
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
        width: 20%;
        margin-top: 1rem;
    }

    .btn-primary:hover {
        background-color: var(--primary-color);
        color: white;
    }

    .btn-secondary {
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

    .btn-secondary:hover {
        background-color: var(--primary-color);
        color: white;
    }

    /* --- Seção de Produtos --- */
    .product-section {
        padding: 4rem 0;
    }

    .product-section h2 {
        text-align: center;
        font-size: 2.5rem;
        margin-bottom: 2rem;
        color: var(--primary-color);
    }

    .product-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 2rem;
    }

    .product-card {
        background-color: var(--card-bg);
        border-radius: 8px;
        overflow: hidden;
        text-align: center;
        padding: 1.5rem;
        border: 1px solid #333;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .product-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 20px rgba(255, 0, 0, 0.2);
    }

    .product-card img {
        max-width: 100%;
        height: auto;
        margin-bottom: 1rem;
    }

    .product-card h3 {
        font-size: 1.2rem;
        margin-bottom: 0.5rem;
        color: white;
    }

    .product-card .product-category {
        font-size: 0.9rem;
        color: var(--text-muted);
        margin-bottom: 1rem;
    }

    .product-card .product-price {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary-color);
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

        .product-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .footer-content {
            grid-template-columns: repeat(3, 1fr);
            text-align: left;
        }
    }

    @media (min-width: 1024px) {
        .product-grid {
            grid-template-columns: repeat(4, 1fr);
        }

        .hero h1 {
            font-size: 4rem;
        }
    }


    .secao-carrossel {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        width: 100%;
    }

    .carrossel-wrapper {
        overflow: hidden;
        padding-inline: 1px;
        width: 100%;
        min-width: 1250px;
    }

    .horizontal {
        overflow-x: auto;
        scroll-behavior: smooth;
        padding: 20px;
        gap: 30px;
        display: flex;
        flex-wrap: nowrap;
    }

    .horizontal::-webkit-scrollbar {
        display: none;
    }

    .btn-carrossel {
        background: none;
        border: none;
        color: #333;
        font-size: 30px;
        cursor: pointer;
        padding: 0 10px;
        transition: color 0.3s ease, transform 0.3s ease;
        z-index: 10;
    }

    .btn-carrossel:hover {
        color: #ff7300;
        transform: scale(1.15);
    }

    .carrossel-item {
        background-color: #292828ff;
        border: none;
        border-radius: 8px;
        padding: 20px;
        text-align: center;
        flex-shrink: 0;
        width: 280px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        cursor: pointer;
    }

    .carrossel-item:hover {
        transform: translateY(-5px);
        box-shadow: -10px 0 15px rgba(197, 81, 14, 0.5), 10px 0 15px rgba(197, 81, 14, 0.5), 0 10px 15px rgba(197, 81, 14, 0.5);
    }

    .carrossel-item img {
        max-width: 100%;
        height: 200px;
        object-fit: contain;
        margin-bottom: 15px;
    }

    .produto-link {
        display: block;
        text-decoration: none;
        color: inherit;
    }

    .produto-link:hover {
        cursor: pointer;
    }

    .product-name {
        color: inherit;
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
    text-align: right;
    margin-top: 2rem;
}

.cart-total h2 {
    margin-bottom: 1rem;
    color: var(--primary-color);
}


</style>

<body>
    <header class="main-header">
        <div class="container">
            <a href="#" class="logo">Perigo <span>Tech</span></a>
            <nav class="main-nav">
                <span>
                    <a href="loja.php #prod_destaq">Produtos em Destaque</a>
                    <a href="loja.php #perif">Periféricos</a>
                    <a href="loja.php #pc_completo">PCs Completos</a>
                    <a href="loja.php">Início</a>
                </span>
            </nav>
            <div class="header-icons">
                <a href="#" aria-label="Pesquisar"><i class="fas fa-search"></i></a>
                <a href="carrinho.php" aria-label="Carrinho"><i class="fas fa-shopping-cart"></i> <span>0</span></a>
                <a href="#" aria-label="Login"><i class="fas fa-user"></i></a>
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
            <div class="cart-item">
                <img src="./img/rtx_5080.png" alt="Produto" class="cart-img">
                <div class="cart-details">
                    <h3>Placa de Vídeo RTX 5080</h3>
                    <p class="price">R$ 7.999,90</p>
                    <div class="cart-actions">
                        <button class="btn-secondary">-</button>
                        <span>1</span>
                        <button class="btn-secondary">+</button>
                        <button class="btn-secondary remove">Remover</button>
                    </div>
                </div>
            </div>

            <div class="cart-total">
                <h2>Total: R$ 7.999,90</h2>
                <button class="btn-primary">Finalizar Compra</button>
            </div>
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

</body>

</html>
