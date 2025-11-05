<?php
session_start();
include_once('config.php');


if (!isset($_SESSION['login']) || $_SESSION['login'] !== 'admin') {
    header('Location: login.php');
    exit();
}

$q = isset($_GET['q']) ? trim($_GET['q']) : '';
$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : 'todos';

$where = '';
$params = [];
$types = '';

if ($q !== '' && $tipo !== 'todos') {
    if ($tipo === 'nome') {
        $where = "WHERE usuario_nome LIKE ?";
        $params[] = "%{$q}%";
        $types .= 's';
    } elseif ($tipo === 'cpf') {
        $where = "WHERE usuario_cpf LIKE ?";
        $params[] = "%{$q}%";
        $types .= 's';
    }
}

$sql = "SELECT usuario_nome, usuario_cpf, segundo_fator, data_login FROM auth_logs " . $where . " ORDER BY data_login DESC";
$stmt = $conexao->prepare($sql);
if ($stmt) {
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $res = $stmt->get_result();
} else {
    $res = $conexao->query($sql);
}

$lines = [];
if ($res) {
    while ($row = $res->fetch_assoc()) {
        $lines[] = sprintf("%s | %s | %s | %s", $row['data_login'], $row['usuario_nome'], $row['usuario_cpf'], $row['segundo_fator']);
    }
}

function simple_pdf($lines, $title = 'Logs') {
    $content = "%PDF-1.4\n%âãÏÓ\n";
    $objects = [];

    $objects[] = "1 0 obj\n<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>\nendobj\n";
    $y = 750;
    $ops = "BT /F1 12 Tf 50 $y Td (" . addcslashes($title, '()\\') . ") Tj ET\n";
    $y -= 20;
    foreach ($lines as $ln) {
        $ops .= "BT /F1 10 Tf 50 $y Td (" . addcslashes($ln, '()\\') . ") Tj ET\n";
        $y -= 14;
        if ($y < 40) break;
    }
    $stream = $ops;
    $len = strlen($stream);

    $objects[] = "2 0 obj\n<< /Length $len >>\nstream\n$stream\nendstream\nendobj\n";

    $objects[] = "3 0 obj\n<< /Type /Page /Parent 4 0 R /Resources << /Font << /F1 1 0 R >> >> /MediaBox [0 0 612 792] /Contents 2 0 R >>\nendobj\n";

    $objects[] = "4 0 obj\n<< /Type /Pages /Kids [3 0 R] /Count 1 >>\nendobj\n";

    $objects[] = "5 0 obj\n<< /Type /Catalog /Pages 4 0 R >>\nendobj\n";

    $content .= implode('', $objects);

    $content .= "xref\n0 " . (count($objects)+1) . "\n0000000000 65535 f \n";
    $offset = strlen($content);
    for ($i=0;$i<count($objects);$i++) {
        $content .= sprintf("%010d 00000 n \n", $offset + 1);
    }
    $content .= "trailer\n<< /Size " . (count($objects)+1) . " /Root 5 0 R >>\nstartxref\n" . strlen($content) . "\n%%EOF";

    return $content;
}

$pdf = simple_pdf($lines, 'Logs de Autenticação');
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename=\"logs_auth.pdf\"');
echo $pdf;
exit();
?>