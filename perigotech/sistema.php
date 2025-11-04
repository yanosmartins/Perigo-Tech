<?php
session_start();
include_once('config.php');

$admin_users = ['admin', 'master'];
if (!isset($_SESSION['login']) || empty($_SESSION['login'])) {
    unset($_SESSION['login']);
    header('Location: login.php');
    exit();
}
if (!in_array($_SESSION['login'], $admin_users)) {
    header('Location: loja.php');
    exit();
}
$usuario = htmlspecialchars($_SESSION['login'], ENT_QUOTES, 'UTF-8');

$sql = "SELECT * FROM cadastro_tech";
$result = $conexao->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
<title>Sistema</title>
<style>
    
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }

    html, body {
        width: 100%;
        height: 100%;
    }

    body {
        background-color: #1e1e1e;
        color: #fff;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        align-items: center;
        padding: 10px;
        overflow: auto;
    }

    h1 {
        color: #ffa500;
        margin-bottom: 5px;
    }

    p {
        margin-bottom: 10px;
        font-size: 1.1rem;
    }

    a {
        color: #ff9900;
        text-decoration: none;
        font-weight: bold;
        transition: 0.3s;
    }

    a:hover {
        color: #ffb347;
    }

    
    .container {
        flex: 1;
        width: 60%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    table {
        width: 100%;
        height: 100%;
        border-collapse: collapse;
        background-color: #2e2e2e;
        border: 2px solid #ff9900;
    }

    table thead tr {
        background-color: #ff9900;
        color: #1e1e1e;
    }

    table th, table td {
        padding: 10px;
        text-align: center;
        border: 1px solid #ffa500;
        word-wrap: break-word;
    }

    table tbody tr:nth-child(even) {
        background-color: #3a3a3a;
    }

    table tbody tr:hover {
        background-color: #ffb347;
        color: #1e1e1e;
    }

    table td strong {
        color: #ffa500;
    }

    
    table tbody {
        height: calc(100% - 40px); 
    }

</style>
</head>
<body>
    <h1>Bem-vindo ao Sistema</h1>
    <p>Olá, <?php echo $usuario; ?>! Você está logado no sistema.</p>
    <p><a href="logout.php">Sair</a></p>
    <p><a href="loja.php">Voltar</a></p>

    <div class="container">
        <table>
            <thead>
                <tr>
                    <th>idusuarios</th>
                    <th>nome</th>
                    <th>cpf</th>
                    <th>email</th>
                    <th>telefone</th>
                    <th>endereco</th>
                    <th>data_nasc</th>
                    <th>sexo</th>
                    <th>cep</th>
                    <th>login</th>
                    <th>senha</th>
                    <th>nome_mae</th>
                    <th>Editar</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while($user_data = mysqli_fetch_assoc($result)){
                    echo "<tr>";
                    echo "<td>".$user_data['idusuarios']."</td>";
                    echo "<td>".$user_data['nome']."</td>";
                    echo "<td>".$user_data['cpf']."</td>";
                    echo "<td>".$user_data['email']."</td>";
                    echo "<td>".$user_data['telefone']."</td>";
                    echo "<td>".$user_data['endereco']."</td>";
                    echo "<td>".$user_data['data_nasc']."</td>";
                    echo "<td>".$user_data['sexo']."</td>";
                    echo "<td>".$user_data['cep']."</td>";
                    echo "<td>".$user_data['login']."</td>";
                    echo "<td>".$user_data['senha']."</td>";
                    echo "<td>".$user_data['nome_mae']."</td>";
                    echo "<td>
                        <a class='btn btn-sm btn-primary' href='edit.php?idusuarios=".$user_data['idusuarios']."'>
                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil-fill' viewBox='0 0 16 16'>
                                <path d='M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.5.5 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11z'/>
                            </svg>
                        </a>
                        <a class='btn btn-sm btn-danger' href='delete.php?idusuarios=".$user_data['idusuarios']."' onclick=\"return confirm('Tem certeza que deseja excluir este usuário?');\">
                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash-fill' viewBox='0 0 16 16'>
                                <path d='M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0'/>
                            </svg>
                        </a>
                        </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
