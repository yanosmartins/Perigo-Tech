<?php

     $dbHost = 'Localhost';
     $dbUsername = 'root';
     $dbPassword = '';
     $dbname = 'cadastro-tech';

     $conexao = new mysqli($dbHost, $dbUsername, $dbPassword,$dbname);       

     //if($conexão->connect_errno){
      //   echo "Erro";
    // }
     //else{
     //    echo "Conexão realizada com sucesso";
     //}

?>