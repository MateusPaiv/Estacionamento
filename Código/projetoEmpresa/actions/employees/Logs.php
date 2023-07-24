<?php

class Logs
{
    public function viewLogs($func_id)
    {
        require_once '../actions/autoload.php';
        $conn = new Conexao();
        $conexao = $conn->getConn();

        $stmt = $conexao->prepare("SELECT *  FROM logs where logs_func_id= '$func_id'");
        $stmt->execute();

        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $dados;
        }
}
