<?php

class CadastroCarro
{
    private $error = array();

    public function fetch($id)
    {

        require_once '../actions/autoload.php';

        $conn = new Conexao();
        $conexao = $conn->getConn();
        $user = array();
        $query = $conexao->prepare("SELECT nome_completo FROM clientes WHERE clie_id = '$id'");

        $query->execute();


        $user = $query->fetch(PDO::FETCH_ASSOC);

        return $user;
    }

    public function fetchId($cpf)
    {

        require_once '../actions/autoload.php';

        $conn = new Conexao();
        $conexao = $conn->getConn();
        $user = array();
        $query = $conexao->prepare("SELECT clie_id FROM clientes WHERE cpf_clientes = '$cpf' ");

        $query->execute();


        $user = $query->fetch(PDO::FETCH_ASSOC);

        return $user;
    }
    public function cadastroCarro($POST)
    {

        foreach ($POST as $key => $value) {

            //CPF
            if ($key == "cpf") {
                require_once '../actions/autoload.php';
                $conn = new Conexao();
                $conexao = $conn->getConn();
                $query = $conexao->prepare("SELECT cpf_clientes FROM clientes WHERE cpf_clientes = '$value' ");
                $query->execute();

                if ($query->rowCount() > 0) {
                    if (trim($value) == "") {
                        $this->error[] = "Preencha o campo cpf";
                    }


                    if (preg_match("/[a-z]/", $value)) {
                        $this->error[] = "CPF não pode conter letras";
                    }
                } else {
                    $this->error[] = "O CPF preenchido não pertence a nenhum cliente";
                }
            }

            //NOME COMPLETO
            if ($key == "placa") {

                if (trim($value) == "") {
                    $this->error[] = "Preencha com a placa";
                }
            }


            //EMAIL
            if ($key == "modelo") {
                if (trim($value) == "") {
                    $this->error[] = "Preencha qual o modelo do seu carro";
                }
            }
            //TELEFONE
            if ($key == "cor") {
                if (trim($value) == "") {
                    $this->error[] = "Preencha seu telefone";
                }

                if (preg_match("/[0-9]+/", $value)) {
                    $this->error[] = "Cor não pode conter números";
                }
            }

            //SENHA
            if ($key == "ano") {
                if (preg_match("/[a-z]+/", $value)) {
                    $this->error[] = "Ano não pode haver letras";
                }
            }
        }

        require_once '../actions/autoload.php';
        $db = new Conexao();
        $conexao = $db->getConn();

        $placa = $_POST['placa'];
        $query = $conexao->prepare("SELECT placa FROM veiculos WHERE placa = '$placa'");
        $query->execute();
        $fechtPlaca = $query->fetchColumn();
        if ($fechtPlaca) {
            $this->error[] = "A placa já existe no sistema!";
        } else {
            if (count($this->error) == 0) {

                $cpf = $_POST['cpf'];


                $id = $conexao->prepare("SELECT clie_id FROM clientes WHERE cpf_clientes = '$cpf' ");
                $id->execute();
                $fechtId = $id->fetchColumn();

                $query = "INSERT INTO veiculos (placa, modelo, cor, ano ,veic_clie_id,date) VALUES (:placa , :modelo , :cor , :ano, '$fechtId', :date)";

                $data = array();
                $data['placa'] = addslashes($_POST['placa']);
                $data['modelo'] = addslashes($_POST['modelo']);
                $data['cor'] = addslashes($_POST['cor']);
                $data['ano'] = addslashes($_POST['ano']);
                $data['date'] = date('d-m-Y H:i:m');

                $result = $db->write($query, $data);

                if (!$result) {

                    $this->error[] = "Não foi possível salvar o funcionário";
                } else {

                    $cpf = $_POST['cpf'];

                    $fetchIdNome = $conexao->prepare("SELECT clie_id,nome_completo FROM clientes WHERE cpf_clientes = '$cpf' ");
                    $fetchIdNome->execute();
                    $fecht = $fetchIdNome->fetch(pdo::FETCH_ASSOC);
                    $fechtId = $fecht['clie_id'];
                    $fechtNome = $fecht['nome_completo'];
                    $fetchPlaca = $_POST['placa'];

                    $fetchDados = $conexao->prepare("SELECT placa,veic_clie_id,veic_id FROM veiculos WHERE veic_clie_id = '$fechtId' AND placa = '$fetchPlaca' ");
                    $fetchDados->execute();

                    if ($fetchDados) {

                        $dados = $fetchDados->fetch(PDO::FETCH_ASSOC);
                        $placa = $dados['placa'];
                        $idClie = $dados['veic_clie_id'];
                        $veicId = $dados['veic_id'];

                        $now = new DateTime("now", new DateTimeZone("America/Sao_Paulo"));

                        $query = "INSERT INTO logs(nome_func, evento, nome_clie, placa_veic , logs_clie_id, logs_func_id, logs_veic_id,tipo,data) VALUES (:nome_func , :evento , :nome_clie , '$placa' , '$idClie',:func_id,'$veicId',:tipo,:data)";

                        $data = array();
                        $data['nome_func'] = $_SESSION['usuario'][1];
                        $data['func_id'] = $_SESSION['usuario'][0];
                        $data['evento'] = "Cadastro de veículo";
                        $data['nome_clie'] = $fechtNome;
                        $data['tipo'] = "1";
                        $data['data'] = $dataBr = $now->format("d/m/Y");
                        $result = $db->write($query, $data);

                        if ($result) {
                            $this->error = "<script>window.location.href='../clients?cad' </script>";
                        }
                    }
                }
            }
        }
        return $this->error;
    }
}
