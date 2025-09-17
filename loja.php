<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perigo Tech - A sua loja de peças de PC</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="loja.css">

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
                <a href="#" aria-label="Carrinho"><i class="fas fa-shopping-cart"></i> <span>0</span></a>
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

        <section id="prod_destaq" class="product-section secao-carrossel">
            <div class="container" style="text-align: center; width: 100%;">
                <h2>Produtos em Destaque</h2>
                <div style="display: flex; align-items: center; justify-content: center;">
                    <button class="btn-carrossel esquerda" onclick="scrollCarrossel(-1, 'carrossel-destaques')">❮</button>
                    <div class="carrossel-wrapper">
                        <div class="horizontal" id="carrossel-destaques">
                            <article class="carrossel-item" data-description="A nova RTX 5080 oferece um salto de performance geracional com a arquitetura de última geração da NVIDIA. Ideal para jogos em 4K com Ray Tracing no máximo e para criadores de conteúdo que exigem velocidade.">
                                <img src="./img/rtx_5080.png" alt="Placa de Vídeo Exemplo" id="placasvideo">
                                <h3>Placa de Vídeo RTX 5080</h3>
                                <p class="product-category">Placas de Vídeo</p>
                                <div class="product-price"><span>R$ 7.999,90</span></div>
                                <button class="btn-secondary">Adicionar ao Carrinho</button>
                            </article>

                            <article class="carrossel-item" data-description="O processador Core i9 15900K é a escolha definitiva para entusiastas e gamers que buscam o máximo de desempenho. Com seus múltiplos núcleos e altas frequências, ele encara qualquer tarefa pesada sem dificuldades.">
                                <img src="./img/i9.webp" alt="Processador Exemplo" id="processadores">
                                <h3>Processador Core i9 15900K</h3>
                                <p class="product-category">Processadores</p>
                                <div class="product-price"><span>R$ 3.899,90</span></div>
                                <button class="btn-secondary">Adicionar ao Carrinho</button>
                            </article>

                            <article class="carrossel-item" data-description="Elimine as telas de carregamento com o SSD NVMe de 2TB. Com velocidades de leitura e escrita ultrarrápidas, seus jogos e programas carregarão em um piscar de olhos.">
                                <img src="./img/ssd_nvme.png" alt="SSD NVMe Exemplo" id="armaze">
                                <h3>SSD NVMe 2TB SuperSpeed</h3>
                                <p class="product-category">Armazenamento</p>
                                <div class="product-price"><span>R$ 1.199,90</span></div>
                                <button class="btn-secondary">Adicionar ao Carrinho</button>
                            </article>

                            <article class="carrossel-item" data-description="Este kit de 32GB (2x16GB) de memória RAM DDR5 é perfeito para multitarefa e jogos de alta performance. A tecnologia DDR5 garante maior largura de banda e eficiência para o seu sistema.">
                                <img src="./img/memoria_ram.png" alt="Memória RAM Exemplo" id="memoria">
                                <h3>Memória RAM DDR5 32GB (2x16)</h3>
                                <p class="product-category">Memória RAM</p>
                                <div class="product-price"><span>R$ 899,90</span></div>
                                <button class="btn-secondary">Adicionar ao Carrinho</button>
                            </article>

                            <article class="carrossel-item" data-description="Mergulhe na ação com o monitor gamer curvo Husky Storm de 27 polegadas. Com 180Hz de taxa de atualização e 1ms de tempo de resposta, você terá a vantagem competitiva que precisa.">
                                <img src="./img/monitor180hz.png" alt="Monitor Exemplo" id="monitor1">
                                <h3>Monitor Gamer Husky Storm 27' LED, Curvo, 180Hz, Full HD, 1ms</h3>
                                <p class="product-category">Monitor</p>
                                <div class="product-price"><span>R$ 959,90</span></div>
                                <button class="btn-secondary">Adicionar ao Carrinho</button>
                            </article>

                        </div>
                    </div>
                    <button class="btn-carrossel direita" onclick="scrollCarrossel(1, 'carrossel-destaques')">❯</button>
                </div>
            </div>
        </section>
    </main>

    <section id="perif" class="product-section secao-carrossel">
        <div class="container" style="text-align: center; width: 100%;">
            <h2>Periféricos</h2>
            <div style="display: flex; align-items: center; justify-content: center;">
                <button class="btn-carrossel esquerda" onclick="scrollCarrossel(-1, 'carrossel-acessorios')">❮</button>
                <div class="carrossel-wrapper">
                    <div class="horizontal" id="carrossel-acessorios">

                        <article class="carrossel-item" data-description="Capture sua voz com clareza cristalina usando o microfone Fifine Ampligame. Seu padrão cardióide foca na sua voz, reduzindo ruídos de fundo, e a iluminação RGB adiciona estilo ao seu setup.">
                            <img src="./img/microfone.png" alt="Microfone Exemplo" id="microfone">
                            <h3>Microfone Dinâmico Gamer Fifine Ampligame, RGB, Cardióide, USB-C</h3>
                            <p class="product-category">Microfones</p>
                            <div class="product-price"><span>R$ 279,99</span></div>
                            <button class="btn-secondary">Adicionar ao Carrinho</button>
                        </article>

                        <article class="carrossel-item" data-description="Leve seus arquivos para qualquer lugar com o Pen Drive Kingston DataTraveler de 64GB. Confiável, rápido e com design elegante para o uso diário.">
                            <img src="./img/pendrive.png" alt="Pendrive Exemplo" id="pendrive">
                            <h3>Pen Drive 64GB Kingston DataTraveler Exodia Onyx</h3>
                            <p class="product-category">Pen Drive</p>
                            <div class="product-price"><span>R$ 49,99</span></div>
                            <button class="btn-secondary">Adicionar ao Carrinho</button>
                        </article>

                        <article class="carrossel-item" data-description="Liberte-se dos fios com o mouse gamer Logitech G305. A tecnologia sem fio LIGHTSPEED oferece uma resposta de 1ms, e o sensor HERO de 12.000 DPI garante precisão impecável.">
                            <img src="./img/mouselogi.png" alt="Mouse Gamer Exemplo" id="mouse">
                            <h3>Mouse Gamer Sem Fio Logitech G305 LIGHTSPEED, 12000 DPI</h3>
                            <p class="product-category">Periféricos</p>
                            <div class="product-price"><span>R$ 349,90</span></div>
                            <button class="btn-secondary">Adicionar ao Carrinho</button>
                        </article>

                        <article class="carrossel-item" data-description="Compacto e poderoso, este teclado mecânico TKL (Tenkeyless) sem fio oferece a resposta tátil que os gamers amam, em um formato que economiza espaço na sua mesa.">
                            <img src="./img/tecladotkl.png" alt="Teclado Mecânico Exemplo" id="teclado">
                            <h3>Teclado Mecânico TKL sem fio</h3>
                            <p class="product-category">Periféricos</p>
                            <div class="product-price"><span>R$ 1.399,90</span></div>
                            <button class="btn-secondary">Adicionar ao Carrinho</button>
                        </article>

                        <article class="carrossel-item" data-description="Ouça cada passo do seu inimigo com o Headset Gamer Redragon. A tecnologia de som surround 7.1 proporciona uma imersão total e áudio posicional preciso para seus jogos.">
                            <img src="./img/headset.png" alt="Headset Gamer Exemplo" id="headset">
                            <h3>Headset Gamer Redragon 7.1 Surround</h3>
                            <p class="product-category">Áudio</p>
                            <div class="product-price"><span>R$ 599,90</span></div>
                            <button class="btn-secondary">Adicionar ao Carrinho</button>
                        </article>

                    </div>
                </div>
                <button class="btn-carrossel direita" onclick="scrollCarrossel(1, 'carrossel-acessorios')">❯</button>
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

                        <article class="carrossel-item" data-description="Este PC Gamer é uma máquina de performance. Equipado com um AMD Ryzen 5 e uma RTX 4060 Ti, ele está pronto para rodar os últimos lançamentos com altas taxas de quadros e qualidade gráfica.">
                            <img src="./img/pcgamer1.png" alt="PC Gamer Pichau Ryzen 5" id="pcgamer1">
                            <h3>PC Gamer Pichau Jotunheim, AMD Ryzen 5 5600, GeForce RTX 4060 TI 8GB, 16GB DDR4, SSD M.2 480GB</h3>
                            <p class="product-category">Computadores</p>
                            <div class="product-price"><span>R$ 5.499,00</span></div>
                            <button class="btn-secondary">Adicionar ao Carrinho</button>
                        </article>

                        <article class="carrossel-item" data-description="Uma excelente porta de entrada para o mundo dos jogos. Com um processador Intel i5 e uma placa de vídeo Radeon RX 7600, este PC oferece um ótimo custo-benefício para jogar em Full HD.">
                            <img src="./img/pcgamer2.png" alt="PC Gamer Intel i5" id="pcgamer2">
                            <h3>PC Gamer Pichau, Intel i5-12400F, Radeon RX 7600 8GB, 16GB DDR4, SSD 480GB</h3>
                            <p class="product-category">Computadores</p>
                            <div class="product-price"><span>R$ 4.099,99</span></div>
                            <button class="btn-secondary">Adicionar ao Carrinho</button>
                        </article>

                        <article class="carrossel-item" data-description="Performance e estilo se encontram neste PC. O poderoso Ryzen 7 5700X combinado com a RTX 4060 Ti e um SSD de 1TB garantem velocidade tanto para jogos quanto para produtividade.">
                            <img src="./img/pcgamer3.png" alt="PC Gamer AMD Ryzen 7" id="pcgamer3">
                            <h3>PC Gamer Pichau Afrodite, AMD Ryzen 7 5700X, GeForce RTX 4060 Ti 8GB, 16GB DDR4, SSD 1TB</h3>
                            <p class="product-category">Computadores</p>
                            <div class="product-price"><span>R$ 6.299,90</span></div>
                            <button class="btn-secondary">Adicionar ao Carrinho</button>
                        </article>

                        <article class="carrossel-item" data-description="Eleve sua experiência de jogo a um novo patamar. Este computador conta com um Intel i7, a poderosa RTX 4070 Super e memória DDR5 para performance extrema em jogos e aplicações profissionais.">
                            <img src="./img/pcgamer4.png" alt="PC Gamer Intel i7" id="pcgamer4">
                            <h3>PC Gamer Pichau Fuzhu XIII, Intel i7-12700F, GeForce RTX 4070 Super 12GB, 16GB DDR5, SSD M.2 1TB</h3>
                            <p class="product-category">Computadores</p>
                            <div class="product-price"><span>R$ 8.699,99</span></div>
                            <button class="btn-secondary">Adicionar ao Carrinho</button>
                        </article>

                        <article class="carrossel-item" data-description="Para quem não aceita nada menos que o máximo. Com um AMD Ryzen 9, a futura RTX 5080, 32GB de RAM e um SSD de 2TB, este é o PC definitivo para entusiastas que buscam poder de fogo absoluto.">
                            <img src="./img/pcgamer5.png" alt="PC Gamer AMD Ryzen 9" id="pcgamer5">
                            <h3>PC Gamer Pichau Highflyer, AMD Ryzen 9 5900XT, GeForce RTX 5080 16GB, 32GB DDR4, SSD M.2 2TB</h3>
                            <p class="product-category">Computadores</p>
                            <div class="product-price"><span>R$ 17.599,99</span></div>
                            <button class="btn-secondary">Adicionar ao Carrinho</button>
                        </article>

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

                        <article class="carrossel-item" data-description="A Fonte TGT Tomahawk 500W oferece potência estável e confiável para o seu setup. Com design robusto e eficiência energética, é ideal para quem busca desempenho com bom custo-benefício.">
                            <img src="./img/fonte1.png" alt="Fonte 500w" id="fonte1">
                            <h3>Fonte TGT Tomahawk 500W Preto, TMWK500</h3>
                            <p class="product-category">Fontes</p>
                            <div class="product-price"><span>R$159,90</span></div>
                            <button class="btn-secondary">Adicionar ao Carrinho</button>
                        </article>

                        <article class="carrossel-item" data-description="Compacta e eficiente, a Fonte Aerocool KCAS 500W oferece desempenho estável para computadores de entrada e intermediários. Ideal para quem busca segurança e economia.">
                            <img src="./img/fonte2.png" alt="Fonte Aerocool KCAS 500W" id="fonte2">
                            <h3>Fonte Aerocool KCAS 500W, 80 Plus Bronze, PFC Ativo</h3>
                            <p class="product-category">Fontes</p>
                            <div class="product-price"><span>R$ 229,90</span></div>
                            <button class="btn-secondary">Adicionar ao Carrinho</button>
                        </article>

                        <article class="carrossel-item" data-description="A Corsair CV550 entrega 550W de potência real com certificação 80 Plus Bronze. Confiabilidade e baixo ruído para setups gamers e de produtividade.">
                            <img src="./img/fonte3.png" alt="Fonte Corsair CV550" id="fonte3">
                            <h3>Fonte Corsair CV550, 550W, 80 Plus Bronze, PFC Ativo</h3>
                            <p class="product-category">Fontes</p>
                            <div class="product-price"><span>R$ 319,90</span></div>
                            <button class="btn-secondary">Adicionar ao Carrinho</button>
                        </article>

                        <article class="carrossel-item" data-description="Robusta e eficiente, a Fonte Redragon RGPS 600W é perfeita para gamers exigentes. Com certificação 80 Plus Bronze e cabos organizados, garante potência com estilo.">
                            <img src="./img/fonte4.png" alt="Fonte Redragon RGPS 600W" id="fonte4">
                            <h3>Fonte Redragon RGPS 600W, 80 Plus Bronze, PFC Ativo</h3>
                            <p class="product-category">Fontes</p>
                            <div class="product-price"><span>R$ 359,90</span></div>
                            <button class="btn-secondary">Adicionar ao Carrinho</button>
                        </article>

                        <article class="carrossel-item" data-description="Para quem precisa de energia confiável em configurações mais exigentes, a Fonte EVGA 700W White oferece alta potência com excelente custo-benefício.">
                            <img src="./img/fonte5.png" alt="Fonte EVGA 700W" id="fonte5">
                            <h3>Fonte EVGA 700W White, 80 Plus White, PFC Ativo</h3>
                            <p class="product-category">Fontes</p>
                            <div class="product-price"><span>R$ 419,90</span></div>
                            <button class="btn-secondary">Adicionar ao Carrinho</button>
                        </article>


                    </div>
                </div>
                <button class="btn-carrossel direita" onclick="scrollCarrossel(1, 'carrossel-fontes')">❯</button>
            </div>
        </div>
    </section>

    <div id="productModal" class="modal-overlay">
        <div class="modal-content">
            <button class="close-modal" aria-label="Fechar modal">&times;</button>
            <img src="" alt="Imagem do Produto" id="modal-img">
            <h3 id="modal-title">Nome do Produto</h3>
            <p class="product-category" id="modal-category">Categoria</p>
            <div class="product-price" id="modal-price">R$ 0,00</div>
            <p id="modal-description">
                Aqui você pode adicionar uma descrição mais detalhada do produto, especificações técnicas, ou qualquer outra informação relevante que não cabe no card principal.
            </p>
            <button class="btn-secondary">Adicionar ao Carrinho</button>
        </div>
    </div>
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

            const modal = document.getElementById('productModal');
            const closeModalButton = document.querySelector('.close-modal');
            const allProducts = document.querySelectorAll('.carrossel-item');

            function openModal(product) {
                const imgSrc = product.querySelector('img').src;
                const title = product.querySelector('h3').innerText;
                const category = product.querySelector('.product-category').innerText;
                const price = product.querySelector('.product-price').innerHTML;
                const description = product.dataset.description || "Descrição detalhada não disponível para este produto.";

                document.getElementById('modal-img').src = imgSrc;
                document.getElementById('modal-title').innerText = title;
                document.getElementById('modal-category').innerText = category;
                document.getElementById('modal-price').innerHTML = price;
                document.getElementById('modal-description').innerText = description;

                modal.classList.add('active');
            }

            allProducts.forEach(product => {
                product.addEventListener('click', function(event) {
                    if (event.target.closest('.btn-secondary')) {
                        return;
                    }
                    openModal(this);
                });
            });

            function closeModal() {
                modal.classList.remove('active');
            }

            closeModalButton.addEventListener('click', closeModal);

            modal.addEventListener('click', function(event) {
                if (event.target === modal) {
                    closeModal();
                }
            });

            const addToCartButtons = document.querySelectorAll('.btn-secondary');
            addToCartButtons.forEach(button => {
                button.addEventListener('click', function() {
                    alert('Produto adicionado ao carrinho! (Isso é uma demonstração)');
                    if (modal.classList.contains('active')) {
                        closeModal();
                    }
                });
            });
        });
    </script>

</body>

</html>