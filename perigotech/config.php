<?php
$dbHost = 'perigo-tech.cxk4sugqggtc.us-east-2.rds.amazonaws.com';
$dbPort = 3306;
$dbUsername = 'admin';
$dbPassword = 'P1rucomLeucem1a';
$dbName = 'perigotech';

$conexao = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName, $dbPort);


if ($conexao->connect_errno) {
     echo "Erro ao conectar: " . $conexao->connect_error;
     exit; 
} 
// else { 
//      header('Location: testeLogin.php');
//      exit;
// }
