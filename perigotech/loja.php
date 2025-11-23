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

$search_query = "";
$search_term_sql = "";
if (isset($_GET['q']) && !empty(trim($_GET['q']))) {
    $search_query = trim($_GET['q']);
    $search_term_sql = $conn->real_escape_string($search_query);
}

function renderProduto($row)
{
    echo '<article class="carrossel-item" data-description="' . htmlspecialchars($row['descricao'], ENT_QUOTES, 'UTF-8') . '">';
    echo '<a href="prod.php?id=' . $row['id_prod'] . '" class="produto-link">';
    echo '<img src="./img/' . htmlspecialchars($row['img'], ENT_QUOTES, 'UTF-8') . '" alt="' . htmlspecialchars($row['nome'], ENT_QUOTES, 'UTF-8') . '" id="produto' . $row['id_prod'] . '">';
    echo '<h3 class="product-name">' . htmlspecialchars($row['nome'], ENT_QUOTES, 'UTF-8') . '</h3>';
    echo '<p class="product-category">' . htmlspecialchars($row['categoria'], ENT_QUOTES, 'UTF-8') . '</p>';
    echo '<div class="product-price"><span>R$ ' . number_format($row['preco'], 2, ',', '.') . '</span></div>';
    echo '</a>';

    if (isset($_SESSION['nome'])) {
        echo '<form action="gerenciar_carrinho.php" method="POST" style="margin: 0;">';
        echo '  <input type="hidden" name="id_prod" value="' . $row['id_prod'] . '">';
        echo '  <input type="hidden" name="acao" value="adicionar">';
        echo '  <button type="submit" class="btn-secondary btn-add-cart">Adicionar ao Carrinho</button>';
        echo '</form>';
    } else {
        echo '<a href="login.php" class="btn-secondary">Adicionar ao Carrinho</a>';
    }
    
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

</div>

    <style>
    /* --- MENU FLUTUANTE FIXO E SEMPRE ABERTO --- */

.float-menu {
    position: fixed;
    right: 20px;
    bottom: 20px;
    z-index: 2000;
}

.float-options {
    display: flex;
    flex-direction: column;
    gap: 10px;

    opacity: 1 !important;
    visibility: visible !important;
    transform: translateY(0) !important;
}

.float-options button {
    padding: 10px 15px;
    background-color: var(--card-bg);
    border: 1px solid #333;
    border-radius: 8px;
    color: var(--text-color);
    font-weight: 700;
    cursor: pointer;
    transition: background 0.3s;
}

.float-options button:hover {
    background: var(--primary-color);
    color: white;
}

/* Remove qualquer elemento relacionado ao botão antigo */
.float-btn {
    display: none !important;
}

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
            max-width: 1330px;
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

        .main-nav a[href="modeloBD.php"]{
            font-size: 17px;
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

        a.btn-secondary {
            display: block;
            text-decoration: none;
            text-align: center;
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
        
        .product-grid .carrossel-item {
            cursor: default;
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
            color: #ff7300!important;
            margin-bottom: 1rem;
            -webkit-text-fill-color: #ff7300 !important; /* Força em navegadores WebKit */
        }

        .product-card .product-price {
            font-size: 1.5rem;
            font-weight: 700;
            color: #ff7300!important;
            -webkit-text-fill-color: #ff7300 !important; /* Força em navegadores WebKit */
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
            color: #ff7300;
            font-size: 1.1rem;
            min-height: 4.5em;
            display: flex;
            align-items: center;
            justify-content: center;
        }


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
            background: none;
            border: none;
            padding: 0;
            cursor: pointer;
            color: var(--text-color); 
            font-size: 1.2rem;
            margin-left: -1px; 
            transition: color 0.3s ease;
        }
        .search-button:hover {
             color: #994907ff;
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
            width: 150px;
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

        .admin-menu-container {
          position: relative;
          display: inline-block;
        }
        .admin-dropdown-content {
          opacity: 0;
          visibility: hidden;
          transform: translateY(-10px);
          transition: opacity 0.3s ease, transform 0.4s ease, visibility 0.3s;
          position: absolute;
          background-color: #1a1a1aff;
          min-width: 180px;
          box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.5);
          z-index: 1001;
          left: 0;
          top: 30px;
          border-radius: 5px;
        }
        .admin-dropdown-content a {
          color: #ff7300; 
          padding: 12px 16px;
          text-decoration: none;
          display: block;
          font-size: 0.9rem;
          white-space: nowrap;
        }
        .admin-dropdown-content a:hover {
          background-color: #181818ff;
          border-radius: 5px;
        }
        .admin-dropdown-content.show {
          opacity: 1;
          visibility: visible;
          transform: translateY(0);
        }
   

        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700;900&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-color: #ad6224ff;
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
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        
        main {

            flex-grow: 1;
        }

        .container {
            max-width: 1310px;
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

        .main-nav a {
            color: var(--text-muted);
            text-decoration: none;
            margin: 0 13px;
            font-weight: 700;
            transition: color 0.3s ease;
        }

        .main-nav {
            display: none;
        }
        
        @media (min-width: 768px) {
            .main-nav {
                display: flex;
            }
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

        /* --- Detalhe Produto --- */
        .produto-detalhe-wrapper {
            display: flex;
            flex-direction: column;
            gap: 2rem;
            padding: 3rem 0;
        }

        .produto-imagem img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
            background: white;
            padding: 10px;
            display: block;
            margin: 0 auto;
        }
        
        @media (min-width: 768px) {
            .produto-imagem img {
                max-width: 650px;
                max-height: 600px;
            }
        }


        .produto-info h1 {
            font-size: 2rem;
            margin-bottom: 1rem;
        }

        .produto-info .categoria {
            font-size: 1rem;
            color: #bbbbbb;
            margin-bottom: 1rem;
        }

        .produto-info .descricao {
            margin-bottom: 1.5rem;
            color: #dddddd;
        }

        .produto-info .preco {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 1rem;
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
            margin-top: 2rem;
        }

        .btn-secondary:hover {
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

        /* --- Responsividade --- */
        @media (min-width: 768px) {
            .produto-detalhe-wrapper {
                flex-direction: row;
            }

            .produto-imagem,
            .produto-info {
                flex: 1;
            }

            .footer-content {
                grid-template-columns: repeat(3, 1fr);
                text-align: left;
            }
        }

        @media (max-width: 1024px) {
            .produto-imagem img {
                max-width: 600px;
            }
        }
        
        @media (max-width: 768px) {
            .produto-imagem img {
                max-width: 550px;
            }
        }

        @media (max-width: 580px) {
            .produto-imagem img {
                max-width: 360px;
            }
        }

        .price-box {
            margin: 20px 0;
            padding: 15px;
            border-radius: 10px;
            background: #000000ff;
            border: 2px solid #ff7300;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
        }


        .price-box > p {
            margin: 2px 0 10px 0;
            font-size: 0.85rem;
            color: #ff7300;
            font-weight: 500;
        }

        .price-box:hover {
            box-shadow: -10px 0 15px rgba(197, 81, 14, 0.5), 10px 0 15px rgba(197, 81, 14, 0.5), 0 10px 15px rgba(197, 81, 14, 0.5);
        }

        .parcelas-container {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .parcelas-linha {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .parcelas-linha span {
            font-size: 1rem;
            color: #ffffff;
        }

        .especificacoes-wrapper {
            margin: 20px 0;
            margin-bottom: 80px;
            padding: 15px;
            border-radius: 10px;
            background: #000000ff;
            border: 2px solid #ff7300;
            text-align: center; 
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
        }

        .especificacoes-wrapper:hover {
            box-shadow: -10px 0 15px rgba(197, 81, 14, 0.5), 10px 0 15px rgba(197, 81, 14, 0.5), 0 10px 15px rgba(197, 81, 14, 0.5);
        }

        .especificacoes-wrapper h2 {
            margin: 2px 0 15px 0;
            font-size: 0.85rem;
            color: #ffffff;
            font-weight: 500;
        }

        .especificacoes-wrapper p {
            font-size: 1rem;
            color: #ffffff;
            text-align: left;
            line-height: 1.8;
        }

#site-content .product-price {
    color: #ff7300 !important;
    -webkit-text-fill-color: #ff7300 !important;
}
.main-footer {
    background: #ff7300 !important;  /* fundo laranja */
    color: #000000 !important;       /* texto preto */
}

.main-footer * {
    color: #000000 !important;       /* força texto preto para todos os elementos dentro */
}

</style>
</head>


<body>
<!-- MENU FLUTUANTE SEMPRE ABERTO -->
<div class="float-menu always-open">
    <div class="float-options show">
        <button id="toggle-theme">🌗 Tema</button>
        <button id="increase-font">A+</button>
        <button id="decrease-font">A-</button>
    </div>
</div>

</header>
 <header class="main-header fixed-header">
        <div class="container">
            <a href="loja.php" class="logo">Perigo <span>Tech</span></a>
            <nav class="main-nav">
                <a href="#">Início</a>
                <a href="#prod_destaq"> Em Destaque</a>
                <a href="#perif">Periféricos</a>
                <a href="#pc_completo">PCs</a>
                <a href="#fontes">Fontes</a>
                <a href="#placas">Placas</a>
            </nav>

            <div class="header-icons">
                
                <form action="loja.php" method="GET" class="search-container">
                    <input type="text" name="q" value="<?php echo htmlspecialchars($search_query); ?>" class="search-input" placeholder="Pesquisar...">
                    <button type="submit" class="search-button" aria-label="Pesquisar"><i class="fas fa-search"></i></button>
                </form>
                
                <a href="carrinho.php" aria-label="Carrinho"><i class="fas fa-shopping-cart"></i> <span><?php echo $total_itens_carrinho; ?></span></a>
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
                <?php
                $admin_users = ['admin', 'master'];
                if (isset($_SESSION['login']) && in_array($_SESSION['login'], $admin_users)) : 
                ?>
                <div class="admin-menu-container">
                    <a href="#" id="admin-menu-button" aria-label="Painel Admin" title="Painel Admin">
                        <i class="fas fa-cog"></i>
                    </a>
                    <div id="admin-menu-dropdown" class="admin-dropdown-content">
                        <a href="sistema.php">Gerenciar Cadastros</a>
                        <a href="log.php">Tela log</a>
                        <a href="telabd.php">Modelo BD</a>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <button class="mobile-menu-icon" aria-label="Abrir menu">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </header>
<div id="site-content">
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

        <?php if (!empty($search_query)) : ?>

            <section id="search-results" class="product-section">
                <div class="container" style="text-align: center; width: 100%;">
                    <h2>Resultados para "<?php echo htmlspecialchars($search_query); ?>"</h2>
                    <div class="product-grid" style="margin-top: 2rem; padding: 0 20px;">
                        <?php
                        $sql_search = "SELECT * FROM produtos 
                                       WHERE nome LIKE '%$search_term_sql%'
                                          OR categoria LIKE '%$search_term_sql%'";
                        
                        $result_search = $conn->query($sql_search);
                        
                        if ($result_search && $result_search->num_rows > 0) {
                            while ($row = $result_search->fetch_assoc()) {
                                renderProduto($row);
                            }
                        } else {
                            echo '<p style="color: white; font-size: 1.2rem; grid-column: 1 / -1;">Nenhum produto encontrado para sua busca.</p>';
                        }
                        ?>
                    </div>
                </div>
            </section>

        <?php else : ?>

            <section id="prod_destaq" class="product-section secao-carrossel">
                <div class="container" style="text-align: center; width: 100%;">
                    <h2>Produtos em Destaque</h2>
                    <div style="display: flex; align-items: center; justify-content: center;">
                        <button class="btn-carrossel esquerda" onclick="scrollCarrossel(-1, 'carrossel-destaques')">❮</button>
                        <div class="carrossel-wrapper">
                            <div class="horizontal" id="carrossel-destaques">
                                <?php
                                $categoria_destaque = ['Placas de vídeo', 'Processadores', 'Armazenamento', 'Memória RAM', 'Monitor'];
                                $sql = "SELECT * FROM produtos WHERE categoria IN ('" . implode("','", $categoria_destaque) . "')";
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
                                $sql = "SELECT * FROM produtos WHERE categoria IN ('Microfones', 'Periféricos', 'Áudio', 'Pen Drive')";
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
                                $sql = "SELECT * FROM produtos WHERE categoria = 'Computadores'";
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
                                $sql = "SELECT * FROM produtos WHERE categoria = 'Fontes'";
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
            
            <section id="placas" class="product-section secao-carrossel">
                <div class="container" style="text-align: center; width: 100%;">
                    <h2>Placas de Vídeo</h2>
                    <div style="display: flex; align-items: center; justify-content: center;">
                        <button class="btn-carrossel esquerda" onclick="scrollCarrossel(-1, 'carrossel-placas')">❮</button>
                        <div class="carrossel-wrapper">
                            <div class="horizontal" id="carrossel-placas">
                                <?php
                                $sql = "SELECT * FROM produtos WHERE categoria = 'Placas de vídeo2'";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) renderProduto($row);
                                } else {
                                    echo "<p>Nenhuma Placa encontrada.</p>";
                                }
                                ?>
                            </div>
                        </div>
                        <button class="btn-carrossel direita" onclick="scrollCarrossel(1, 'carrossel-placas')">❯</button>
                    </div>
                </div>
            </section>

        <?php endif; ?>
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
                <div class="footer-bottom">
                    &copy; 2025 Perigo Tech. Todos os direitos reservados.
                </div>
            </div>
        </footer>

    </main>

    <script>

// DARK / LIGHT MODE — NÃO ALTERA O HEADER EM HIPÓTESE ALGUMA
document.getElementById("toggle-theme").addEventListener("click", () => {
    const site = document.getElementById("site-content");
    
    // Alterna a classe
    const dark = site.classList.toggle("dark-mode");
    
    if (dark) {
        site.style.setProperty("--dark-bg", "#000000");
        site.style.setProperty("--card-bg", "#292828ff");
        site.style.setProperty("--text-color", "#ff7300");
        site.style.setProperty("--text-muted", "#cccccc");
        site.style.background = "#000";
        site.style.color = "#ff7300";
    } else {
        site.style.setProperty("--dark-bg", "#ffffff");
        site.style.setProperty("--card-bg", "#ff7300");
        site.style.setProperty("--text-color", "#000000");
        site.style.setProperty("--text-muted", "#111111");
        site.style.background = "#ffffff";
        site.style.color = "#ff7300";
    }
});

// AUMENTAR / DIMINUIR FONTE
let currentFont = 100;

document.getElementById("increase-font").addEventListener("click", () => {
    if (currentFont < 150) {
        currentFont += 10;
        document.getElementById("site-content").style.fontSize = currentFont + "%";
    }
});

document.getElementById("decrease-font").addEventListener("click", () => {
    if (currentFont > 70) {
        currentFont -= 10;
        document.getElementById("site-content").style.fontSize = currentFont + "%";
    }
});

        document.addEventListener('DOMContentLoaded', function() {
            
            // Menu Mobile
            const mobileMenuIcon = document.querySelector('.mobile-menu-icon');
            const mobileNav = document.querySelector('.mobile-nav');
            mobileMenuIcon.addEventListener('click', function() {
                mobileNav.classList.toggle('active');
                const icon = mobileMenuIcon.querySelector('i');
                icon.classList.toggle('fa-bars');
                icon.classList.toggle('fa-times');
            });

            // Barra de Pesquisa
            const searchForm = document.querySelector('.search-container');
            const searchButton = document.querySelector('.search-button');
            const searchInput = document.querySelector('.search-input');
            const searchContainer = searchForm;

            if (searchInput.value.trim() !== "") {
                searchContainer.classList.add('active');
            }
            searchButton.addEventListener('click', function(event) {
                const isActive = searchContainer.classList.contains('active');
                const isEmpty = searchInput.value.trim() === "";
                if (!isActive) {
                    event.preventDefault(); // Impede o envio
                    searchContainer.classList.add('active');
                    searchInput.focus();
                } 
                else if (isActive && isEmpty) {
                    event.preventDefault(); // Impede o envio
                    searchContainer.classList.remove('active');
                }
            });

            searchForm.addEventListener('submit', function(event) {
                const isEmpty = searchInput.value.trim() === "";
                if (isEmpty) {
                    event.preventDefault(); 
                    window.location.href = 'loja.php';
                }
            });

            
            searchInput.addEventListener('input', function() {
                const termo = searchInput.value.trim();
                const urlAtual = new URL(window.location.href);
                if (termo === "" && urlAtual.searchParams.has('q')) {
                    window.location.href = 'loja.php';
                }
            });


            // Engrenagem admin 
            const adminButton = document.getElementById('admin-menu-button');
            if (adminButton) {
                adminButton.addEventListener('click', function(event) {
                    event.preventDefault(); 
                    const dropdown = document.getElementById('admin-menu-dropdown');
                    dropdown.classList.toggle('show');
                });
            }

            window.addEventListener('click', function(event) {
                if (!event.target.closest('#admin-menu-button')) {
                    const dropdowns = document.querySelectorAll('.admin-dropdown-content');
                    dropdowns.forEach(dropdown => {
                        if (dropdown.classList.contains('show')) {
                            dropdown.classList.remove('show');
                        }
                    });
                }
            });

        }); 

        // Carrossel 
        function scrollCarrossel(direction, carrosselId) {
            const carrossel = document.getElementById(carrosselId);
            const itemWidth = carrossel.querySelector('.carrossel-item').offsetWidth + 30;
            carrossel.scrollBy({
                left: itemWidth * direction,
                behavior: 'smooth'
            });
        }
    </script>
</div> <!-- fechamento do #site-content -->
</body>

</html>
