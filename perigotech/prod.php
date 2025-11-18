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

if (!isset($_GET['id'])) {
    die("Produto não especificado.");
}

$id = intval($_GET['id']);
$sql = "SELECT * FROM produtos WHERE id_prod = $id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die("Produto não encontrado.");
}

$produto = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($produto['nome']); ?> - Perigo Tech</title>
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
            color: #ffffff;
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

    <main class="produto-detalhe">
        <div class="container">
            <div class="produto-detalhe-wrapper">
                <div class="produto-imagem">
                    <img src="./img/<?php echo htmlspecialchars($produto['img']); ?>" alt="<?php echo htmlspecialchars($produto['nome']); ?>">
                </div>
                <div class="produto-info">
                    <h1><?php echo htmlspecialchars($produto['nome']); ?></h1>
                    <p class="categoria"><?php echo htmlspecialchars($produto['categoria']); ?></p>
                    <p class="descricao"><?php echo htmlspecialchars($produto['descricao']); ?></p>À vista
                    <div class="preco">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></div>
                    
                    <div class="price-box">
                        <p>Parcelamento</p>
                        <?php
                        $preco = $produto['preco'];
                        $maxSemJuros = 6;
                        $maxParcelas = 12;
                        ?>
                        <div class="parcelas-container">
                            <?php
                            for ($i = 1; $i <= $maxSemJuros; $i++) {
                                $valorSemJuros = $preco / $i;
                                if (($i + 6) <= $maxParcelas) {
                                    $juros = 3 + (($i + 6 - 7) * 0.5);
                                    $valorComJuros = ($preco * (1 + $juros / 100)) / ($i + 6);
                                    $textoComJuros = "com juros";
                                } else {
                                    $valorComJuros = "";
                                    $textoComJuros = "";
                                }

                                echo "<div class='parcelas-linha'>";
                                echo "<span>{$i}x de R$ " . number_format($valorSemJuros, 2, ',', '.') . " sem juros</span>";
                                if ($valorComJuros != "") {
                                    echo "<span>" . ($i + 6) . "x de R$ " . number_format($valorComJuros, 2, ',', '.') . " {$textoComJuros}</span>";
                                }
                                echo "</div>";
                            }
                            ?>
                        </div>
                    </div>

                    <p>Frete Grátis</p>
                   <?php if (isset($_SESSION['nome'])) : ?>
                        <form action="gerenciar_carrinho.php" method="POST">
                            <input type="hidden" name="id_prod" value="<?php echo $produto['id_prod']; ?>">
                            <input type="hidden" name="acao" value="adicionar">
                            <button type="submit" class="btn-secondary">Adicionar ao Carrinho</button>
                        </form>
                    <?php else : ?>
                        <a href="login.php" class="btn-secondary" style="text-align: center; display: block; text-decoration: none;">Adicionar ao Carrinho</a>
                    <?php endif; ?>
                </div>
            </div>
            
            <?php 
            if (!empty($produto['especificacoes'])) : 
            ?>
                <div class="especificacoes-wrapper"> 
                    <h2>Especificações Técnicas</h2>
                    <p><?php echo nl2br(htmlspecialchars($produto['especificacoes'])); ?></p>
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

</body>

</html>
