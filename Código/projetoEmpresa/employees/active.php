<?php
include '../actions/autoload.php';

   
$db = new Conexao();

$query = $db->getConn();

$id = $_GET['func_id'];


$stm = $query->prepare("UPDATE funcionarios set status = '1' WHERE func_id = '$id' ");

$result = $stm->execute();


if($result){


    header("Location:view-desativados.php");
}else{
    echo "Erro";
}