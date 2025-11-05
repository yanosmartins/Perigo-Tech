<?php
require('fpdf.php'); // Inclui a biblioteca
include_once('config.php');

// Busca os logs do banco
$sql = "SELECT data_login, usuario_nome, usuario_cpf, segundo_fator FROM auth_logs ORDER BY data_login DESC";
$res = $conexao->query($sql);

// Cria o PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->SetTextColor(255, 159, 28); // laranja

$pdf->Cell(0,10,'Logs de Autenticacao - Master',0,1,'C');
$pdf->Ln(5);

// Cabeçalho da tabela
$pdf->SetFont('Arial','B',12);
$pdf->SetFillColor(0,0,0); // fundo preto
$pdf->SetTextColor(255,159,28); // laranja
$pdf->Cell(50,10,'Data / Hora',1,0,'C',true);
$pdf->Cell(50,10,'Nome',1,0,'C',true);
$pdf->Cell(40,10,'CPF',1,0,'C',true);
$pdf->Cell(40,10,'2FA',1,1,'C',true);


$pdf->SetFont('Arial','',12);
$pdf->SetFillColor(18,18,18); 
$pdf->SetTextColor(255,255,255); 

$fill = false;
if($res && $res->num_rows > 0){
    while($row = $res->fetch_assoc()){
        $pdf->Cell(50,10,$row['data_login'],1,0,'C',$fill);
        $pdf->Cell(50,10,$row['usuario_nome'],1,0,'C',$fill);
        $pdf->Cell(40,10,$row['usuario_cpf'],1,0,'C',$fill);
        $pdf->Cell(40,10,$row['segundo_fator'],1,1,'C',$fill);
        $fill = !$fill;
    }
} else {
    $pdf->Cell(180,10,'Nenhum registro encontrado.',1,1,'C',$fill);
}

// Faz o download do pdf
$pdf->Output('D','logs_master.pdf'); // Faz o Download Forçado
exit;
?>
