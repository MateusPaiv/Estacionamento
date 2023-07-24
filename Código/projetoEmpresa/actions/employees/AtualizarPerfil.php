<?php
class AtualizarPerfil
{

    private $error = array();

    //EDIÇÃO DE FUNCIONÁRIOS
    public function updatePerfil($nome, $usuario, $email, $senha, $conf_senha,  $id)
    {

        if ($senha <> $conf_senha) {
            return $this->error[] = "Senhas diferentes";
        }
        require_once '../actions/autoload.php';

        $conn = new Conexao();
        $conexao = $conn->getConn();


        $stmt = $conexao->prepare("UPDATE funcionarios  SET nome= :nome, nome_usuario= :username , email= :email , senha= :senha WHERE func_id = '$id'");

        $stmt->bindValue(":nome", $nome);
        $stmt->bindValue(":username", $usuario);
        $stmt->bindValue(":email", $email);
        $stmt->bindValue(":senha", $senha);
        $stmt->execute();

        if ($stmt) {
            
  
            $now = new DateTime("now", new DateTimeZone("America/Sao_Paulo"));
            $query = "INSERT INTO logs(nome_func, evento , logs_func_id, tipo ,data) VALUES (:nome_func , :evento ,:func_id,:tipo,:data)";

            include '../inc/header.php';
            $data = array();
            $data['nome_func'] = $_SESSION['usuario'][1];
            $data['evento'] = "Atualização de perfil do funcionário";
            $data['func_id'] = $_SESSION['usuario'][0];
            $data['tipo'] = "2";
            $data['data'] = $dataBr = $now->format("d/m/Y");
            
            $result = $conn->write($query, $data);

            if ($result) {
                $this->error[] = "<script>window.location.href='../public/view.php?func_id={$_SESSION['usuario']['0']}&up'</script>";
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
