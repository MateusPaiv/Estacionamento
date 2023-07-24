<?php

class Atualizar
{

    private $error = array();
    //EDIÇÃO DE FUNCIONÁRIOS
    public function update($nome, $usuario, $email, $senha, $conf_senha, $adm, $id)
    {

        if ($senha <> $conf_senha) {
            $this->error[] = "Senhas diferentes";
        }
        require_once '../actions/autoload.php';

        $conn = new Conexao();
        $conexao = $conn->getConn();


        $stmt = $conexao->prepare("UPDATE funcionarios  SET nome= :nome, nome_usuario= :username , email= :email , senha= :senha, adm= :adm WHERE func_id = '$id'");

        $stmt->bindValue(":nome", $nome);
        $stmt->bindValue(":username", $usuario);
        $stmt->bindValue(":email", $email);
        $stmt->bindValue(":senha", $senha);
        $stmt->bindValue(":adm", $adm);


        $stmt->execute();

        if ($stmt) {


            $fetchDados = $conexao->prepare("SELECT nome_usuario FROM funcionarios WHERE func_id = '$id' ");
            $fetchDados->execute();
            $nome = $fetchDados->fetchColumn();
            $now = new DateTime("now", new DateTimeZone("America/Sao_Paulo"));
            $query = "INSERT INTO logs(nome_func, evento , logs_func_id, tipo, func_cad_id, func_cad_nome,data) VALUES (:nome_func , :evento  ,:func_id,:tipo,'$id','$nome',:data)";

            include '../inc/header.php';
            $data = array();
            $data['nome_func'] = $_SESSION['usuario'][1];
            $data['evento'] = "Atualização de funcionário";
            $data['func_id'] = $_SESSION['usuario'][0];
            $data['tipo'] = "2";
            $data['data'] = $dataBr = $now->format("d/m/Y");
            
            $result = $conn->write($query, $data);

            if ($result) {
                $this->error[] = "<script>window.location.href='../employees?up=true' </script>";
            }
        } else {
            $this->error[] = "Não foi possivel atualizar o usuário";
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
        $query = $conexao->prepare("SELECT * FROM funcionarios WHERE func_id = '$id'");

        $query->execute();


        $user = $query->fetch(PDO::FETCH_ASSOC);

        return $user;
    }
    //////////////////////////////////////
}
