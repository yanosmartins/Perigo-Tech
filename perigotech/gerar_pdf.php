<?php
require('fpdf.php');
include_once('config.php');

// Detectar conexão
if (isset($conn) && $conn instanceof mysqli) {
    $db = $conn;
} elseif (isset($conexao) && $conexao instanceof mysqli) {
    $db = $conexao;
} else {
    die("Erro: conexão com o banco não encontrada.");
}

// Truncar texto para não estourar a coluna
function truncateText($pdf, $text, $width) {
    $text = utf8_decode($text);
    $maxWidth = $width - 3;

    if ($pdf->GetStringWidth($text) <= $maxWidth) {
        return $text;
    }

    $ellipsis = "...";
    $ellipsisWidth = $pdf->GetStringWidth($ellipsis);
    $result = "";

    for ($i = 0; $i < strlen($text); $i++) {
        $result .= $text[$i];
        if ($pdf->GetStringWidth($result) + $ellipsisWidth > $maxWidth) {
            return substr($result, 0, -1) . $ellipsis;
        }
    }

    return $result;
}

// Cabeçalho da tabela
function print_table_header($pdf, $w1, $w2, $w3, $w4) {
    $pdf->SetFont('Arial','B',12);
    $pdf->SetFillColor(0,0,0);
    $pdf->SetTextColor(255,159,28);

    $pdf->Cell($w1, 10, 'Data / Hora', 1, 0, 'C', true);
    $pdf->Cell($w2, 10, 'Nome', 1, 0, 'C', true);
    $pdf->Cell($w3, 10, 'CPF', 1, 0, 'C', true);
    $pdf->Cell($w4, 10, '2FA', 1, 1, 'C', true);

    $pdf->SetFont('Arial','',11);
}

// ---------------- INÍCIO DO PDF ----------------
$pdf = new FPDF('P','mm','A4');
$pdf->AddPage();
$pdf->SetAutoPageBreak(true, 15);

$pdf->SetFont('Arial','B',16);
$pdf->SetTextColor(255,159,28);
$pdf->Cell(0,10,'Logs de Autenticacao - Master',0,1,'C');
$pdf->Ln(3);

// Largura das colunas
$w1 = 50;
$w2 = 50;
$w3 = 40;
$w4 = 40;
$lineHeight = 10;

print_table_header($pdf, $w1, $w2, $w3, $w4);

// Query
$sql = "SELECT data_login, usuario_nome, usuario_cpf, segundo_fator 
        FROM auth_logs ORDER BY data_login DESC";

$res = $db->query($sql);

if (!$res) {
    die("Erro SQL: " . $db->error);
}

$zebra = false;
$rowCount = 0;

while ($row = $res->fetch_assoc()) {
    $rowCount++;

    $dataLogin = utf8_decode($row['data_login']);
    $nome      = utf8_decode($row['usuario_nome']);
    $cpf       = utf8_decode($row['usuario_cpf']);
    $segundoF  = truncateText($pdf, $row['segundo_fator'], $w4);

    // ZEBRA AJUSTADA
    if ($zebra) {
        $pdf->SetFillColor(255,255,255); // fundo branco
        $pdf->SetTextColor(0,0,0); // texto preto
    } else {
        $pdf->SetFillColor(0,0,0); // fundo preto
        $pdf->SetTextColor(255,255,255); // texto branco
    }

    // Quebra de página segura
    if ($pdf->GetY() + $lineHeight > $pdf->GetPageHeight() - 15) {
        $pdf->AddPage();
        print_table_header($pdf, $w1, $w2, $w3, $w4);
    }

    // Imprime linha
    $pdf->Cell($w1, $lineHeight, $dataLogin, 1, 0, 'C', true);
    $pdf->Cell($w2, $lineHeight, $nome,      1, 0, 'C', true);
    $pdf->Cell($w3, $lineHeight, $cpf,       1, 0, 'C', true);
    $pdf->Cell($w4, $lineHeight, $segundoF,  1, 1, 'C', true);

    // Alterna zebra
    $zebra = !$zebra;
}

// Caso sem registros
if ($rowCount === 0) {
    $pdf->Cell($w1+$w2+$w3+$w4, 10, 'Nenhum registro encontrado.', 1, 1, 'C');
}

$pdf->Output('D','logs_master.pdf');
exit;
?>
