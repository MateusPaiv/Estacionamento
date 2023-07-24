<?php

if (count($_POST) > 0 && isset($_POST)) {

    include '../actions/autoload.php';

    $sing = new AtualizarCliente();

    $nome = addslashes($_POST['full_name']);
    $email = addslashes($_POST['email']);
    $telefone = addslashes($_POST['telefone']);
    $entrada = addslashes($_POST['horario-entrada']);
    $saida = addslashes($_POST['horario-saida']);
    $id = $_GET['clie_id'];

    $errors = $sing->updateCliente($nome, $email, $telefone, $entrada, $saida,  $id);
}


include('../inc/header.php');

$up = new AtualizarCliente();

$id = $_GET['clie_id'];

$user = $up->fetchClientes($id);

?>


<div>
    <div class="form-sing d-flex flex-column justify-content-center align-items-center">

        <div class="text-dark">
            <div class="sing">
                <h4 class="text-center">Atualizar cliente</h4>
                <form method="POST">
                    <div class="row">
                        <div class="col">
                            <!-- Name input -->
                            <div class="form-outline">
                                <input class="form-control" type="text" name="full_name" id="nome" value="<?= $user['nome_completo'] ?>">
                                <label class="label-control">Nome completo:</label>
                            </div>
                        </div>
                        <div class="col">
                            <!-- Email input -->
                            <div class="form-outline">
                                <input class="form-control" type="email" name="email" id="email" value="<?= $user['email'] ?>">
                                <label class="label-control">E-mail:</label>
                            </div>
                        </div>
                    </div>

                    <hr />

                    <div class="row">
                        <div class="col">
                            <!-- Telefone input -->
                            <div class="form-outline">
                                <input class="form-control" type="text" name="telefone" id="telefone" value="<?= $user['telefone'] ?>">
                                <label class="label-control">Telefone:</label>

                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col">
                            <!-- Horario de entrada input -->
                            <div class="form-outline">
                                <input class="form-control" type="time" name="horario-entrada" id="nome" value="<?= $user['horario_entrada'] ?>">
                                <label class="label-control">Horário de entrada:</label>
                            </div>
                        </div>
                        <div class="col">
                            <!-- Horario de saida input -->
                            <div class="form-outline">
                                <input class="form-control" type="time" name="horario-saida" id="email" value="<?= $user['horario_saida'] ?>">
                                <label class="label-control">Horário de saída:</label>
                            </div>
                        </div>
                    </div>

                    <div id="mensagem">

                        <?php if (isset($errors) && is_array($errors) && count($errors) > 0) :
                            foreach ($errors as $errors) :
                                if ($errors == 'Atualizado com sucesso') {
                                    echo  "<div class='bg-light text-success text-center'>
                                              $errors
                                            </div> ";
                                } else {
                                    echo $errors;
                                    echo '<br>';
                                }
                            endforeach;
                        endif;
                        ?>

                    </div>
                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-outline-dark" id="sing">Atualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="text-center m-4">
        <a href="employees" class="btn btn-warning">Voltar</a>
    </div>
</div>

<script type="text/javascript" src="../script/jquery.js"></script>
<script type="text/javascript" src="../script/acesso.js"></script>

<?php
include '../inc/footer.php';
?>