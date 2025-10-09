<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "cadastro-tech";
$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Inicia a sessão para "lembrar" do usuário logado
session_start();

function renderProduto($row)
{
    echo '<article class="carrossel-item" data-description="' . htmlspecialchars($row['descricao'], ENT_QUOTES, 'UTF-8') . '">';
    echo '<a href="prod.php?id=' . $row['id_prod'] . '" class="produto-link">';
    echo '<img src="./img/' . htmlspecialchars($row['img'], ENT_QUOTES, 'UTF-8') . '" alt="' . htmlspecialchars($row['nomeprod'], ENT_QUOTES, 'UTF-8') . '" id="produto' . $row['id_prod'] . '">';
    echo '<h3 class="product-name">' . htmlspecialchars($row['nomeprod'], ENT_QUOTES, 'UTF-8') . '</h3>';
    echo '<p class="product-category">' . htmlspecialchars($row['categorias'], ENT_QUOTES, 'UTF-8') . '</p>';
    echo '<div class="product-price"><span>R$ ' . number_format($row['preco'], 2, ',', '.') . '</span></div>';
    echo '</a>';
    echo '<button class="btn-secondary">Adicionar ao Carrinho</button>';
    echo '</article>';
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perigo Tech - A sua loja de peças de PC</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
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

        .header-icons a:hover {
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
            background-color: var(--primary-color);
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 700;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #994907ff;
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

        .social-icons a:hover {
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
            color: white;
            /* Garante que o nome do produto seja branco */
            font-size: 1.1rem;
            min-height: 4.5em;
            /* Define uma altura mínima para alinhar os cards */
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* --- ANIMAÇÃO: DESLIZAR SUAVEMENTE COM MARGEM --- */

        .header-icons {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .search-container {
            display: flex;
            align-items: center;
        }

        .search-button {
            order: 2;
            z-index: 10;
        }

        .search-input {
            width: 0;
            padding: 0;
            border: none;
            opacity: 0;
            outline: none;
            border-radius: 20px;
            background-color: #ffffff;
            color: #333;
            font-size: 1rem;
            height: 40px;
            margin-left: -20px;
            transition: all 0.5s ease-out;
        }

        .search-container.active .search-input {
            width: 200px;
            opacity: 1;
            padding: 0 15px;
            border: 1px solid #ddd;
            margin-right: 10px;
            margin-left: 0;
        }

        .search-input::placeholder {
            color: #ff7300;
            opacity: 1;
        }
    </style>
</head>

<body>

    <header class="main-header">
        <div class="container">
            <a href="#" class="logo">Perigo <span>Tech</span></a>
            <nav class="main-nav">
                <a href="#prod_destaq">Produtos em Destaque</a>
                <a href="#perif">Periféricos</a>
                <a href="#pc_completo">PCs Completos</a>
                <a href="#">Início</a>
            </nav>

            <div class="header-icons">
                <div class="search-container">
                    <input type="text" class="search-input" placeholder="Pesquisar...">
                    <a href="#" class="search-button" aria-label="Pesquisar"><i class="fas fa-search"></i></a>
                </div>
                <a href="carrinho.php" aria-label="Carrinho"><i class="fas fa-shopping-cart"></i> <span>0</span></a>
                <?php if (isset($_SESSION['nome'])) : ?>
                    <span style="font-size: 1rem; font-weight: 700; color: #000; white-space: nowrap;">
                        <a href="#" aria-label="Minha Conta" title="Minha Conta"><i class="fas fa-user" style="margin-right: 15px;"></i></a>
                        Olá, <?php echo htmlspecialchars($_SESSION['nome']); ?>!
                    </span>
                    <a href="logout.php" aria-label="Sair" title="Sair"><i class="fas fa-sign-out-alt"></i></a>
                <?php else : ?>
                    <a href="login.php" aria-label="Login"><i class="fas fa-user"></i></a>
                    <a href="login.php" style="font-size: 1rem; font-weight: 700; white-space: nowrap;">Entrar/Cadastrar</a>
                <?php endif; ?>
            </div>
            <button class="mobile-menu-icon" aria-label="Abrir menu">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </header>

    <nav class="mobile-nav">
        <a href="#prod_destaq">Produtos em Destaque</a>
        <a href="#perif">Periféricos</a>
        <a href="#pc_completo">PCs Completos</a>
        <a href="#">Minha conta</a>
    </nav>

    <main>
        <section class="hero">
            <div class="container">
                <h1>As Melhores Peças Para o Seu Setup</h1>
                <p>Qualidade, performance e os melhores preços do mercado.</p>
                <a href="#prod_destaq" class="btn-primary">Ver Ofertas</a>
            </div>
        </section>

        <section id="prod_destaq" class="product-section secao-carrossel">
            <div class="container" style="text-align: center; width: 100%;">
                <h2>Produtos em Destaque</h2>
                <div style="display: flex; align-items: center; justify-content: center;">
                    <button class="btn-carrossel esquerda" onclick="scrollCarrossel(-1, 'carrossel-destaques')">❮</button>
                    <div class="carrossel-wrapper">
                        <div class="horizontal" id="carrossel-destaques">
                            <?php
                            $categorias_destaque = ['Placas de Vídeo', 'Processadores', 'Armazenamento', 'Memória RAM', 'Monitor'];
                            $sql = "SELECT * FROM produtos WHERE categorias IN ('" . implode("','", $categorias_destaque) . "')";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) renderProduto($row);
                            } else {
                                echo "<p>Nenhum produto encontrado.</p>";
                            }
                            ?>
                        </div>
                    </div>
                    <button class="btn-carrossel direita" onclick="scrollCarrossel(1, 'carrossel-destaques')">❯</button>
                </div>
            </div>
        </section>

        <section id="perif" class="product-section secao-carrossel">
            <div class="container" style="text-align: center; width: 100%;">
                <h2>Periféricos</h2>
                <div style="display: flex; align-items: center; justify-content: center;">
                    <button class="btn-carrossel esquerda" onclick="scrollCarrossel(-1, 'carrossel-perifericos')">❮</button>
                    <div class="carrossel-wrapper">
                        <div class="horizontal" id="carrossel-perifericos">
                            <?php
                            $sql = "SELECT * FROM produtos WHERE categorias IN ('Microfones', 'Periféricos', 'Áudio', 'Pen Drive')";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) renderProduto($row);
                            } else {
                                echo "<p>Nenhum periférico encontrado.</p>";
                            }
                            ?>
                        </div>
                    </div>
                    <button class="btn-carrossel direita" onclick="scrollCarrossel(1, 'carrossel-perifericos')">❯</button>
                </div>
            </div>
        </section>

        <section id="pc_completo" class="product-section secao-carrossel">
            <div class="container" style="text-align: center; width: 100%;">
                <h2>Computadores</h2>
                <div style="display: flex; align-items: center; justify-content: center;">
                    <button class="btn-carrossel esquerda" onclick="scrollCarrossel(-1, 'carrossel-computadores')">❮</button>
                    <div class="carrossel-wrapper">
                        <div class="horizontal" id="carrossel-computadores">
                            <?php
                            $sql = "SELECT * FROM produtos WHERE categorias = 'Computadores'";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) renderProduto($row);
                            } else {
                                echo "<p>Nenhum computador encontrado.</p>";
                            }
                            ?>
                        </div>
                    </div>
                    <button class="btn-carrossel direita" onclick="scrollCarrossel(1, 'carrossel-computadores')">❯</button>
                </div>
            </div>
        </section>

        <section id="fontes" class="product-section secao-carrossel">
            <div class="container" style="text-align: center; width: 100%;">
                <h2>Fontes</h2>
                <div style="display: flex; align-items: center; justify-content: center;">
                    <button class="btn-carrossel esquerda" onclick="scrollCarrossel(-1, 'carrossel-fontes')">❮</button>
                    <div class="carrossel-wrapper">
                        <div class="horizontal" id="carrossel-fontes">
                            <?php
                            $sql = "SELECT * FROM produtos WHERE categorias = 'Fontes'";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) renderProduto($row);
                            } else {
                                echo "<p>Nenhuma fonte encontrada.</p>";
                            }
                            ?>
                        </div>
                    </div>
                    <button class="btn-carrossel direita" onclick="scrollCarrossel(1, 'carrossel-fontes')">❯</button>
                </div>
            </div>
        </section>

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

    </main>

    <script>
        function scrollCarrossel(direction, carrosselId) {
            const carrossel = document.getElementById(carrosselId);
            const itemWidth = carrossel.querySelector('.carrossel-item').offsetWidth + 30;
            carrossel.scrollBy({
                left: itemWidth * direction,
                behavior: 'smooth'
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuIcon = document.querySelector('.mobile-menu-icon');
            const mobileNav = document.querySelector('.mobile-nav');
            mobileMenuIcon.addEventListener('click', function() {
                mobileNav.classList.toggle('active');
                const icon = mobileMenuIcon.querySelector('i');
                icon.classList.toggle('fa-bars');
                icon.classList.toggle('fa-times');
            });

            // Adicionar ao Carrinho
            const addToCartButtons = document.querySelectorAll('.btn-secondary');
            addToCartButtons.forEach(button => {
                button.addEventListener('click', function() {
                    alert('Produto adicionado ao carrinho! (Isso é uma demonstração)');
                });
            });

            // Barra de Pesquisa
            const searchButton = document.querySelector('.search-button');
            const searchContainer = document.querySelector('.search-container');
            const searchInput = document.querySelector('.search-input');

            searchButton.addEventListener('click', function(event) {
                event.preventDefault();
                searchContainer.classList.toggle('active');
                if (searchContainer.classList.contains('active')) {
                    searchInput.focus();
                }
            });
        });
    </script>

</body>

</html>