<?php
require_once "config.php";
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Modelo do Banco de Dados - PerigoTech</title>
    <style>
        body {
            background: #0a0a0a;
            color: #ff8c00;
            font-family: Consolas, monospace;
            padding: 30px;
            position: relative;
        }

        h1 {
            text-align: center;
            font-size: 32px;
            margin-bottom: 50px;
            color: #ffa733;
            
        }

        /* GRID atualizado */
        .grid {
            display: grid;
            grid-template-columns: repeat(3, 400px);
            gap: 25px;
            justify-content: center;
        }

        .box {
            background: #111;
            border: 2px solid #ff7b00;
            border-radius: 10px;
            padding: 20px;
            
            
        }

        .box:hover {
            transform: scale(1.03);
            
        }

        .title {
            text-align: center;
            font-size: 20px;
            color: #ffc37a;
            margin-bottom: 10px;
            font-weight: bold;
            
        }

        pre {
            font-size: 15px;
            white-space: pre;
            overflow-x: auto;
            color: #ffe4b3;
        }

        footer {
            text-align: center;
            margin-top: 40px;
            opacity: .6;
            font-size: 14px;
        }

        /* Responsivo */
        @media(max-width: 1300px) {
            .grid {
                grid-template-columns: repeat(2, 400px);
            }
        }

        @media(max-width: 900px) {
            .grid {
                grid-template-columns: 1fr;
            }
            .box {
                width: 90%;
                margin: auto;
            }
        }

        /* Botão Voltar */
        .back-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: #000;
            color: #ff9f1c;
            padding: 12px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            border: 2px solid #ff9f1c;
            transition: all 0.3s ease;
            
        }

        .back-btn:hover {
            background-color: #ff9f1c;
            color: #000;
            transform: scale(1.05);
            
        }
    </style>
</head>

<body>

<a href="loja.php" class="back-btn">⬅ Voltar</a>

<h1>Modelo do Banco de Dados - PerigoTech</h1>

<div class="grid">

    <!-- cadastro_tech -->
    <div class="box">
        <div class="title">Usuários</div>
<pre>
+---------------------------+
|      usuarios            |
+---------------------------+
| idusuarios (PK)          |
| nome                     |
| cpf                      |
| email                    |
| telefone                 |
| data_nasc                |
| endereco                 |
| sexo                     |
| cep                      |
| senha                    |
| login                    |
| nome_mae                 |
+---------------------------+
</pre>
    </div>

    <!-- produtos -->
    <div class="box">
        <div class="title">Produtos</div>
<pre>
+---------------------------+
|         produtos         |
+---------------------------+
| id_prod (PK)             |
| nomeprod                 |
| categorias               |
| descricao                |
| preco                    |
| img                      |
+---------------------------+
</pre>
    </div>

    <!-- auth_logs -->
    <div class="box">
        <div class="title">Auth_Logs</div>
<pre>
+---------------------------+
|        auth_logs         |
+---------------------------+
| id (PK)                  |
| usuario_nome             |
| usuario_cpf              |
| segundo_fator            |
| data_login               |
+---------------------------+
</pre>
    </div>

</div>

<footer>
PerigoTech © 2025 — Banco de Dados
</footer>

</body>
</html>


