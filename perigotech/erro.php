<?php
session_start();
$mensagem_erro = htmlspecialchars($_GET['msg'] ?? 'Ocorreu um erro inesperado no sistema.');
$link_retorno = htmlspecialchars($_GET['back'] ?? 'login.php');
$texto_botao = htmlspecialchars($_GET['txt'] ?? 'Voltar à Tela de Login');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erro! - Perigo Tech</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body { font-family: Arial, sans-serif; background-color: #1a1a1a; color: white; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .error-container { 
            background: #2b2b2b; 
            padding: 40px; 
            border-radius: 10px; 
            border: 2px solid #ff7300;
            box-shadow: 0 0 20px rgba(255, 77, 77, 0.3); 
            text-align: center;
            max-width: 450px;
        }
        .error-container i { 
            color: #ff7300; 
            font-size: 3rem; 
            margin-bottom: 20px; 
        }
        .error-container h1 { 
            color: #ff7300; 
            font-size: 1.8rem; 
            margin-bottom: 10px; 
        }
        .error-message { 
            color: #ccc; 
            font-size: 1.1rem; 
            margin-bottom: 30px; 
        }
        .error-container a { 
            display: inline-block;
            background-color: #ff7300; 
            color: white; 
            padding: 10px 20px; 
            text-decoration: none; 
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .error-container a:hover {
            background-color: #994907ff;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <i class="fas fa-exclamation-triangle"></i>
        <h1>ERRO!</h1>
        <p class="error-message"><?php echo $mensagem_erro; ?></p>
        
        <a href="<?php echo $link_retorno; ?>"><?php echo $texto_botao; ?></a>
    </div>
</body>
</html>