<?php
include('../inc/header.php');

if (isset($_POST['check-in-placa'])) {

    $placa_check  = $_POST['placa'];
    $park = new Park();

    $errors = $park->verificacao($placa_check);
}

if (isset($_POST['check-out-placa'])) {

    $placa_check_out  = $_POST['placa-check-out'];
    $park = new Park();

    $dados_check_out = $park->verificacao_check_out($placa_check_out);
}

$query = $conexao->prepare("SELECT nome_usuario, func_id from funcionarios where status = '1' order by nome_usuario");
$query->execute();

$dadosFunc = $query->fetchAll(PDO::FETCH_ASSOC);
?>


<div class="home bg-control">
    <div class="d-flex container me-2">
        <div class="row justify-content-around">
            <div class="col-sm-5">
                <form method="POST" class="check-in">
                    <h4 class="text-center fs-2">Checar placa para <br> Check-in</h4>
                    <div class="row ">
                        <div class="col">
                            <div class="form-outline">
                                <input class="form-control text-center uppercase" type="text" name="placa" id="placa" maxlength="8">
                                <label class="form-label " for="form8Example3">Placa:</label>
                            </div>

                            <div class="text-center mb-3">
                                <button type="submit" class="btn btn-dark" id="check-in" name="check-in-placa"><i class="bi bi-search"></i></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-sm-5 ms-5">
                <form method="POST" class="check-out">
                    <h4 class="text-center fs-2">Checar placa para Check-out</h4>
                    <div class="row">
                        <div class="col">
                            <div class="form-outline">
                                <input class="form-control text-center" type="text" name="placa-check-out" id="placa" maxlength="8">
                                <label class="form-label " for="form8Example3">Placa:</label>
                            </div>

                            <div class="text-center mb-3">
                                <button type="submit" class="btn btn-dark" id="check-in" name="check-out-placa"><i class="bi bi-search"></i></button>
                            </div>

                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>


    <div class="d-flex container me-5">
        <div class="row justify-content-around">
            <div class="col-sm-5">
                <?php
                if (!empty($_POST['name-check-in']) && !empty($_POST['modelo-check-in']) && !empty($_POST['placa-check-in'])) {
                    $park = new Park();
                    $nome = $_POST['name-check-in'];
                    $placa = $_POST['placa-check-in'];
                    $modelo = $_POST['modelo-check-in'];
                    $manobrista = $_POST['manobrista_check_in'];



                    $movimento = $park->check_in($nome, $placa, $modelo, $manobrista);
                }
                ?>
                <h4 class="text-center fs-2">Check-in</h4>
                <form method="POST">
                    <div class="row">
                        <div class="col">
                            <div class="form-outline">
                                <input class="form-control" type="text" name="name-check-in" id="nome" value="<?php if (isset($errors)) {
                                                                                                                    echo $errors['nome_completo'];
                                                                                                                } else {
                                                                                                                    echo '';
                                                                                                                }  ?>">
                                <label class="form-label" for="form8Example2">Nome:</label>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <div class="row">

                        <div class="col">

                            <div class="form-outline">
                                <input class="form-control" type="text" name="modelo-check-in" id="modelo" value="<?php if (isset($errors)) {
                                                                                                                        echo $errors['modelo'];
                                                                                                                    } else {
                                                                                                                        echo '';
                                                                                                                    }  ?>">
                                <label class="form-label" for="form8Example5">Modelo:</label>
                            </div>
                        </div>
                        <div class="col">

                            <div class="form-outline">
                                <input class="form-control uppercase" type="text" name="placa-check-in" id="placa" maxlength="7" value="<?php if (isset($errors)) {
                                                                                                                                            echo $errors['placa'];
                                                                                                                                        } else {
                                                                                                                                            echo @$_POST['placa'];
                                                                                                                                        } ?>">
                                <label class="form-label" for="form8Example5">Placa:</label>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-outline">
                                <select class="form-select uppercase mb-3" name="manobrista_check_in" id="">
                                    <option value="#">Manobrista...</option>
                                    <?php foreach ($dadosFunc as $row) : ?>
                                        <option value="<?= $row['func_id'] ?>"><?= $row['nome_usuario'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <?php $now = new DateTime("now", new DateTimeZone("America/Sao_Paulo"));
                            $horaBr = $now->format("H:i"); ?>
                            <div class="form-outline">
                                <input class="form-control uppercase" type="time" disabled value="<?= $horaBr ?>">
                                <label class="form-label" for="form8Example5">Hora:</label>
                            </div>
                        </div>

                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-dark" id="check-in">Chek-in</button>
                    </div>

                </form>

                <div id="mensagem-park" class="rounded text-success bg-success bg-opacity-25 text-center">
                    <?php if (isset($movimento) && is_array($movimento)) :
                        foreach ($movimento as $movimento) :

                            echo $movimento;

                        endforeach;
                    endif; ?>
                </div>

            </div>


            <div class="col-sm-5">
                <?php
                if (!empty($_POST['name-check-out']) && !empty($_POST['modelo-check-out']) && !empty($_POST['placa-check-out'])) {

                    $park = new Park();
                    $nome = $_POST['name-check-out'];
                    $placa = $_POST['placa-check-out'];
                    $modelo = $_POST['modelo-check-out'];
                    $manobrista = $_POST['manobrista_check_out'];
                    $hora = $_POST['horabr'];

                    $check_out = $park->check_out($placa, $manobrista, $hora);
                }
                ?>
                <h4 class="text-center fs-2">Check-out</h4>
                <form method="POST">

                    <div class="row">

                        <!-- VERIFICAR SE TEM CADASTRO NO ESTACIONAMENTO E PREENCHER OS CAMPOS SE NÃO PREENCHER APENAS PLACA E INICIAR E MODELO DO VEÍCULO PARA ACHAR UMA VAGA -->
                        <div class="col">

                            <div class="form-outline">
                                <input class="form-control" type="text" name="name-check-out" id="nome" value="<?= @$dados_check_out['nome_cliente'] ?>">
                                <label class="form-label" for="form8Example2">Nome completo:</label>
                            </div>
                        </div>
                    </div>


                    <hr>
                    <div class="row">
                        <div class="col">

                            <div class="form-outline">
                                <input class="form-control" type="text" name="modelo-check-out" id="modelo" value="<?= @$dados_check_out['modelo'] ?>">
                                <label class="form-label" for="form8Example5">Modelo:</label>
                            </div>
                        </div>
                        <div class="col">

                            <div class="form-outline">
                                <input class="form-control uppercase" type="text" name="placa-check-out" id="placa" maxlength="7" value="<?= @$dados_check_out['placa'] ?>">
                                <label class="form-label" for="form8Example5">Placa:</label>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-outline">
                                <select class="form-select uppercase mb-3" name="manobrista_check_out" id="">
                                    <option value="#">Manobrista...</option>
                                    <?php foreach ($dadosFunc as $row) : ?>
                                        <option value="<?= $row['func_id'] ?>"><?= $row['nome_usuario'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                        </div>
                        <div class="col">
                            <?php $now = new DateTime("now", new DateTimeZone("America/Sao_Paulo"));
                            $horaBr = $now->format("H:i"); ?>
                            <div class="form-outline">
                                <input class="form-control uppercase" type="time" name="horabr" value="<?= $horaBr ?>">
                                <label class="form-label" for="form8Example5">Hora:</label>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-dark" id="check-out" name="check_out">Check-out</button>
                    </div>
                </form>
                <div id="mensagem-park" class="rounded text-success bg-success bg-opacity-25 text-center">
                    <?php if (isset($check_out) && is_array($check_out)) :
                        foreach ($check_out as $check_out) :

                            echo $check_out;

                        endforeach;
                    endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<a href="../dashboard" class="button-fixed text-center mt-4"><button class="text-white"> <i class="bi bi-bar-chart-line icon"></i></button></a>

<?php
include '../inc/footer.php';
?>