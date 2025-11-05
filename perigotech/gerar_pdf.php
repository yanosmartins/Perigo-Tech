<?php
require('fpdf.php'); // Inclui o FPDF
include_once('config.php');

// Cria PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->SetTextColor(255, 159, 28);
$pdf->Cell(0,10,'Logs de Autenticacao - Master',0,1,'C');
$pdf->Ln(5);

// Cabeçalho da tabela
$pdf->SetFont('Arial','B',12);
$pdf->SetFillColor(0,0,0);
$pdf->SetTextColor(255,159,28);
$pdf->Cell(50,10,'Data / Hora',1,0,'C',true);
$pdf->Cell(50,10,'Nome',1,0,'C',true);
$pdf->Cell(40,10,'CPF',1,0,'C',true);
$pdf->Cell(40,10,'2FA',1,1,'C',true);

$pdf->SetFont('Arial','',12);
$pdf->SetFillColor(18,18,18);
$pdf->SetTextColor(255,255,255);

$fill = false;
$lineHeight = 6; 

$sql = "SELECT data_login, usuario_nome, usuario_cpf, segundo_fator FROM auth_logs ORDER BY data_login DESC";
$res = $conexao->query($sql);

if($res && $res->num_rows > 0){
    while($row = $res->fetch_assoc()){
        // Correção de alguns bugs de texto
        $dataLogin = utf8_decode($row['data_login']);
        $nome      = utf8_decode($row['usuario_nome']);
        $cpf       = utf8_decode($row['usuario_cpf']);
        $segundoF  = utf8_decode($row['segundo_fator']);

    
        $textWidth = 40; 
        $nbLines = ceil($pdf->GetStringWidth($segundoF)/$textWidth);
        if($nbLines < 1) $nbLines = 1;
        $h = $lineHeight * $nbLines;

        
        $pdf->Cell(50,$h,$dataLogin,1,0,'C',$fill);
        $pdf->Cell(50,$h,$nome,1,0,'C',$fill);
        $pdf->Cell(40,$h,$cpf,1,0,'C',$fill);

   
        $x = $pdf->GetX();
        $y = $pdf->GetY();

        
        $pdf->MultiCell(40,$lineHeight,$segundoF,1,'C',$fill);

        // Ajusta posição para a próxima linha
        $pdf->SetXY($x + 40, $y);
        $pdf->Ln($h);

        $fill = !$fill;
    }
}else{
    $pdf->Cell(180,10,'Nenhum registro encontrado.',1,1,'C',$fill);
}

// Faz o download do PDF
$pdf->Output('D','logs_master.pdf');
exit;
?>
