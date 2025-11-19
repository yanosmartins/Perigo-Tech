<?php
$dbHost = 'perigo-tech.cxk4sugqggtc.us-east-2.rds.amazonaws.com';
$dbPort = 3306;
$dbUsername = 'admin';
$dbPassword = 'P1rucomLeucem1a';
$dbName = 'perigotech';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conexao = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName, $dbPort);
    
} catch (Exception $e) {

    $msg_erro = "Falha crítica de conexão com o banco de dados. Tente novamente mais tarde.";
    header('Location: erro.php?msg=' . urlencode($msg_erro));
    exit;
}
?>
