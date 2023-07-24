<?php
include '../actions/autoload.php';


$db = new Conexao();

$query = $db->getConn();

$erro = array();

$id = $_GET['clie_id'];


$stm = $query->prepare("SELECT movi_clie_id FROM movimentos WHERE movi_clie_id = '$id' AND status = '0'");
$stm->execute();
$verificacaoMovi = $stm->fetchColumn();

if ($verificacaoMovi) {    
    header("Location:index.php?erro");
} else {
    $stm = $query->prepare("UPDATE clientes set status = '0' WHERE clie_id = '$id' ");

    $result = $stm->execute();


    if ($result) {
        header("Location:index.php");
    } else {
        echo "Erro";
    }
}



    /* $conn = new Conexao();
    $query = $conn->getConn();



    $stm = $query->prepare("SELECT cpf_funcionarios FROM funcionarios");
    $result = $stm->execute();
    $result = $stm->fetchColumn(); */
