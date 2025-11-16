<?php
session_start();
include_once("config.php");

if (!empty($_GET['id'])) {

    $id = intval($_GET['id']);
    $sqlSelect = "SELECT * FROM usuarios WHERE id=$id";
    $result = $conexao->query($sqlSelect);

    if ($result && $result->num_rows > 0) {
        $user_data = mysqli_fetch_assoc($result);
    } else {
        header("Location: sistema.php");
        exit;
    }
} else {
    header("Location: sistema.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cliente</title>
    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Poppins, sans-serif;
        }

        body {
            background: #1e1e1e;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
            padding: 20px;
            overflow-y: auto;
        }

        h1 {
            color: #ffa500;
            margin-bottom: 15px;
            text-align: center;
        }

        a {
            color: #ff9900;
            text-decoration: none;
            font-weight: bold;
            margin-bottom: 20px;
            display: inline-block;
        }

        a:hover {
            color: #ffb347;
        }

        .container {
            background: #2e2e2e;
            border: 2px solid #ff9900;
            border-radius: 10px;
            padding: 20px 30px;
            width: 100%;
            max-width: 900px;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        label {
            font-weight: bold;
            color: #ffa500;
            margin-bottom: 5px;
            display: block;
        }

        input,
        select {
            padding: 8px 10px;
            border-radius: 5px;
            border: 1px solid #ff9900;
            background: #3a3a3a;
            color: #fff;
            outline: none;
            width: 100%;
        }

        input:focus,
        select:focus {
            border-color: #ffb347;
        }

        .btn-container {
            grid-column: span 2;
            display: flex;
            justify-content: center;
            margin-top: 10px;
        }

        button {
            padding: 10px 20px;
            background: #ff9900;
            border: none;
            border-radius: 5px;
            color: #1e1e1e;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: #ffb347;
        }

        @media(max-width:700px) {
            .container {
                grid-template-columns: 1fr;
                max-width: 90%;
            }

            .btn-container {
                grid-column: span 1;
            }
        }
    </style>
</head>

<body>
    <div>
        <h1>Editar Cliente</h1>
        <a href="sistema.php">VOLTAR</a>
        <form class="container" method="POST" action="atualizar_cliente.php">

            <input type="hidden" name="id" value="<?php echo $user_data['id']; ?>">

            <div>
                <label>Nome</label>
                <input type="text" name="nome" value="<?php echo htmlspecialchars($user_data['nome']); ?>" required>
            </div>

            <div>
                <label>CPF</label>
                <input type="text" name="cpf" value="<?php echo htmlspecialchars($user_data['cpf']); ?>" required>
            </div>

            <div>
                <label>Email</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($user_data['email']); ?>" required>
            </div>

            <div>
                <label>Telefone</label>
                <input type="text" name="telefone" value="<?php echo htmlspecialchars($user_data['telefone']); ?>">
            </div>

            <div>
                <label>Endereço</label>
                <input type="text" name="endereco" value="<?php echo htmlspecialchars($user_data['endereco']); ?>">
            </div>

            <div>
                <label>Data de Nascimento</label>
                <input type="date" name="data_nascimento" value="<?php echo $user_data['data_nascimento']; ?>">
            </div>

            <div>
                <label>Sexo</label>
                <select name="sexo">
                    <option value="Masculino" <?php if ($user_data['sexo'] == "Masculino") echo "selected"; ?>>Masculino</option>
                    <option value="Feminino" <?php if ($user_data['sexo'] == "Feminino") echo "selected"; ?>>Feminino</option>
                </select>
            </div>

            <div>
                <label>CEP</label>
                <input type="text" name="cep" value="<?php echo htmlspecialchars($user_data['cep']); ?>">
            </div>

            <div>
                <label>Login</label>
                <input type="text" name="login" value="<?php echo htmlspecialchars($user_data['login']); ?>" required>
            </div>

            <div>
                <label>Nova Senha (deixe em branco para não alterar)</label>
                <input type="password" name="senha" placeholder="Digite uma nova senha se desejar">
            </div>

            <div>
                <label>Nome da Mãe</label>
                <input type="text" name="nome_mae" value="<?php echo htmlspecialchars($user_data['nome_mae']); ?>">
            </div>

            <div class="btn-container">
                <button type="submit" name="update" id="update">Atualizar</button>
            </div>
        </form>
    </div>
</body>

</html>
