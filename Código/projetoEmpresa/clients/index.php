<?php
include('../inc/header.php');


if (count($_POST) > 0 && isset($_POST)) {
    $sing = new CadastroCliente();

    $cpf = $_POST['cpf'];
    $errors = $sing->sing_up($_POST, $cpf);
}

if (isset($_GET['erro'])) {
    $mensagem = 'Cliente está utilizando o estacionamento';
}
if (isset($_GET['up'])) { ?>
    <script>
        Swal.fire(
            'Cliente',
            'Atualizado com sucesso',
            'success'
        )
    </script>
<?php }
if (isset($_GET['cad'])) { ?>
    <script>
        Swal.fire(
            'Cliente',
            'Cadastrado com sucesso',
            'success'
        )
    </script>
<?php }
?>
<div class="home">
    <div class="container-fluid mt-5">
        <div class="container-sm">

            <div class="aviso d-flex align-items-center justify-content-center" role="alert">
                <div>

                    <?php
                    if (isset($mensagem)) {
                        echo $mensagem;
                    }
                    if (isset($errors) && is_array($errors) && count($errors) > 0) :
                        foreach ($errors as $errors) :
                            echo '<i class="bi bi-exclamation-octagon-fill me-2"></i>' . $errors;
                            echo '<br>';


                        endforeach;
                    endif;
                    ?>
                </div>
            </div>

            <input type="text" class="form-control mb-4 w-25" placeholder="Buscar cliente pelo e-mail" id="inpFiltrar" onkeyup="myFunction()">



            <h4 class="text-center text-warning bg-dark rounded">Tabela de clientes</h4>
            <div class="table-wrapper">
                <table class="table table-striped" id="tab">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">Usuário:</th>
                            <th scope="col">CPF:</th>
                            <th scope="col">Nome Completo:</th>
                            <th scope="col">E-mail:</th>
                            <th scope="col">Telefone:</th>
                            <th scope="col">Entrada:</th>
                            <th scope="col">Saída:</th>
                            <?php if ($adm) { ?>
                                <th scope="col">Status:</th>
                            <?php } ?>
                            <th scope="col">Ações:</th>
                            <th scope="col"></th>
                            <th scope="col"></th>


                        </tr>
                    </thead>
                    <tbody class="table-dark">
                        <?php

                        $query = $conexao->prepare("SELECT * FROM clientes order by horario_saida");
                        $query->execute();

                        $user = $query->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($user as $key => $value) :
                            $usuario_atual = $user[$key];
                        ?>
                            <tr>
                                <?php if ($usuario_atual['status'] != '0') { ?>

                                    <td><?= $usuario_atual['clie_id'] ?></td>
                                    <td><?= $usuario_atual['cpf_clientes'] ?></td>
                                    <td><?= $usuario_atual['nome_completo'] ?></td>
                                    <td><?= $usuario_atual['email'] ?></td>
                                    <td><?= $usuario_atual['telefone'] ?></td>
                                    <td><?= $usuario_atual['horario_entrada'] ?></td>
                                    <td><?= $usuario_atual['horario_saida'] ?></td>

                                    <?php
                                    if ($adm) {
                                        if ($usuario_atual['status'] == '1') { ?>
                                            <td><a href="../clients/desative.php?clie_id=<?= $usuario_atual['clie_id'] ?>" class="text-success fs-2" id="ativar"><i class="bi bi-toggle-on"></i></a></td>
                                    <?php }
                                    } ?>
                                    <td><a href="../clients/visualizar.php?clie_id=<?= $usuario_atual['clie_id'] ?>" class="btn btn-warning">Veículo(s)</a></td>

                                    <td><a href="../clients/update.php?clie_id=<?= $usuario_atual['clie_id'] ?>" class="btn btn-outline-warning fs-5"><i class="bi bi-pencil"></i></a></td>
                                    <td><a href="../clients/movimentos.php?clie_id=<?= $usuario_atual['clie_id'] ?>" class="btn btn-outline-warning fs-5"><i class="bi bi-file-earmark"></i></a></td>

                                <?php } ?>

                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>


            </div>
            <span>
                <a href="../dashboard" class="btn btn-warning mt-2"><i class="bi bi-arrow-90deg-left fs-5"></i></a>
            </span>
            <span>
                <button type="button" class="btn btn-warning mt-2" data-bs-toggle="modal" data-bs-target="#cadUsuarioModal">
                    <i class="bi bi-person-plus fs-5 me-2"></i>Cadastrar novo cliente
                </button>

                <div class="modal fade" id="cadUsuarioModal" tabindex="-1" aria-labelledby="cadUsuarioModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="cadUsuarioModalLabel">Cadastrar usuário</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">

                                <form method="POST" id="cadForm">
                                    <div class="row">
                                        <div class="col">
                                            <!-- Name input -->
                                            <div class="form-outline">
                                                <input class="form-control cpf" type="text" name="cpf" id="cpf" placeholder="000.000.000-00" maxlength="14">
                                                <label class="form-label" for="form8Example1">CPF:</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <!-- Email input -->
                                            <div class="form-outline">
                                                <input class="form-control" type="text" name="full_name" id="nome" placeholder="Mauro Antunes Santiago">
                                                <label class="form-label" for="form8Example2">Nome completo:</label>
                                            </div>
                                        </div>
                                    </div>

                                    <hr />

                                    <div class="row">
                                        <div class="col">
                                            <!-- Name input -->
                                            <div class="form-outline">
                                                <input class="form-control" type="email" name="email" id="email" placeholder="exemplo@teste.com">
                                                <label class="form-label" for="form8Example3">E-mail:</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <!-- Name input -->
                                            <div class="form-outline">
                                                <input class="form-control" type="text" name="telefone" placeholder="(99)99999-9999" id="telefone" maxlength="14">
                                                <label class="form-label" for="form8Example4">Telefone</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <!-- Name input -->
                                            <div class="form-outline">
                                                <input class="form-control" type="time" name="horario-entrada" id="email" value="">
                                                <label class="form-label" for="form8Example3">Entrada prevista:</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <!-- Name input -->
                                            <div class="form-outline">
                                                <input class="form-control" type="time" name="horario-saida" id="telefone" maxlength="14">
                                                <label class="form-label" for="form8Example4">Saída prevista:</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-center mb-3">
                                        <button type="submit" class="btn btn-outline-dark" id="sing">Cadastrar</button>
                                    </div>
                                    <div class="modal-footer mt-2 text-center">
                                        <p class="text-muted">Cadastre os horários com <b>15 minutos</b> de antecedência</p>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </span>
            <span>
                <a href="../clients/view-desativados.php" class="link link-dark btn btn-warning mt-2 " style="text-decoration: none;">
                    <i class="bi bi-person-x fs-5 me-2"></i>Clientes desativados</a>
            </span>

        </div>

    </div>
</div>

<script>
    function myFunction() {

        // Declare variables

        var input, filter, table, tr, td, i, txtValue;

        input = document.getElementById("inpFiltrar");

        filter = input.value.toLowerCase();

        table = document.getElementById("tab");

        tr = table.getElementsByTagName("tr");



        // Loop through all table rows, and hide those who don't match the search query

        for (i = 0; i < tr.length; i++) {

            td = tr[i].getElementsByTagName("td")[3];

            if (td) {

                txtValue = td.textContent || td.innerText;

                if (txtValue.toLowerCase().indexOf(filter) > -1) {

                    tr[i].style.display = "";

                } else {

                    tr[i].style.display = "none";

                }

            }

        }

    }
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $("#cpf").mask("999.999.999-99");
    });
</script>
<?php
include '../inc/footer.php';
?>