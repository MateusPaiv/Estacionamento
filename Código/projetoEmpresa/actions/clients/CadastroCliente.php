<?php

class CadastroCliente
{

    private $error = array();


    public function sing_up($POST, $cpf)
    {
        foreach ($POST as $key => $value) {
            //CPF
            if ($cpf) {
                // Validação de CPF


                // Extrai somente os números
                $cpf = preg_replace('/[^0-9]/is', '', $cpf);

                if (strlen($value) == 0) {
                    $this->error[] = "Preencha o campo cpf";
                }

                // Verifica se foi informado todos os digitos corretamente

                if (strlen($cpf) != 11) {

                    $this->error[] = "CPF com menos de 11 números";
                }



                // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11

                if (preg_match('/(\d)\1{10}/', $cpf)) {

                    $this->error[] = "Sequência de números repitidos";
                }



                // Faz o calculo para validar o CPF

                for ($t = 9; $t < 11; $t++) {

                    for ($d = 0, $c = 0; $c < $t; $c++) {

                        $d += $cpf[$c] * (($t + 1) - $c);
                    }

                    $d = ((10 * $d) % 11) % 10;

                    if ($cpf[$c] != $d) {
                        $this->error[] = "CPF inválido";
                        break 2;
                    }
                }
            }

            //NOME COMPLETO
            if ($key == "full_name") {

                if (trim($value) == "") {
                    $this->error[] = "Preencha o campo nome";
                }
                if (preg_match("/[0-9]+/", $value)) {
                    $this->error[] = "Seu nome não pode haver números";
                }

                if (is_numeric($value)) {
                    $this->error[] = "Seu nome não pode ser um número";
                }
            }


            //EMAIL
            if ($key == "email") {
                if (trim($value) == "") {
                    $this->error[] = "O email não pode estar vazio";
                }
                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->error[] = "Preencha com um email válido";
                }
            }
            //TELEFONE
            if ($key == "telefone") {

                if (trim($value) == "") {
                    $this->error[] = "Preencha seu telefone";
                }

                if (preg_match("/[a-z]/", $value)) {
                    $this->error[] = "Telefone não pode conter letras";
                }
            }

            if ($key == "horario-entrada" || $key == "horario_saida") {

                if (trim($value) == "") {
                    $this->error[] = "Preencha os horários";
                }
            }
        }

        require_once '../actions/autoload.php';
        //CLASSE DATA
        $now = new DateTime("now", new DateTimeZone("America/Sao_Paulo"));
        $dataBr = $now->format("d/m/Y");

        //CLASSE CONEXÂO
        $db = new Conexao();
        $con = $db->getConn();

        //EVITAR OCORRÊNCIAS NO SISTEMA
        if (!empty($_POST['horario_saida']) && !empty('cpf')) {
            $hora_saida = $_POST['horario-saida'];
            $cpf = $_POST['cpf'];
            $getTimes = array();
            $query = $con->prepare("SELECT hora_saida, movi_vaga_id from movimentos where hora_saida = '$hora_saida' and status = '0' ");
            $query->execute();
            $getTimes = $query->fetch(PDO::FETCH_ASSOC);
            $hora_saida = $getTimes['movi_vaga_id'];
            $this->error[] = "A vaga" . $hora_saida . "está sendo utilizada no momento";
        } else {




            $email = $_POST['email'];
            $telefone = $_POST['telefone'];
            $dados = array();
            $query = $con->prepare("SELECT email, telefone,cpf_clientes FROM clientes WHERE email = '$email' or telefone = '$telefone' or cpf_clientes = '$cpf'");
            $query->execute();
            $dados = $query->fetchAll(PDO::FETCH_ASSOC);
            if ($dados) {
                $this->error[] = "CPF, email ou telefone já está cadastrado";
            } else {
                if (count($this->error) == 0) {


                    $query = "INSERT INTO clientes (cpf_clientes, nome_completo, email, telefone ,horario_entrada,horario_saida,date) VALUES (:cpf , :nome,:email , :telefone ,:entrada , :saida, :date)";

                    $data = array();
                    $data['cpf'] = addslashes($_POST['cpf']);
                    $data['nome'] = addslashes($_POST['full_name']);
                    $data['email'] = addslashes($_POST['email']);
                    $data['telefone'] = addslashes($_POST['telefone']);
                    $data['entrada'] = addslashes($_POST['horario-entrada']);
                    $data['saida'] = addslashes($_POST['horario-saida']);
                    $data['date'] = $dataBr;


                    $result = $db->write($query, $data);

                    if (!$result) {
                        $this->error[] = "Não foi possível salvar o funcionário";
                    } else {

                        $cpf = $_POST['cpf'];

                        $fetchIdNome = $con->prepare("SELECT clie_id,nome_completo FROM clientes WHERE cpf_clientes = '$cpf' ");
                        $fetchIdNome->execute();
                        $fecht = $fetchIdNome->fetch(pdo::FETCH_ASSOC);
                        $fechtId = $fecht['clie_id'];
                        $fechtNome = $fecht['nome_completo'];



                        if ($fecht) {
                            $now = new DateTime("now", new DateTimeZone("America/Sao_Paulo"));
                            $query = "INSERT INTO logs(nome_func, evento, nome_clie , logs_clie_id, logs_func_id,tipo,data) VALUES (:nome_func , :evento , :nome_clie  , '$fechtId',:func_id,:tipo,:data)";

                            $data = array();
                            $data['nome_func'] = $_SESSION['usuario'][1];
                            $data['func_id'] = $_SESSION['usuario'][0];
                            $data['evento'] = "Cadastro de cliente";
                            $data['nome_clie'] = $fechtNome;
                            $data['tipo'] = "1";
                            $data['data'] = $dataBr = $now->format("d/m/Y");
                            $result = $db->write($query, $data);

                            if ($result) {
                                $this->error[] = "<script>window.location.href='../clients?cad' </script>";
                            }
                        }
                    }
                }
            }
        }
        return $this->error;
    }
}
