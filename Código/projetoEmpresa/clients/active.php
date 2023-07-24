<?php
include '../actions/autoload.php';

   
$db = new Conexao();

$query = $db->getConn();

$id = $_GET['clie_id'];


$stm = $query->prepare("UPDATE clientes set status = '1' WHERE clie_id = '$id' ");

$result = $stm->execute();


if($result){


    header("Location:view-desativados.php");
}else{
    echo "Erro";
}