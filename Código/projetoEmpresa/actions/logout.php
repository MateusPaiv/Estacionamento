<?php
require_once 'autoload.php';

session_start();

$conexaoClass = new Conexao();

$conexao = $conexaoClass->getConn();

$nome = $_SESSION['usuario'][0];


if (isset($_SESSION['usuario'])) {
    session_destroy();

    header("Location: ../index.php");
}
