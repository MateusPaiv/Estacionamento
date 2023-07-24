
<?php

require('autoload.php');

class Login
{
    private $con = null;

    public function __construct($conexao)
    {
        $this->con = $conexao;
    }

    public function send()
    {
        if (empty($_POST) || $this->con == null) {
            echo json_encode(array("erro" => 1, "mensagem" => "Ocorreu um erro interno no servidor."));
            return;
        } else {
            switch (true) {
                case (isset($_POST['email']) && isset($_POST['senha'])):
                    echo $this->login($_POST['email'], $_POST['senha']);
                    break;
            }
        }
    }
    public function login($email, $senha)
    {

        $conexao = $this->con;

        $query = $conexao->prepare("SELECT * FROM funcionarios WHERE email = ? AND senha = ? ");
        $query->execute(array($email, $senha));

        if ($query->rowCount()) {

            $user = array();
            $user = $query->fetchAll(PDO::FETCH_ASSOC)[0];

            session_start();

            $adm = '1';
            $notAdm = '0';

            $_SESSION['usuario'] = array($user['func_id'], $user['nome_usuario'], $user['adm'], $user['status']);


            if ($user['status'] == '0') {
                return json_encode(array("erro" => 1, "mensagem" => "Você está desativado no sistema."));
            }
            if ($user['adm'] == '1') {
                $user['adm'] = $adm;
            } else {
                $adm = $notAdm;
                $user['adm'] = $adm;
            }


            return json_encode(array("erro" => 0));
        } else {
            //Json encode : Retorna uma string contendo a representação JSON de value fornecido. Se o parâmetro for um array ou object, ele será serializado recursivamente.
            return json_encode(array("erro" => 1, "mensagem" => "E-mail e/ou senha incorretos."));
        }
    }
}

$conexao = new Conexao();
$classe = new Login($conexao->getConn());
$classe->send();
