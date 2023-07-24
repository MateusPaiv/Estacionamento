<!DOCTYPE html>
<html lang="pt-br">
<?php
include '../config/config.php';
@session_start();

if (isset($_SESSION['usuario']) && is_array($_SESSION['usuario'])) {
    require_once('../actions/autoload.php');

    $conexaoClass = new Conexao();
    $conexao = $conexaoClass->getConn();
    $adm = $_SESSION['usuario'][2];
    $nome = $_SESSION['usuario'][1];
} else {
    header("Location:" . BASEURL . "/index.php");
}
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php BASEURL ?>/assets/css/style.css">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="<?php BASEURL ?>/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <link rel="shortcut icon" href="<?php BASEURL ?>/assets/img/favicon-16x16.png" type="image/x-icon">

    <title>Estacione Aqui!</title>

</head>

<body>
    <nav class="sidebar close">
        <header>
            <div class="image-text">
                <span class="image">
                    <!--<img src="logo.png" alt="">-->
                </span>

                <div class="text logo-text">
                    <span class="name text-warning">EstacioneAqui</span>
                    <span class="profession">System Park</span>
                </div>
            </div>
            <i class="bi bi-arrow-right toggle"></i>
        </header>

        <div class="menu-bar">
            <div class="menu">
                <ul class="menu-links">
                    <li class="nav-link">
                        <a href="<?php BASEURL ?>/dashboard">
                            <i class="bi bi-bar-chart-line icon"></i>
                            <span class="text nav-text">Home</span>
                        </a>
                    </li>

                    <!-- DROP DOWN -->
                    <div class="bottom-content">
                        <li class="nav-link">
                            <div class="btn-group dropdown text nav-text">
                                <span><i class="bi bi-person-circle icon"></i></span>
                                <span type="button" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    Cadastros
                                </span>
                                <ul class="dropdown-menu bg-warning text-dark">
                                    <li class="nav-link">
                                        <a href="<?php BASEURL ?>/clients">
                                            <i class="bi bi-person icon text-dark"></i>
                                            <span class="text-center text-dark">Clientes</span>
                                        </a>
                                    </li>

                                    <li class="nav-link">
                                        <a href="<?php BASEURL ?>/veiculos">
                                            <i class="bi bi-car-front icon text-dark"></i>
                                            <span class="text-center text-dark">Veículos</span>
                                        </a>
                                    </li>
                                    <?php if ($adm) : ?>
                                        <li class="nav-link">
                                            <a href="<?php BASEURL ?>/employees">
                                                <i class="bi bi-person-badge icon text-dark"></i>
                                                <span class="text-dark">Funcionários</span>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </li>
                    </div>

                    <!-- END DROP  -->


                    <li class="nav-link">
                        <a href="<?php BASEURL ?>/parking">
                            <i class='bi bi-p-circle icon '></i>
                            <span class="text nav-text">Controle</span>
                        </a>
                    </li>
                    <div class="bottom-content">
                        <li class="nav-link">
                            <div class="btn-group dropdown text nav-text">
                                <i class="bi bi-clipboard2 icon"></i>
                                <span type="button" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    Relatórios
                                </span>
                                <ul class="dropdown-menu bg-warning text-dark">
                                    <li class="nav-link">
                                        <a href="<?php BASEURL ?>/reports">
                                            <i class="bi bi-calendar-event icon text-dark"></i>
                                            <span class="text-center text-dark">Movimentos</span>
                                        </a>
                                    </li>
                                    <?php if ($adm) : ?>
                                        <li class="nav-link">
                                            <a href="<?php BASEURL ?>/logs">
                                                <i class="bi bi-eye icon text-dark"></i>
                                                <span class="text-center text-dark">Logs</span>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                </ul>

                            </div>
                        </li>
                    </div>
                </ul>
            </div>

            <div class="bottom-content">
                <li class="">
                    <div class="btn-group dropup text nav-text">
                        <span><i class="bi bi-person-circle me-2 ms-5"></i></span>
                        <span type="button" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <?= $_SESSION['usuario'][1] ?>
                        </span>
                        <ul class="dropdown-menu bg-white ">
                            <a href="<?php BASEURL ?>/actions/logout.php" class="link link-dark">Sair</a>
                            <a href="<?php BASEURL ?>/public/view.php?func_id=<?= $_SESSION['usuario'][0] ?>" class="link link-dark">Perfil</a>
                        </ul>
                    </div>
                </li>

            </div>
        </div>

    </nav>