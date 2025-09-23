CREATE DATABASE perigotech;
USE perigotech;



CREATE TABLE produtos (
    id_prod INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    categoria VARCHAR(100) NOT NULL,
    descricao TEXT NOT NULL,
    preco DECIMAL(10,2) NOT NULL,
    img VARCHAR(255) NOT NULL
);



INSERT INTO produtos (nome, categoria, descricao, preco, img) VALUES
('Placa de Vídeo RTX 5080','Placas de Vídeo', 'A nova RTX 5080 oferece um salto de performance geracional com a arquitetura de última geração da NVIDIA. Ideal para jogos em 4K com Ray Tracing no máximo e para criadores de conteúdo que exigem velocidade.', 7999.90, 'rtx_5080.png'),
('Processador Core i9 15900K', 'Processadores', 'O processador Core i9 15900K é a escolha definitiva para entusiastas e gamers que buscam o máximo de desempenho. Com seus múltiplos núcleos e altas frequências, ele encara qualquer tarefa pesada sem dificuldades.', 3899.90, 'i9.webp'),
('SSD NVMe 2TB SuperSpeed', 'Armazenamento', 'Elimine as telas de carregamento com o SSD NVMe de 2TB. Com velocidades de leitura e escrita ultrarrápidas, seus jogos e programas carregarão em um piscar de olhos.', 1199.90, 'ssd_nvme.png'),
('Memória RAM DDR5 32GB (2x16)', 'Memória RAM', 'Este kit de 32GB (2x16GB) de memória RAM DDR5 é perfeito para multitarefa e jogos de alta performance. A tecnologia DDR5 garante maior largura de banda e eficiência para o seu sistema.', 899.90, 'memoria_ram.png'),
('Monitor Gamer Husky Storm 27'' LED, Curvo, 180Hz, Full HD, 1ms', 'Monitor', 'Mergulhe na ação com o monitor gamer curvo Husky Storm de 27 polegadas. Com 180Hz de taxa de atualização e 1ms de tempo de resposta, você terá a vantagem competitiva que precisa.', 959.90, 'monitor180hz.png'),
('Microfone Dinâmico Gamer Fifine Ampligame, RGB, Cardióide, USB-C', 'Microfones', 'Capture sua voz com clareza cristalina usando o microfone Fifine Ampligame. Seu padrão cardióide foca na sua voz, reduzindo ruídos de fundo, e a iluminação RGB adiciona estilo ao seu setup.', 279.99, 'microfone.png'),
('Pen Drive 64GB Kingston DataTraveler Exodia Onyx', 'Pen Drive', 'Leve seus arquivos para qualquer lugar com o Pen Drive Kingston DataTraveler de 64GB. Confiável, rápido e com design elegante para o uso diário.', 49.99, 'pendrive.png'),
('Mouse Gamer Sem Fio Logitech G305 LIGHTSPEED, 12000 DPI', 'Periféricos', 'Liberte-se dos fios com o mouse gamer Logitech G305. A tecnologia sem fio LIGHTSPEED oferece uma resposta de 1ms, e o sensor HERO de 12.000 DPI garante precisão impecável.', 349.90, 'mouselogi.png'),
('Teclado Mecânico TKL sem fio', 'Periféricos', 'Compacto e poderoso, este teclado mecânico TKL (Tenkeyless) sem fio oferece a resposta tátil que os gamers amam, em um formato que economiza espaço na sua mesa.', 1399.90, 'tecladotkl.png'),
('Headset Gamer Redragon 7.1 Surround', 'Áudio', 'Ouça cada passo do seu inimigo com o Headset Gamer Redragon. A tecnologia de som surround 7.1 proporciona uma imersão total e áudio posicional preciso para seus jogos.', 599.90, 'headset.png'),
('PC Gamer Pichau Jotunheim, AMD Ryzen 5 5600, GeForce RTX 4060 TI 8GB, 16GB DDR4, SSD M.2 480GB', 'Computadores', 'Este PC Gamer é uma máquina de performance. Equipado com um AMD Ryzen 5 e uma RTX 4060 Ti, ele está pronto para rodar os últimos lançamentos com altas taxas de quadros e qualidade gráfica.', 5499.00, 'pcgamer1.png'),
('PC Gamer Pichau, Intel i5-12400F, Radeon RX 7600 8GB, 16GB DDR4, SSD 480GB', 'Computadores', 'Uma excelente porta de entrada para o mundo dos jogos. Com um processador Intel i5 e uma placa de vídeo Radeon RX 7600, este PC oferece um ótimo custo-benefício para jogar em Full HD.', 4099.99, 'pcgamer2.png'),
('PC Gamer Pichau Afrodite, AMD Ryzen 7 5700X, GeForce RTX 4060 Ti 8GB, 16GB DDR4, SSD 1TB', 'Computadores', 'Performance e estilo se encontram neste PC. O poderoso Ryzen 7 5700X combinado com a RTX 4060 Ti e um SSD de 1TB garantem velocidade tanto para jogos quanto para produtividade.', 6299.90, 'pcgamer3.png'),
('PC Gamer Pichau Fuzhu XIII, Intel i7-12700F, GeForce RTX 4070 Super 12GB, 16GB DDR5, SSD M.2 1TB', 'Computadores', 'Eleve sua experiência de jogo a um novo patamar. Este computador conta com um Intel i7, a poderosa RTX 4070 Super e memória DDR5 para performance extrema em jogos e aplicações profissionais.', 8699.99, 'pcgamer4.png'),
('PC Gamer Pichau Highflyer, AMD Ryzen 9 5900XT, GeForce RTX 5080 16GB, 32GB DDR4, SSD M.2 2TB', 'Computadores', 'Para quem não aceita nada menos que o máximo. Com um AMD Ryzen 9, a futura RTX 5080, 32GB de RAM e um SSD de 2TB, este é o PC definitivo para entusiastas que buscam poder de fogo absoluto.', 17599.99, 'pcgamer5.png'),
('Fonte TGT Tomahawk 500W Preto, TMWK500', 'Fontes', 'A Fonte TGT Tomahawk 500W oferece potência estável e confiável para o seu setup. Com design robusto e eficiência energética, é ideal para quem busca desempenho com bom custo-benefício.', 159.90, 'fonte1.png'),
('Fonte Aerocool KCAS 500W, 80 Plus Bronze, PFC Ativo', 'Fontes', 'Compacta e eficiente, a Fonte Aerocool KCAS 500W oferece desempenho estável para computadores de entrada e intermediários. Ideal para quem busca segurança e economia.', 229.90, 'fonte2.png'),
('Fonte Corsair CV550, 550W, 80 Plus Bronze, PFC Ativo', 'Fontes', 'A Corsair CV550 entrega 550W de potência real com certificação 80 Plus Bronze. Confiabilidade e baixo ruído para setups gamers e de produtividade.', 319.90, 'fonte3.png'),
('Fonte Redragon RGPS 600W, 80 Plus Bronze, PFC Ativo', 'Fontes', 'Robusta e eficiente, a Fonte Redragon RGPS 600W é perfeita para gamers exigentes. Com certificação 80 Plus Bronze e cabos organizados, garante potência com estilo.', 359.90, 'fonte4.png'),
('Fonte EVGA 700W White, 80 Plus White, PFC Ativo', 'Fontes', 'Para quem precisa de energia confiável em configurações mais exigentes, a Fonte EVGA 700W White oferece alta potência com excelente custo-benefício.', 419.90, 'fonte5.png');
);