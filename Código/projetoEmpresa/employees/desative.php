<?php
include '../actions/autoload.php';

   
$db = new Conexao();

$query = $db->getConn();

$id = $_GET['func_id'];


$stm = $query->prepare("UPDATE funcionarios set status = '0' WHERE func_id = '$id' ");

$result = $stm->execute();


if($result){

 
    header("Location:index.php");
}else{
    echo "Erro";
}

    /* $conn = new Conexao();
    $query = $conn->getConn();



    $stm = $query->prepare("SELECT cpf_funcionarios FROM funcionarios");
    $result = $stm->execute();
    $result = $stm->fetchColumn(); */

  

