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
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Perigo Tech - Carrinho</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"/>
    <style>
        /* ====== Reset / Base ====== */
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700;900&display=swap');
        *{box-sizing:border-box;margin:0;padding:0}
        html{scroll-behavior:smooth}
        :root{
            --primary-color:#ad6224;   /* laranja principal */
            --card-bg:#ff7300;        /* laranja / cards */
            --header-footer-bg:#ff7300;
            --text-color:#000;        /* texto padrão (preto no footer/header) */
            --muted:#111;
            --dark-bg:#000;
            --site-bg:#000;           /* fundo padrão da página (escuro) */
        }
        body{
            font-family: 'Roboto', sans-serif;
            background:var(--site-bg);
            color:#fff;
            min-height:100vh;
            display:flex;
            flex-direction:column;
        }
        .container{max-width:1310px;margin:0 auto;padding:0 20px}

        /* ====== Header (fixo laranja) ====== */
        header.main-header{
            background:var(--header-footer-bg) !important;
            color:var(--text-color) !important;
            padding:1rem 0;
            position:sticky;
            top:0;
            z-index:1000;
            border-bottom:1px solid #333;
        }
        header.main-header .container{display:flex;align-items:center;justify-content:space-between}
        .logo{font-weight:900;font-size:1.8rem;color:var(--text-color);text-decoration:none}
        .logo span{color:var(--primary-color)}
        .main-nav{display:none}
        .main-nav a{margin:0 12px;color:#111;text-decoration:none;font-weight:700}
        @media(min-width:768px){ .main-nav{display:flex} }

        .header-icons{display:flex;align-items:center;gap:15px}
        .header-icons a{color:var(--text-color);text-decoration:none;font-size:1.1rem;position:relative}
        .header-icons a span{position:absolute;top:-8px;right:-10px;background:var(--primary-color);color:#fff;border-radius:50%;padding:2px 6px;font-size:0.7rem}

        /* ====== Footer (fixo laranja) ====== */
        footer.main-footer{
            background:var(--header-footer-bg) !important;
            color:var(--text-color) !important;
            padding:3rem 0 1rem;
            border-top:1px solid #333;
            margin-top:auto;
            position: relative; /* GARANTE que ele siga o fluxo */
        }
        .footer-section h4{color:var(--primary-color);margin-bottom:1rem}
        .footer-section, .footer-section a{color:var(--text-color)}
        .footer-bottom{color:var(--text-color);text-align:center;padding-top:1rem;border-top:1px solid rgba(0,0,0,0.15)}

        
        main{flex:1;padding:3rem 0}
        .cart{background:#1c1c1c;padding:2rem;border-radius:10px;color:#fff}
        .cart-item{display:flex;align-items:center;border-bottom:1px solid #333;padding:1rem 0;gap:16px}
        .cart-img{width:120px;border-radius:8px;background:#fff;padding:6px}
        .cart-details{flex:1}
        .cart-details h3{color:#fff;margin-bottom:.5rem}
        /* preço do produto (garantido laranja) */
        .cart-details .price{color:var(--card-bg);font-weight:800;margin-bottom:1rem}
        .cart-item-subtotal p{color:#aaa;margin:0 0 .25rem 0}
        .cart-item-subtotal h4{color:var(--primary-color);margin:0}

        .cart-actions{display:flex;align-items:center;gap:10px}
        .cart-actions button{cursor:pointer}
        .btn-primary{background:transparent;color:var(--primary-color);padding:10px 20px;border:2px solid var(--primary-color);border-radius:6px;font-weight:700;text-decoration:none;display:inline-block}
        .btn-primary:hover{background:var(--primary-color);color:#fff}
        .btn-secondary,.btn-secondary-mais,.btn-secondary-menos,.btn-danger{background:transparent;border-radius:6px;padding:10px 14px;font-weight:700;cursor:pointer}
        .btn-secondary, .btn-secondary-mais, .btn-secondary-menos{border:2px solid var(--primary-color);color:var(--primary-color)}
        .btn-secondary:hover,.btn-secondary-mais:hover,.btn-secondary-menos:hover{background:var(--primary-color);color:#fff}
        .btn-danger{border:2px solid #ff4d4d;color:#ff4d4d}
        .btn-danger:hover{background:#ff4d4d;color:#fff}

        .cart-total{display:flex;justify-content:space-between;align-items:center;margin-top:2rem;gap:20px}
        @media(max-width:720px){
            .cart-item{flex-direction:column;align-items:flex-start}
            .cart-item-subtotal{width:100%;text-align:left}
            .cart-total{flex-direction:column;align-items:stretch}
        }

       
        .float-menu{position:fixed;right:20px;bottom:20px;z-index:2001}
        .float-options{display:flex;flex-direction:column;gap:10px}
        .float-options button{padding:10px 14px;background:var(--card-bg);border:1px solid #333;border-radius:8px;color:var(--text-color);font-weight:700;cursor:pointer}
        .float-options button:hover{background:var(--primary-color);color:#fff}

        
        #site-content.dark-mode{
            --site-bg: #000;
            background:#000;
            color:#fff;
        }
        
        header.main-header, footer.main-footer { background:var(--header-footer-bg) !important; color:var(--text-color) !important; }

        
        .product-name,.product-category{color:#fff}

        
        .text-center{text-align:center}
    </style>
</head>
<body>
    <div id="site-content">
        <!-- HEADER (cor laranja fixa) -->
        <header class="main-header">
            <div class="container">
                <a href="loja.php" class="logo">Perigo <span>Tech</span></a>
                <nav class="main-nav" aria-label="Navegação principal">
                    <a href="loja.php#">Início</a>
                    <a href="loja.php#prod_destaq">Em Destaque</a>
                    <a href="loja.php#perif">Periféricos</a>
                </nav>
                <div class="header-icons" aria-hidden="false">
                    <a href="carrinho.php" aria-label="Carrinho"><i class="fas fa-shopping-cart"></i> <span><?php echo $total_itens_carrinho; ?></span></a>
                    <a href="#" aria-label="Minha Conta"><i class="fas fa-user"></i></a>
                    <?php if (isset($_SESSION['login'])) : ?>
                        <span style="font-size:1rem;font-weight:700;color:var(--text-color);white-space:nowrap;margin-left:12px">Olá, <?php echo htmlspecialchars($_SESSION['login']); ?>!</span>
                        <a href="logout.php" aria-label="Sair" title="Sair"><i class="fas fa-sign-out-alt"></i></a>
                    <?php endif; ?>
                    <button class="mobile-menu-icon" aria-label="Abrir menu" style="background:none;border:none;color:var(--text-color);font-size:1.2rem;margin-left:8px"><i class="fas fa-bars"></i></button>
                </div>
            </div>
        </header>

        <!-- MAIN -->
        <main class="container" role="main">
            <h1 class="text-center" style="color:var(--primary-color);margin-bottom:1.5rem">🛒 Meu Carrinho</h1>

            <div class="cart" role="region" aria-label="Itens do carrinho">
                <?php
                $total_geral = 0;
                if (empty($_SESSION['carrinho'])) :
                    echo '<p class="text-center" style="font-size:1.15rem;color:#ddd">Seu carrinho está vazio.</p>';
                    echo '<div class="text-center" style="margin-top:1.5rem"><a href="loja.php" class="btn-primary">Voltar para a Loja</a></div>';
                else :
                    $ids_produtos = implode(',', array_keys($_SESSION['carrinho']));
                    // prevenção: se $ids_produtos vazio, evita query inválida
                    if (trim($ids_produtos) !== "") {
                        $sql = "SELECT * FROM produtos WHERE id_prod IN ($ids_produtos)";
                        $result = $conn->query($sql);
                        if ($result && $result->num_rows > 0) :
                            while ($produto = $result->fetch_assoc()) :
                                $id = $produto['id_prod'];
                                $quantidade = isset($_SESSION['carrinho'][$id]) ? intval($_SESSION['carrinho'][$id]) : 0;
                                $subtotal = $produto['preco'] * $quantidade;
                                $total_geral += $subtotal;
                ?>
                                <div class="cart-item" aria-live="polite">
                                    <img src="./img/<?php echo htmlspecialchars($produto['img']); ?>" alt="<?php echo htmlspecialchars($produto['nome']); ?>" class="cart-img">
                                    <div class="cart-details">
                                        <h3><?php echo htmlspecialchars($produto['nome']); ?></h3>
                                        <p class="price">R$ <?php echo number_format($produto['preco'],2,',','.'); ?></p>

                                        <div class="cart-actions" aria-label="Ações do produto">
                                            <form action="gerenciar_carrinho.php" method="POST" style="margin:0">
                                                <input type="hidden" name="id_prod" value="<?php echo $id; ?>">
                                                <input type="hidden" name="acao" value="remover_um">
                                                <button type="submit" class="btn-secondary-menos" title="Diminuir quantidade">-</button>
                                            </form>

                                            <span aria-live="polite" style="min-width:28px;text-align:center;display:inline-block;font-weight:700"><?php echo $quantidade; ?></span>

                                            <form action="gerenciar_carrinho.php" method="POST" style="margin:0">
                                                <input type="hidden" name="id_prod" value="<?php echo $id; ?>">
                                                <input type="hidden" name="acao" value="adicionar">
                                                <button type="submit" class="btn-secondary-mais" title="Aumentar quantidade">+</button>
                                            </form>

                                            <form action="gerenciar_carrinho.php" method="POST" style="margin:0">
                                                <input type="hidden" name="id_prod" value="<?php echo $id; ?>">
                                                <input type="hidden" name="acao" value="remover_produto">
                                                <button type="submit" class="btn-secondary" style="margin-left:12px">Remover</button>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="cart-item-subtotal" style="text-align:right;min-width:150px">
                                        <p style="font-size:0.9rem;color:#aaa">Subtotal</p>
                                        <h4>R$ <?php echo number_format($subtotal,2,',','.'); ?></h4>
                                    </div>
                                </div>
                <?php
                            endwhile;
                        endif;
                    } 
                ?>

                <?php if (!empty($_SESSION['carrinho'])) : ?>
                    <div class="cart-total" role="region" aria-label="Resumo do carrinho">
                        <form action="gerenciar_carrinho.php" method="POST" style="margin:0">
                            <input type="hidden" name="acao" value="limpar">
                            <button type="submit" class="btn-danger">Esvaziar Carrinho</button>
                        </form>

                        <div class="total-finalizar" style="text-align:right">
                            <h2 style="color:var(--primary-color);margin-bottom:.5rem">Total: R$ <?php echo number_format($total_geral,2,',','.'); ?></h2>
                            <a href="checkout.php" class="btn-primary">Finalizar Compra</a>
                        </div>
                    </div>
                <?php endif; ?>
                <?php endif; ?>
            </div>
        </main>
            </div> 

        <footer class="main-footer" role="contentinfo">
            <div class="container">
                <div class="footer-content" style="display:grid;grid-template-columns:1fr;gap:1.25rem;text-align:center;margin-bottom:1.25rem">
                    <div class="footer-section">
                        <h4>Perigo Tech</h4>
                        <p style="color:var(--text-color)">A sua paixão por hardware começa aqui.</p>
                    </div>
                    <div class="footer-section">
                        <h4>Links Rápidos</h4>
                        <ul style="list-style:none">
                            <li><a href="#" style="color:var(--text-color);text-decoration:none">Sobre Nós</a></li>
                            <li><a href="#" style="color:var(--text-color);text-decoration:none">Contato</a></li>
                        </ul>
                    </div>
                    <div class="footer-section">
                        <h4>Siga-nos</h4>
                        <div class="social-icons">
                            <a href="#" style="color:var(--text-color);margin-right:8px"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" style="color:var(--text-color);margin-right:8px"><i class="fab fa-twitter"></i></a>
                            <a href="#" style="color:var(--text-color)"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
                <div class="footer-bottom">&copy; 2025 Perigo Tech. Todos os direitos reservados.</div>
            </div>
        </footer>

    <div class="float-menu" aria-hidden="false">
        <div class="float-options">
            <button id="toggle-theme" aria-pressed="false" title="Alternar tema">🌗 Tema</button>
            <button id="increase-font" title="Aumentar fonte">A+</button>
            <button id="decrease-font" title="Diminuir fonte">A-</button>
        </div>
    </div>

    <script>
        
        document.addEventListener('DOMContentLoaded', () => {
            const site = document.getElementById('site-content');
            const btnToggle = document.getElementById('toggle-theme');
            const btnInc = document.getElementById('increase-font');
            const btnDec = document.getElementById('decrease-font');

           
            btnToggle.addEventListener('click', () => {
                const dark = site.classList.toggle('dark-mode');
              
                if (dark) {
                    
                    site.style.background = '#000';
                    site.style.color = '#fff';
                } else {
                    site.style.background = '#fff';
                    site.style.color = '#000';
                }
            });

          
            let currentFont = 100;
            btnInc.addEventListener('click', () => {
                if (currentFont < 150) {
                    currentFont += 10;
                    site.style.fontSize = currentFont + '%';
                }
            });
            btnDec.addEventListener('click', () => {
                if (currentFont > 70) {
                    currentFont -= 10;
                    site.style.fontSize = currentFont + '%';
                }
            });

            
        });
    </script>
</body>
</html>
