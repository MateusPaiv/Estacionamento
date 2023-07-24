<?php

class AtualizarCliente
{

    private $error = array();
    //EDIÇÃO DE CLIENTES
    public function updateCliente($nome, $email, $telefone, $entrada, $saida, $id)
    {

        if (trim($nome) == "") {
            $this->error[] = "O nome não pode estar vazio";
        }
        if (trim($email) == "") {
            $this->error[] = "O email não pode estar vazio";
        }
        if (trim($telefone) == "") {
            $this->error[] = "O telefone não pode estar vazio";
        }
        if (trim($entrada) == "") {
            $this->error[] = "O horário de entrada não pode estar vazio";
        }
        if (trim($saida) == "") {
            $this->error[] = "O horário de saída não pode estar vazio";
        }

        if (count($this->error) == 0) {

            require_once '../actions/autoload.php';

            $conn = new Conexao();
            $conexao = $conn->getConn();
            $dados = array();
            $stmt = $conexao->prepare("SELECT email,telefone from clientes WHERE clie_id = '$id'");
            $stmt->execute();
            $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($dados) {
                //EVITAR OCORRÊNCIAS NO SISTEMA

                $hora_saida = $_POST['horario-saida'];
                $getTimes = array();
                $query = $conexao->prepare("SELECT hora_saida, movi_vaga_id,movi_clie_id from movimentos where hora_saida = '$hora_saida' and status = '0' and movi_clie_id = '$id'");
                $query->execute();
                $getTimes = $query->fetch(PDO::FETCH_ASSOC);


                if ($getTimes) {
                    $hora_saida = $getTimes['movi_vaga_id'];
                    $this->error[] = "A vaga" . $hora_saida . "está sendo utilizada no momento";
                } else {

                    $query = $conexao->prepare("SELECT movi_clie_id from movimentos where movi_clie_id = '$id' and status = '0'");
                    $query->execute();
                    $getId = $query->fetchColumn();

                    if ($getId) {
                        $this->error[] = "Ciente está utilizando o estacionamento no momento";
                    } else {
                        $stmt = $conexao->prepare("UPDATE clientes SET nome_completo= :nome , email= :email, telefone= :telefone, horario_entrada= :entrada, horario_saida = :saida WHERE clie_id = '$id'");

                        $stmt->bindValue(":nome", $nome);
                        $stmt->bindValue(":email", $email);
                        $stmt->bindValue(":telefone", $telefone);
                        $stmt->bindValue(":entrada", $entrada);
                        $stmt->bindValue(":saida", $saida);
                        $stmt->execute();
                        if ($stmt) {
                            $now = new DateTime("now", new DateTimeZone("America/Sao_Paulo"));
                            $query = "INSERT INTO logs(nome_func, evento, nome_clie , logs_clie_id, logs_func_id,tipo,data) VALUES (:nome_func , :evento , '$nome' , '$id',:func_id,:tipo,:data)";

                            include '../inc/header.php';
                            $data = array();
                            $data['nome_func'] = $_SESSION['usuario'][1];
                            $data['evento'] = "Atualização de cliente";
                            $data['func_id'] = $_SESSION['usuario'][0];
                            $data['tipo'] = "2";
                            $data['data'] = $dataBr = $now->format("d/m/Y");
                            
                            $result = $conn->write($query, $data);
                            if ($result) {
                                $this->error[] = "<script>window.location.href='../clients?up' </script>";
                            } else {
                                $this->error[] = "Não foi posível atualizar o usuário";
                            }
                        }
                    }
                }
            } else {
                $this->error[] = "email ou telefone já estão cadastrados no sistema";
            }
        }

        return $this->error;
    }

    public function fetchClientes($id)
    {
        require_once '../actions/autoload.php';

        $conn = new Conexao();
        $conexao = $conn->getConn();
        $user = array();
        $query = $conexao->prepare("SELECT * FROM clientes WHERE clie_id = '$id'");

        $query->execute();


        $user = $query->fetch(PDO::FETCH_ASSOC);

        return $user;
    }
}
