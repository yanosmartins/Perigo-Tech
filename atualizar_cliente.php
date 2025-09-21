<?php
include_once 'config.php';

if(isset($_POST['update'])) {    

    $idusuarios = intval($_POST['idusuarios']); 
    $nome = mysqli_real_escape_string($conexao, $_POST['nome']);
    $email = mysqli_real_escape_string($conexao, $_POST['email']);
    $telefone = mysqli_real_escape_string($conexao, $_POST['telefone']);
    $endereco = mysqli_real_escape_string($conexao, $_POST['endereco']);
    $login = mysqli_real_escape_string($conexao, $_POST['login']);
    $senha = mysqli_real_escape_string($conexao, $_POST['senha']);
    $nome_mae = mysqli_real_escape_string($conexao, $_POST['nome_mae']);
    $cep = mysqli_real_escape_string($conexao, $_POST['cep']);
    $cpf = mysqli_real_escape_string($conexao, $_POST['cpf']);
    $data_nasc = mysqli_real_escape_string($conexao, $_POST['data_nasc']);
    $sexo = mysqli_real_escape_string($conexao, $_POST['sexo']);

    $sqlupdate = "
        UPDATE cadastro_tech 
        SET nome='$nome',
            email='$email',
            telefone='$telefone',
            endereco='$endereco',
            login='$login',
            senha='$senha',
            nome_mae='$nome_mae',
            cep='$cep',
            cpf='$cpf',
            data_nasc='$data_nasc',
            sexo='$sexo'
        WHERE idusuarios='$idusuarios'
    ";

    $result = $conexao->query($sqlupdate);

    if($result) {
        header("Location: sistema.php");
        exit;
    } else {
        echo "Erro ao atualizar: " . $conexao->error;
    }
}
?>
