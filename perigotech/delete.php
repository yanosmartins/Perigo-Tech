<?php
if(!empty($_GET['idusuarios'])) {
    include_once("config.php");

    $id = intval($_GET['idusuarios']); // segurança contra SQL Injection

    // Verifica se o ID existe
    $sqlSelect = "SELECT * FROM cadastro_tech WHERE idusuarios=$id";
    $result = $conexao->query($sqlSelect);

    if($result && $result->num_rows > 0) {
        $sqlDelete = "DELETE FROM cadastro_tech WHERE idusuarios=$id";
        $resultDelete = $conexao->query($sqlDelete);
    }

    header("Location: sistema.php");
    exit;
} else {
    header("Location: sistema.php");
    exit;
}
?>
