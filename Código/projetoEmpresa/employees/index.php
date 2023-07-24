<?php
include('../inc/header.php');

if (count($_POST) > 0 && isset($_POST)) {



    $sing = new Cadastro();

    $conf_senha = $_POST['conf-senha'];
    $cpf = $_POST['cpf'];
    $errors = $sing->sing_up($_POST, $conf_senha, $cpf);
}
if (isset($_GET['up'])) { ?>
    <script>
        Swal.fire(
            'Funcionário',
            "Atualizado com sucesso",
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
    <div class="container mt-5">
        <div class="aviso d-flex align-items-center justify-content-center" role="alert">
            <div>
                <?php if (isset($errors) && is_array($errors) && count($errors) > 0) :
                    foreach ($errors as $errors) :

                        echo '<i class="bi bi-exclamation-octagon-fill me-2"></i>' . $errors;
                        echo '<br>';

                    endforeach;
                endif;
                ?>
            </div>
        </div>
        <input type="text" class="form-control mb-4 w-25" placeholder="Buscar cliente pelo e-mail" id="inpFiltrar" onkeyup="myFunction()">
        <h4 class="text-center text-warning bg-dark rounded">Tabela de funcionários</h4>
        <div class="table-wrapper">
            <table class="table table-striped" id="tab">
                <thead class="table-light">
                    <tr>
                        <th scope="col">CPF:</th>
                        <th scope="col">Nome Completo:</th>
                        <th scope="col">Nome de usuário:</th>
                        <th scope="col">E-mail:</th>
                        <th scope="col">Administrador:</th>

                        <?php if ($adm) { ?>
                            <th scope="col">Status:</th>
                        <?php } ?>
                        <th scope="col">Ações:</th>
                        <th scope="col"></th>

                    </tr>
                </thead>
                <tbody class="table-dark">
                    <?php

                    $query = $conexao->prepare("SELECT * FROM funcionarios order by adm desc");
                    $query->execute();

                    $user = $query->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($user as $key => $value) {
                        $usuario_atual = $user[$key];
                    ?>
                        <?php
                        if ($usuario_atual['adm'] == '1') {
                            $usuario_atual['adm'] = "Sim";
                        } else {
                            $usuario_atual['adm'] = "Não";
                        }

                        ?>
                        <?php if ($usuario_atual['status'] != '0') { ?>
                            <tr>

                                <td><?= $usuario_atual['cpf_funcionarios'] ?></td>
                                <td><?= $usuario_atual['nome'] ?></td>
                                <td><?= $usuario_atual['nome_usuario'] ?></td>
                                <td><?= $usuario_atual['email'] ?></td>
                                <td><?= $usuario_atual['adm'] ?></td>


                                <?php
                                if ($adm) {
                                    if ($usuario_atual['status'] == '1') { ?>
                                        <td><a href="../employees/desative.php?func_id=<?php echo $usuario_atual['func_id'] ?>" class="text-success fs-2" id="ativar"><i class="bi bi-toggle-on"></i></a></td>
                                    <?php } else { ?>
                                        <td><a href="../employees/active.php?func_id=<?php echo $usuario_atual['func_id'] ?>" class="text-danger fs-2"><i class="bi bi-toggle-off"></i></a></td>
                                <?php }
                                }
                                ?>



                                <td><a href="../employees/update.php?func_id=<?php echo $usuario_atual['func_id'] ?>" class="btn btn-outline-warning"><i class="bi bi-pencil fs-5"></i></a></td>
                                <td><a href="../employees/logs.php?func_id=<?= $usuario_atual['func_id'] ?>" class="btn btn-outline-warning fs-5"><i class="bi bi-file-earmark"></i></a></td>
                            </tr>
                        <?php } ?>
                    <?php  }  ?>


                </tbody>
            </table>
        </div>


        <span class="text-end">
            <a href="../dashboard" class="btn btn-warning fs-5"><i class="bi bi-arrow-90deg-left"></i></a>
        </span>
        <span>
            <span>
                <button type="button" class="btn btn-warning " data-bs-toggle="modal" data-bs-target="#cadUsuarioModal">
                    <i class="bi bi-person-plus fs-5 me-2"></i>Cadastrar novo funcionário
                </button>

                <div class="modal fade" id="cadUsuarioModal" tabindex="-1" aria-labelledby="cadUsuarioModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="cadUsuarioModalLabel">Cadastrar funcionário</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">


                                <h4 class="text-center">Cadastro de funcionários</h4>
                                <form method="POST">

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
                                                <input class="form-control" type="text" name="full_name" id="nome">
                                                <label class="form-label" for="form8Example2">Nome completo:</label>
                                            </div>
                                        </div>
                                    </div>

                                    <hr />

                                    <div class="row">
                                        <div class="col">
                                            <!-- Name input -->
                                            <div class="form-outline">
                                                <input class="form-control" type="text" name="username" id="nome_usuario">
                                                <label class="form-label" for="form8Example3">Nome de usuário:</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <!-- Name input -->
                                            <div class="form-outline">
                                                <input class="form-control" type="email" name="email" id="email">
                                                <label class="form-label" for="form8Example4">E-mail:</label>
                                            </div>
                                        </div>

                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col">
                                            <!-- Email input -->
                                            <div class="form-outline">
                                                <input class="form-control" type="password" name="senha" id="senha">
                                                <label class="form-label" for="form8Example5">Senha:</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <!-- Email input -->
                                            <div class="form-outline">
                                                <input class="form-control" type="password" name="conf-senha" id="senha">
                                                <label class="form-label" for="form8Example5">Confirmar senha:</label>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <select for="" class="form-select" name="fb">
                                                <option>Selecione...</option>
                                                <option value="1">Sim</option>
                                                <option value="0">Não</option>
                                            </select>
                                            <label class="form-label" for="form8Example5">Administrador:</label>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button class="btn btn-outline-dark">Cadastrar</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </span>
            <span>
                <a href="../employees/view-desativados.php" class="btn btn-warning"><i class="bi bi-person-dash fs-5 me-1"></i>Visualizar funcionários desativados</a>
            </span>


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
<?php
include '../inc/footer.php';
?>