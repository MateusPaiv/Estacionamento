<?php

require '../actions/autoload.php';

$con = new Conexao();

$conexao = $con->getConn();

$id = filter_input(INPUT_GET, 'id');

$query = $conexao->prepare("SELECT movimentos.placa, movimentos.nome_cliente,movimentos.modelo from movimentos inner join vagas on movimentos.movi_vaga_id = vagas.vaga_id where movi_vaga_id = :id and movimentos.status = '0' and vagas.status = '1'");

$query->bindValue(':id' , $id);

$query->execute();

if ($query) {

    $result_cliente = $query->fetch(PDO::FETCH_ASSOC);

    $retorna = ['status' => true, 'dados' => $result_cliente];
} else {
    $retorna = ['status' => false, 'msg' => "<div class= 'bg-danger text-white>Nenhuma usuário encontrado!</div>'"];
}


echo json_encode($retorna);
