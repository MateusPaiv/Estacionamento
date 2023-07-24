<?php

if (count($_POST) > 0 && isset($_POST)) {

    include '../actions/autoload.php';

    $sing = new AtualizarCarro();


    $placa = addslashes($_POST['placa']);
    $modelo = addslashes($_POST['modelo']);
    $cor = addslashes($_POST['cor']);
    $ano = addslashes($_POST['ano']);
    $id = $_GET['veic_id'];



    $errors = $sing->update($placa, $modelo, $cor, $ano, $id);
}


include('../inc/header.php');

$up = new AtualizarCarro();

$id = $_GET['veic_id'];

$user = $up->fetch($id);

?>


<div class="form-sing d-flex flex-column justify-content-center align-items-center">

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

    <div class="text-dark">
        <div class="sing">
            <h4 class="text-center">Atualizar carro:</h4>
            <form method="POST">
                <div class="row">
                    <div class="col">
                        <!-- Name input -->
                        <div class="form-outline">
                            <input class="form-control" type="text" name="placa" id="placa" value="<?= $user['placa'] ?>">
                            <label class="form-label" for="form8Example1">Placa</label>
                        </div>
                    </div>
                    <div class="col">
                        <!-- Email input -->
                        <div class="form-outline">
                            <input class="form-control" type="text" name="modelo" id="modelo" value="<?= $user['modelo'] ?>">
                            <label class="form-label" for="form8Example2">Modelo</label>
                        </div>
                    </div>
                </div>

                <hr />

                <div class="row">
                    <div class="col">
                        <!-- Name input -->
                        <div class="form-outline">
                            <input class="form-control" type="text" name="cor" id="cor" value="<?= $user['cor'] ?>">
                            <label class="form-label" for="form8Example3">Cor</label>
                        </div>
                    </div>
                    <div class="col">
                        <!-- Name input -->
                        <div class="form-outline">
                            <input class="form-control" type="text" name="ano" id="ano" value="<?= $user['ano'] ?>">
                            <label class="form-label" for="form8Example4">Ano</label>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-outline-dark" id="sing">Atualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="text-center m-4">
    <a href="employees" class="btn btn-warning">Voltar</a>
</div>
<script type="text/javascript" src="../script/jquery.js"></script>
<script type="text/javascript" src="../script/acesso.js"></script>

<?php
include '../inc/footer.php';
?>