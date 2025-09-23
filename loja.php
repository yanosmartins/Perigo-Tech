<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "perigotech";
$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

function renderProduto($row) {
    echo '<article class="carrossel-item" data-description="' . $row['descricao'] . '">';
    echo '<a href="prod.php?id=' . $row['id_prod'] . '" class="produto-link">';
    echo '<img src="./img/' . $row['img'] . '" alt="' . $row['nome'] . '" id="produto' . $row['id_prod'] . '">';
    echo '<h3 class="product-name">' . $row['nome'] . '</h3>';
    echo '<p class="product-category">' . $row['categoria'] . '</p>';
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
    <link rel="stylesheet" href="loja.css">
    <style>
        .produto-link {
            display: block;
            text-decoration: none;
            color: inherit;
        }
        .produto-link:hover {
            cursor: pointer;
        }
        .product-name {
            color: inherit; /* nome como texto normal */
        }
    </style>
</head>
<body>

<header class="main-header">
    <div class="container">
        <a href="#" class="logo">Perigo <span>Tech</span></a>
        <nav class="main-nav">
            <span>
                <a href="#prod_destaq">Produtos em Destaque</a>
                <a href="#perif">Periféricos</a>
                <a href="#pc_completo">PCs Completos</a>
                <a href="#">Início</a>
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

    <!-- PRODUTOS EM DESTAQUE -->
    <section id="prod_destaq" class="product-section secao-carrossel">
        <div class="container" style="text-align: center; width: 100%;">
            <h2>Produtos em Destaque</h2>
            <div style="display: flex; align-items: center; justify-content: center;">
                <button class="btn-carrossel esquerda" onclick="scrollCarrossel(-1, 'carrossel-destaques')">❮</button>
                <div class="carrossel-wrapper">
                    <div class="horizontal" id="carrossel-destaques">
                        <?php
                        $categorias_destaque = ['Placas de Vídeo', 'Processadores', 'Armazenamento', 'Memória RAM', 'Monitor'];
                        $sql = "SELECT * FROM produtos WHERE categoria IN ('" . implode("','", $categorias_destaque) . "')";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) renderProduto($row);
                        } else { echo "<p>Nenhum produto encontrado.</p>"; }
                        ?>
                    </div>
                </div>
                <button class="btn-carrossel direita" onclick="scrollCarrossel(1, 'carrossel-destaques')">❯</button>
            </div>
        </div>
    </section>

    <!-- PERIFÉRICOS -->
    <section id="perif" class="product-section secao-carrossel">
        <div class="container" style="text-align: center; width: 100%;">
            <h2>Periféricos</h2>
            <div style="display: flex; align-items: center; justify-content: center;">
                <button class="btn-carrossel esquerda" onclick="scrollCarrossel(-1, 'carrossel-perifericos')">❮</button>
                <div class="carrossel-wrapper">
                    <div class="horizontal" id="carrossel-perifericos">
                        <?php
                        $sql = "SELECT * FROM produtos WHERE categoria IN ('Microfones', 'Periféricos', 'Áudio', 'Pen Drive')";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) renderProduto($row);
                        } else { echo "<p>Nenhum periférico encontrado.</p>"; }
                        ?>
                    </div>
                </div>
                <button class="btn-carrossel direita" onclick="scrollCarrossel(1, 'carrossel-perifericos')">❯</button>
            </div>
        </div>
    </section>

    <!-- PCS COMPLETOS -->
    <section id="pc_completo" class="product-section secao-carrossel">
        <div class="container" style="text-align: center; width: 100%;">
            <h2>Computadores</h2>
            <div style="display: flex; align-items: center; justify-content: center;">
                <button class="btn-carrossel esquerda" onclick="scrollCarrossel(-1, 'carrossel-computadores')">❮</button>
                <div class="carrossel-wrapper">
                    <div class="horizontal" id="carrossel-computadores">
                        <?php
                        $sql = "SELECT * FROM produtos WHERE categoria = 'Computadores'";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) renderProduto($row);
                        } else { echo "<p>Nenhum computador encontrado.</p>"; }
                        ?>
                    </div>
                </div>
                <button class="btn-carrossel direita" onclick="scrollCarrossel(1, 'carrossel-computadores')">❯</button>
            </div>
        </div>
    </section>

    <!-- FONTES -->
    <section id="fontes" class="product-section secao-carrossel">
        <div class="container" style="text-align: center; width: 100%;">
            <h2>Fontes</h2>
            <div style="display: flex; align-items: center; justify-content: center;">
                <button class="btn-carrossel esquerda" onclick="scrollCarrossel(-1, 'carrossel-fontes')">❮</button>
                <div class="carrossel-wrapper">
                    <div class="horizontal" id="carrossel-fontes">
                        <?php
                        $sql = "SELECT * FROM produtos WHERE categoria = 'Fontes'";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) renderProduto($row);
                        } else { echo "<p>Nenhuma fonte encontrada.</p>"; }
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
    carrossel.scrollBy({ left: itemWidth * direction, behavior: 'smooth' });
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

    const addToCartButtons = document.querySelectorAll('.btn-secondary');
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function() {
            alert('Produto adicionado ao carrinho! (Isso é uma demonstração)');
        });
    });
});
</script>

</body>
</html>
