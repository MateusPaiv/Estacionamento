<?php

class Park
{


    private $error = array();


    // VERIFICAÇÃO PARA CHECK-IN SE CADASTRADO
    public function verificacao($placa)
    {
        require_once '../actions/autoload.php';

        $conn = new Conexao();
        $conexao = $conn->getConn();

        /* Na hora que verificar a placa tenho que ver se o cliente e cadastrado no banco -- */


        //VERIFICANDO SE TEM O CLIENTE TEM CADASTRO NO BANCO 

        $user = array();
        $query = $conexao->prepare("SELECT veiculos.* , clientes.* from veiculos inner join clientes on veiculos.veic_clie_id = clientes.clie_id where placa = '$placa'");

        $query->execute();

        if ($query->rowCount() > 0) {
            $user = $query->fetch(PDO::FETCH_ASSOC);
            return $user;
        }


        /* --> Se a verificação a placa estiver no banco tem que pegar o horario desse cliente e colocar em uma vaga de acordo com seu horário de saída e comparando com todos os horários de outros clientes */
    }


    public function check_in($nome, $placa, $modelo, $manobrista)
    {

        require_once '../actions/autoload.php';

        $now = new DateTime("now", new DateTimeZone("America/Sao_Paulo"));
        $horaBr = $now->format("H:i");
        $dataBr = $now->format("d/m/Y");

        $conn = new Conexao();
        $conexao = $conn->getConn();

        $stm = $conexao->prepare("SELECT veic_clie_id FROM veiculos WHERE placa = '$placa'");
        $stm->execute();

        $dadosIdFromVeic = $stm->fetchColumn();

        //vai receber o id do cliente com a placa que foi feita o check-in
        $veicClieId = $dadosIdFromVeic;

        if ($stm->rowCount() > 0) {
            $query = $conexao->prepare("SELECT clientes.status from veiculos inner join clientes on veiculos.veic_clie_id = clientes.clie_id where placa = '$placa'");
            $query->execute();

            $clie_status = $query->fetchColumn();

            if ($clie_status == '0') {
                $this->error[] = "O cliente está desativado no sistema";

                $query = $conexao->prepare("SELECT data_saida from movimentos where status = '1' and data_saida = '$dataBr'");
                $query->execute();
                $result = $query->fetchColumn();
            } else {

                $query = $conexao->prepare("SELECT clie_id from clientes where status = '1' order by horario_saida");
                $query->execute();

                $dados_clie = $query->fetchAll(PDO::FETCH_ASSOC);

                $posicao = 0;

                foreach ($dados_clie as $key => $value) :

                    $posicao = $posicao + 1;

                    $getIdClie = $dados_clie[$key];

                    $clieId = $getIdClie['clie_id'];

                    if ($clieId == $veicClieId) {
                        break;
                    }

                endforeach;

                $dados = array();
                $stmt = $conexao->prepare("SELECT clientes.clie_id,clientes.horario_entrada, clientes.horario_saida,veiculos.veic_id from veiculos inner join clientes on veiculos.veic_clie_id = clientes.clie_id where placa = '$placa'");
                $stmt->execute();
                $dados = $stmt->fetch(PDO::FETCH_ASSOC);

                $entrada = $dados['horario_entrada'];
                $saida = $dados['horario_saida'];
                $veic_id = $dados['veic_id'];
                $clie_id = $dados['clie_id'];
                if ($horaBr <  $entrada || $horaBr > $saida) {
                    $this->error[] = "<div class ='bg-danger bg-opacity-25 text-danger'>Cliente não está no horário marcado</div>";
                } else {
                    $stmt = $conexao->prepare("UPDATE vagas SET status = '1' WHERE vaga_id = '$posicao' AND status = '0'");
                    $stmt->execute();

                    $query = $conexao->prepare("INSERT INTO movimentos(nome_cliente, placa,modelo,data_entrada,hora_entrada,movi_veic_id, movi_vaga_id, movi_clie_id,mano_check_in) VALUES ('$nome' , '$placa', '$modelo', '$dataBr','$horaBr','$veic_id','$posicao','$clie_id','$manobrista')");
                    $query->execute();
                    $now = new DateTime("now", new DateTimeZone("America/Sao_Paulo"));
                    $stmt = "INSERT INTO logs(nome_func, evento, logs_func_id,tipo,nome_clie,placa_veic,data,mano_check_in) VALUES (:nome_func , :evento ,:func_id,:tipo, '$nome' , '$placa', :data,'$manobrista')";

                    $data = array();
                    $data['nome_func'] = $_SESSION['usuario'][1];
                    $data['func_id'] = $_SESSION['usuario'][0];
                    $data['evento'] = "Check-in";
                    $data['tipo'] = "3";
                    $data['data'] = $dataBr = $now->format("d/m/Y");

                    $result = $conn->write($stmt, $data);
                    if ($result) {
                        $this->error[] = 'Estacione o veículo na vaga ' . $posicao;
                    }
                }
            }
        } else {
            $query = $conexao->prepare("SELECT vaga_id from vagas where status = '0' AND vaga_id >= 51 order by vaga_id limit 1 ");
            $query->execute();

            $vaga_disponivel = $query->fetchColumn();

            $stmt = $conexao->prepare("UPDATE vagas SET status = '1' where vaga_id = '$vaga_disponivel'");

            $stmt->execute();

            if ($stmt) {

                $query = $conexao->prepare("INSERT INTO movimentos(nome_cliente, placa ,modelo ,data_entrada,hora_entrada,movi_vaga_id,mano_check_in) VALUES ('$nome' , '$placa', '$modelo', '$dataBr','$horaBr', '$vaga_disponivel', '$manobrista')");
                $query->execute();

                if ($query) {
                    $now = new DateTime("now", new DateTimeZone("America/Sao_Paulo"));
                    $stmt = "INSERT INTO logs(nome_func, evento, logs_func_id,tipo,nome_clie,placa_veic,data,mano_check_in) VALUES (:nome_func , :evento ,:func_id,:tipo, '$nome' , '$placa',:data,'$manobrista')";

                    $data = array();
                    $data['nome_func'] = $_SESSION['usuario'][1];
                    $data['func_id'] = $_SESSION['usuario'][0];
                    $data['evento'] = "Check-in";
                    $data['tipo'] = "3";
                    $data['data'] = $dataBr = $now->format("d/m/Y");

                    $result = $conn->write($stmt, $data);
                    if ($result) {
                        $this->error[] = 'Estacione o veículo na vaga ' . $vaga_disponivel;
                    }
                }
            }
        }

        return $this->error;
    }



