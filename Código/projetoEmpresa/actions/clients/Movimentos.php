<?php

class Movimentos
{
    public function viewMovimentos($clie_id)
    {
        require_once '../actions/autoload.php';
        $conn = new Conexao();
        $conexao = $conn->getConn();

        $stmt = $conexao->prepare("SELECT movimentos.*, veiculos.veic_id  FROM movimentos inner join veiculos on movimentos.movi_veic_id = veiculos.veic_id where movi_clie_id= '$clie_id'");
        $stmt->execute();

        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $dados;
        }
}
