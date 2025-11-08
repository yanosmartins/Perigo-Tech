<?php
session_start();

if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

$id_prod = $_POST['id_prod'] ?? null;
$acao = $_POST['acao'] ?? null;

if ($acao) {

    switch ($acao) {
        case 'limpar':
            $_SESSION['carrinho'] = [];
            break;

        case 'adicionar':
        case 'remover_um':
        case 'remover_produto':

            if ($id_prod) {

                switch ($acao) {
                    case 'adicionar':
                        if (!isset($_SESSION['carrinho'][$id_prod])) {
                            $_SESSION['carrinho'][$id_prod] = 1;
                        } else {
                            $_SESSION['carrinho'][$id_prod]++;
                        }
                        break;

                    case 'remover_um':
                        if (isset($_SESSION['carrinho'][$id_prod])) {
                            $_SESSION['carrinho'][$id_prod]--;
                            if ($_SESSION['carrinho'][$id_prod] <= 0) {
                                unset($_SESSION['carrinho'][$id_prod]);
                            }
                        }
                        break;
                    
                    case 'remover_produto':
                        if (isset($_SESSION['carrinho'][$id_prod])) {
                            unset($_SESSION['carrinho'][$id_prod]);
                        }
                        break;
                }
            }
            break;
    }
}

header('Location: ' . $_SERVER['HTTP_REFERER']);
exit;
?>