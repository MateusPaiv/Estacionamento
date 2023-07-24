<?php

class AtualizarCarro
{

    private $error = array();
    //EDIÇÃO DE VEICULOS
    public function update($placa, $modelo, $cor, $ano, $id)
    {
        require_once '../actions/autoload.php';

        $conn = new Conexao();
        $conexao = $conn->getConn();
        $dados = array();
        $stmt = $conexao->prepare("SELECT placa from veiculos WHERE placa = '$placa' ");
        $stmt->execute();
        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($dados) {
            $this->error[] = "placa já está cadastrada no sistema";
        } else {
            $stmt = $conexao->prepare("UPDATE veiculos SET placa= :placa, modelo = :modelo , cor= :cor , ano= :ano WHERE veic_id = '$id'");

            $stmt->bindValue(":placa", $placa);
            $stmt->bindValue(":modelo", $modelo);
            $stmt->bindValue(":cor", $cor);
            $stmt->bindValue(":ano", $ano);

            $stmt->execute();

            if ($stmt) {

                $fetch = $conexao->prepare("SELECT veic_clie_id FROM veiculos WHERE veic_id = '$id' ");
                $fetch->execute();
                $idClie = $fetch->fetchColumn();

                if ($idClie) {

                    $fetch = $conexao->prepare("SELECT nome_completo FROM clientes WHERE clie_id = '$idClie' ");
                    $fetch->execute();
                    $nomeClie = $fetch->fetchColumn();
                }

                $now = new DateTime("now", new DateTimeZone("America/Sao_Paulo"));

                $query = "INSERT INTO logs(nome_func, evento, nome_clie, placa_veic , logs_clie_id, logs_func_id, logs_veic_id,tipo,data) VALUES (:nome_func , :evento , :nome_clie , '$placa' , '$idClie',:func_id,'$id',:tipo,:data)";

                include '../inc/header.php';
                $data = array();
                $data['nome_func'] = $_SESSION['usuario'][1];
                $data['evento'] = "Atualização de veículo";
                $data['nome_clie'] = $nomeClie;
                $data['func_id'] = $_SESSION['usuario'][0];
                $data['tipo'] = "2";
                $data['data'] = $dataBr = $now->format("d/m/Y");
                
                $result = $conn->write($query, $data);

                if ($result) {
                    $this->error[] = "<script>window.location.href='../veiculos?up' </script>";
                }
            }
        }

        return $this->error;
    }
    //BUSCAR DADO DE FUNCIONÁRIO
    public function fetch($id)
    {
        require_once '../actions/autoload.php';

        $conn = new Conexao();
        $conexao = $conn->getConn();
        $user = array();
        $query = $conexao->prepare("SELECT * FROM veiculos WHERE veic_id = '$id'");

        $query->execute();


        $user = $query->fetch(PDO::FETCH_ASSOC);

        return $user;
    }
}
