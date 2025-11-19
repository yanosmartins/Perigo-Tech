<?php
session_start();
if(!empty($_GET['id'])) {
    include_once("config.php");

    $id = intval($_GET['id']); 
    
    try {
        
        $sqlDelete = "DELETE FROM usuarios WHERE id = ?";
        $stmt = $conexao->prepare($sqlDelete);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        header("Location: sistema.php");
        exit;

    } catch (Exception $e) {
        $msg_erro = "Falha ao excluir o usuário. O banco de dados retornou um erro.";
        header('Location: erro.php?msg=' . urlencode($msg_erro));
        exit;
    }

} else {
    header("Location: sistema.php");
    exit;
}
?>
