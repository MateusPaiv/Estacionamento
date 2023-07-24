<?php

class Cadastro
{

    private $error = array();

    public function sing_up($POST, $conf_senha, $cpf)
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
            //NOME DE USUÁRIO
            if ($key == "username") {
                if (trim($value) == "") {
                    $this->error[] = "O nome de usuário não pode estar vazio";
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

            //SENHA
            if ($key == "senha") {
                if (trim($value) == "") {
                    $this->error[] = "A senha não pode estar vazio";
                }
                if (strlen($value) < 4) {
                    $this->error[] = "Senha não pode haver menos que 4 caracteres";
                }

                if ($value <> $conf_senha) {
                    $this->error[] = "Senha indiferentes!";
                }
            }
        }
        require_once '../actions/autoload.php';
        $db = new Conexao();

        $con = $db->getConn();
        $cpf = $_POST['cpf'];
        $email = $_POST['email'];
        $user = $_POST['username'];

        $dados = array();
        $query = $con->prepare("SELECT cpf_funcionarios, email, nome_usuario from funcionarios where cpf_funcionarios = '$cpf' or email = '$email' or nome_usuario = '$user' ");
        $query->execute();
        $dados = $query->fetchAll(PDO::FETCH_ASSOC);

        if ($dados) {
            $this->error[] = "E-mail, CPF ou nome de usuário já estão cadastrados";
        } else {
            if (count($this->error) == 0) {

                $query = "INSERT INTO funcionarios (cpf_funcionarios, nome, nome_usuario, email, senha, adm) VALUES (:cpf , :nome, :nome_usuario, :email , :senha, :adm )";

                $data = array();
                $data['cpf'] = addslashes($_POST['cpf']);
                $data['nome'] = addslashes($_POST['full_name']);
                $data['nome_usuario'] = addslashes($_POST['username']);
                $data['email'] = addslashes($_POST['email']);
                $data['senha'] = addslashes($_POST['senha']);
                $data['adm'] = addslashes($_POST['fb']);

                $result = $db->write($query, $data);

                if (!$result) {
                    $this->error[] = "Não foi possível salvar o funcionário";
                } else {

                    $cpf = $_POST['cpf'];

                    $fetchDados = $con->prepare("SELECT nome_usuario,func_id FROM funcionarios WHERE cpf_funcionarios = '$cpf' ");
                    $fetchDados->execute();

                    if ($fetchDados) {

                        $dados = $fetchDados->fetch(PDO::FETCH_ASSOC);
                        $nome = $dados['nome_usuario'];
                        $func_id = $dados['func_id'];
                        $now = new DateTime("now", new DateTimeZone("America/Sao_Paulo"));
                        $query = "INSERT INTO logs(nome_func, evento, logs_func_id,tipo, func_cad_id,func_cad_nome,data) VALUES (:nome_func , :evento ,:func_id,:tipo,'$func_id','$nome',:data)";

                        $data = array();
                        $data['nome_func'] = $_SESSION['usuario'][1];
                        $data['func_id'] = $_SESSION['usuario'][0];
                        $data['evento'] = "Cadastro de funcionário";
                        $data['tipo'] = "1";
                        $data['data'] = $dataBr = $now->format("d/m/Y");

                        $result = $db->write($query, $data);

                        if ($result) {
                            $this->error =  "<script>window.location.href='../clients?cad' </script>";
                        }
                    }
                }
            }
        }

        return $this->error;
    }
}
