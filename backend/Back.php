<?php
header('Content-Type: application/json');

// Configurações do banco de Dados
$host = "localhost";
$user = "root";
$pass = "SUA_SENHA";
$dbname = "nome_do_banco";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    echo json_encode(["sucesso" => false, "erro" => "Erro de conexão com o banco"]);
    exit;
}

// Recebe dados via POST
$data = json_decode(file_get_contents("php://input"), true);
$pergunta = $conn->real_escape_string($data['pergunta'] ?? '');
$resposta = $conn->real_escape_string($data['resposta'] ?? '');
$email = $conn->real_escape_string($data['email'] ?? '');

if (!$pergunta || !$resposta || !$email) {
    echo json_encode(["sucesso" => false]);
    exit;
}

// Determina qual campo do banco usar
switch ($pergunta) {
    case 'mae':
        $campoDB = 'nome_mae';
        break;
    case 'nascimento':
        $campoDB = 'data_nascimento';
        break;
    case 'cep':
        $campoDB = 'cep';
        break;
    default:
        echo json_encode(["sucesso" => false]);
        exit;
}

// Consulta o usuário pelo email
$sql = "SELECT * FROM usuarios WHERE email='$email' LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows === 0) {
    echo json_encode(["sucesso" => false]);
    exit;
}

$usuario = $result->fetch_assoc();

// Verifica a resposta
$correta = false;
if ($pergunta === 'nascimento') {
    $correta = $usuario[$campoDB] === $resposta; // comparar data como 'AAAA-MM-DD'
} else {
    $correta = strtolower($usuario[$campoDB]) === strtolower($resposta);
}

echo json_encode(["sucesso" => $correta]);
$conn->close();
?>