    public function verificacao_check_out($placa)
    {
        require_once '../actions/autoload.php';

        $conn = new Conexao();
        $conexao = $conn->getConn();
        $user = array();
        $query = $conexao->prepare("SELECT * FROM movimentos  where placa = '$placa' AND status = '0' ");

        $query->execute();

        if ($query->rowCount() > 0) {

            $user = $query->fetch(PDO::FETCH_ASSOC);

            return $user;
        }
    }

    //CHECK-OUT
    public function check_out($placa, $manobrista, $hora)
    {

        require_once '../actions/autoload.php';

        $date = new DateTime("now", new DateTimeZone("America/Sao_Paulo"));
        $horaBr = $date->format("H:i");
        $dataBr = $date->format("d/m/Y");

        $now  = new ClassDate();

        $conn = new Conexao();
        $conexao = $conn->getConn();
        $stm = $conexao->prepare("SELECT placa FROM veiculos WHERE placa = '$placa'");
        $stm->execute();


        if ($stm->rowCount() > 0) {
/* $horaBr no lugar de $ hora */
            $query = $conexao->prepare("UPDATE movimentos SET hora_saida = '$hora' WHERE placa = '$placa' AND status = '0'");
            $query->execute();

            if ($query) {
                $dados = array();
                $query = $conexao->prepare("SELECT hora_entrada,hora_saida  FROM movimentos WHERE placa = '$placa' AND status = '0'");
                $query->execute();

                $dados = $query->fetch(PDO::FETCH_ASSOC);

                $entrada = $dados['hora_entrada'];
                $saida = $dados['hora_saida'];

                $valorCad = $now->getLocationCad($entrada, $saida);

                //UP NA TABELA DE MOVIMENTOS COMO STATUS CONCLUÍDO
                $up = $conexao->prepare("UPDATE movimentos SET valor = '$valorCad', status = '1',data_saida = '$dataBr',mano_check_out = '$manobrista' WHERE placa = '$placa' AND status = '0'");
                $up->execute();
            }
            if ($up) {
                $query = $conexao->prepare("SELECT movi_vaga_id FROM movimentos WHERE placa = '$placa' AND status = '1' AND data_saida = '$dataBr'");

                $query->execute();

                $vaga_id = $query->fetchColumn();

                if ($vaga_id) {
                    $stmt = $conexao->prepare("UPDATE vagas SET status = '0' WHERE status = '1' AND vaga_id = '$vaga_id'");
                    $stmt->execute();
                } else {
                    $this->error[] = 'Não foi possível fazer o check-out';
                }
            }

            $query = $conexao->prepare("SELECT movi_vaga_id,nome_cliente FROM movimentos WHERE placa = '$placa' AND status = '1'");

            $query->execute();

            $vaga_id = $query->fetch(PDO::FETCH_ASSOC);
            $id = $vaga_id['movi_vaga_id'];
            $nome = $vaga_id['nome_cliente'];

            $stmt = $conexao->prepare("UPDATE vagas SET status = '0' WHERE status = '1' AND vaga_id = '$id'");
            $stmt->execute();

            if ($stmt) {
                $now = new DateTime("now", new DateTimeZone("America/Sao_Paulo"));
                $insertLog = "INSERT INTO logs(nome_func, evento, logs_func_id,tipo,nome_clie,placa_veic,data,mano_check_out) VALUES (:nome_func , :evento ,:func_id,:tipo, '$nome' ,'$placa',:data,'$manobrista')";

                $data = array();
                $data['nome_func'] = $_SESSION['usuario'][1];
                $data['func_id'] = $_SESSION['usuario'][0];
                $data['evento'] = "Check-out";
                $data['tipo'] = "3";
                $data['data'] = $dataBr = $now->format("d/m/Y");

                $result = $conn->write($insertLog, $data);

                if ($result) {
                    $this->error[] = "O valor que deve ser pago é de R$" . $valorCad . ",00 <br>Cartão: <i class='bi bi-credit-card text-dark'></i><br>Dinheiro: <i class='bi bi-cash-stack text-dark'></i>";
                }
            }
        } else {

            $query = $conexao->prepare("UPDATE movimentos SET data_saida = '$dataBr', hora_saida = '$horaBr',mano_check_out = '$manobrista' WHERE placa = '$placa' AND status = '0'");
            $query->execute();


            $dados = array();
            $query = $conexao->prepare("SELECT hora_entrada , hora_saida FROM movimentos WHERE placa = '$placa' AND status = '0'");
            $query->execute();

            $dados = $query->fetch(PDO::FETCH_ASSOC);
            $entrada = $dados['hora_entrada'];
            $saida = $dados['hora_saida'];


            $valor = $now->getLocation($entrada, $saida);


            $upValorAndStatus = $conexao->prepare("UPDATE movimentos SET valor = '$valor',status = '1' WHERE placa = '$placa' AND status = '0'");
            $upValorAndStatus->execute();

            if ($upValorAndStatus) {

                $query = $conexao->prepare("SELECT movi_vaga_id,nome_cliente FROM movimentos WHERE placa = '$placa' AND status = '1'");

                $query->execute();

                $dados = $query->fetch(PDO::FETCH_ASSOC);

                $vaga_id = $dados['movi_vaga_id'];
                $nome = $dados['nome_cliente'];

                $stmt = $conexao->prepare("UPDATE vagas SET status = '0' WHERE status = '1' AND vaga_id = '$vaga_id'");
                $stmt->execute();

                $now = new DateTime("now", new DateTimeZone("America/Sao_Paulo"));
                $insertLog = "INSERT INTO logs(nome_func, evento, logs_func_id,tipo,nome_clie,placa_veic,data,mano_check_out) VALUES (:nome_func , :evento ,:func_id,:tipo, '$nome' , '$placa',:data,'$manobrista')";

                $data = array();
                $data['nome_func'] = $_SESSION['usuario'][1];
                $data['func_id'] = $_SESSION['usuario'][0];
                $data['evento'] = "Check-out";
                $data['tipo'] = "3";
                $data['data'] = $dataBr = $now->format("d/m/Y");

                $result = $conn->write($insertLog, $data);

                if ($result) {
                    $this->error[] = "O valor que deve ser pago é de R$" . $valor . ",00 <br>Cartão: <i class='bi bi-credit-card text-dark'></i><br>Dinheiro: <i class='bi bi-cash-stack text-dark'></i>";
                }
            }
        }

        return $this->error;
    }
}
