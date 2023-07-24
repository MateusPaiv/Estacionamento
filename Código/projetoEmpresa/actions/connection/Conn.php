<?php

class Conexao
{
    private $host = 'localhost';
    private $db = 'estacionamento';
    private $username = 'postgres';
    private $password = 'postgres';

    private function conectar()
    {
        try {
            $conn = new PDO('pgsql:host=' . $this->host . ';dbname=' . $this->db, $this->username, $this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {

            $conn = null;
        }

        return $conn;
    }
    public function getConn()
    {
        return $this->conectar();
    }

    public function write($query, $data = array())
    {

        $conn = $this->conectar();

        $stm = $conn->prepare($query);
        $result = $stm->execute($data);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}

/* $host = 'localhost';
$db = 'estacionamento';
$username = 'postgres';
$password = 'postgres';


try {
    $conn = new PDO('pgsql:host=' . $host . ';dbname=' . $db, $username, $password);

    return $conn;
} catch (PDOException $e) {
    die();
}
 */