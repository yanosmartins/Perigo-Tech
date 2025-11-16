<?php
include_once 'config.php';

if (isset($_POST['update'])) {

    $id = intval($_POST['id']);
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $endereco = $_POST['endereco'];
    $login = $_POST['login'];
    $senha_plana = $_POST['senha'];
    $nome_mae = $_POST['nome_mae'];
    $cep = $_POST['cep'];
    $cpf = $_POST['cpf'];
    $data_nascimento = $_POST['data_nascimento'];
    $sexo = $_POST['sexo'];

    if (!empty($senha_plana)) {
        $senha_hash = password_hash($senha_plana, PASSWORD_DEFAULT);
        $sql = "UPDATE usuarios 
                SET nome=?, email=?, telefone=?, endereco=?, login=?, senha=?, 
                    nome_mae=?, cep=?, cpf=?, data_nascimento=?, sexo=?
                WHERE id=?";

        $stmt = $conexao->prepare($sql);
        $stmt->bind_param(
            'sssssssssssi',
            $nome,
            $email,
            $telefone,
            $endereco,
            $login,
            $senha_hash,
            $nome_mae,
            $cep,
            $cpf,
            $data_nascimento,
            $sexo,
            $id
        );
    } else {
        $sql = "UPDATE usuarios 
                SET nome=?, email=?, telefone=?, endereco=?, login=?, 
                    nome_mae=?, cep=?, cpf=?, data_nascimento=?, sexo=?
                WHERE id=?";

        $stmt = $conexao->prepare($sql);
        $stmt->bind_param(
            'ssssssssssi',
            $nome,
            $email,
            $telefone,
            $endereco,
            $login,
            $nome_mae,
            $cep,
            $cpf,
            $data_nascimento,
            $sexo,
            $id
        );
    }

    if ($stmt->execute()) {
        header("Location: sistema.php");
        exit;
    } else {
        echo "Erro ao atualizar: " . $stmt->error;
    }
} else {
    header("Location: sistema.php");
    exit;
}
