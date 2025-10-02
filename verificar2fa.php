<?php
session_start();
include "config.php";

$data = json_decode(file_get_contents("php://input"), true);

$pergunta = $data["pergunta"];
$resposta = trim($data["resposta"]);
$email = $data["email"];

$response = ["sucesso" => false];

// Busca o usuário no banco
$sql = "SELECT * FROM usuarios WHERE email = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $usuario = $result->fetch_assoc();

    switch ($pergunta) {
        case "mae":
            if (strcasecmp($usuario["nome_mae"], $resposta) == 0) {
                $response["sucesso"] = true;
            }
            break;

        case "nascimento":
            if ($usuario["data_nasc"] == $resposta) {
                $response["sucesso"] = true;
            }
            break;

        case "cep":
            if ($usuario["cep"] == $resposta) {
                $response["sucesso"] = true;
            }
            break;
    }
}

header("Content-Type: application/json");
echo json_encode($response);
