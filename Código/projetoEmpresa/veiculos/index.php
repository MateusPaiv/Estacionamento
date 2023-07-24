<?php
include('../inc/header.php');

if (count($_POST) > 0 && isset($_POST)) {

    $sing = new CadastroCarro();
    $errors = $sing->cadastroCarro($_POST);
}
@$cpf_cliente = $_GET['cpf_cliente'];
$placa = '';
$modelo = '';
$cor = '';
$ano = '';
if (isset($_GET['up'])) { ?>
    <script>
        Swal.fire(
            'Veículo',
            'Atualizado com sucesso',
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
                    <?php if (isset($errors) && is_array($errors) && count($errors) > 0) :
                        foreach ($errors as $errors) :
                            echo '<i class="bi bi-exclamation-octagon-fill me-2"></i>' . $errors;
                            echo '<br>';

                        endforeach;
                    endif;
                    ?>
                </div>
            </div>
            <input type="text" class="form-control mb-4 w-25" placeholder="Buscar cliente pela placa" id="inpFiltrar" onkeyup="myFunction()">
            <h4 class="text-center text-warning bg-dark rounded">Tabela de veículos</h4>
            <div class="table-wrapper">
                <table class="table table-striped" id="tab">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">Veículo:</th>
                            <th scope="col">Dono do veículo:</th>
                            <th scope="col">Placa:</th>
                            <th scope="col">Modelo:</th>
                            <th scope="col">Cor:</th>
                            <th scope="col">Ano:</th>
                            <th scope="col">Ações:</th>


                        </tr>
                    </thead>
                    <tbody class="table-dark">
                        <?php

                        $query = $conexao->prepare("SELECT veiculos.* , clientes.* from veiculos inner join clientes on veiculos.veic_clie_id = clientes.clie_id ORDER BY veic_id");
                        $query->execute();

                        $user = $query->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($user as $key => $value) :
                            $usuario_atual = $user[$key];
                        ?>
                            <tr>
                                <?php if ($usuario_atual['status'] != '0') { ?>
                                    <td><?= $usuario_atual['veic_id'] ?></td>
                                    <td><?= $usuario_atual['nome_completo'] ?></td>
                                    <td><?= $usuario_atual['placa'] ?></td>
                                    <td><?= $usuario_atual['modelo'] ?></td>
                                    <td><?= $usuario_atual['cor'] ?></td>
                                    <td><?= $usuario_atual['ano'] ?></td>

                                    <td><a href="../veiculos/update.php?veic_id=<?php echo $usuario_atual['veic_id'] ?>" class="btn btn-outline-warning"><i class="bi bi-pencil fs-5"></i></a></td>
                                <?php } ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            </div>

            <span class="text-start">
                <a href="../dashboard" class="btn btn-warning fs-5 mt-2"><i class="bi bi-arrow-90deg-left"></i></a>
            </span>
            <span class="text-end">
                <button type="button" class="btn btn-warning mt-2" data-bs-toggle="modal" data-bs-target="#cadUsuarioModal">
                    <i class="bi bi-car-front fs-5 me-2"></i>Cadastrar novo veículo
                </button>

                <div class="modal fade" id="cadUsuarioModal" tabindex="-1" aria-labelledby="cadUsuarioModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="cadUsuarioModalLabel">Cadasatrar veículo</h1>

                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">

                                <form method="POST">
                                    <div class="row">
                                        <div class="col">
                                            <!-- Name input -->
                                            <div class="form-outline">
                                                <input class="form-control" type="text" name="cpf" id="cpf" placeholder="CPF do cliente" maxlength="14" value="<?= $cpf_cliente ?>">

                                            </div>
                                        </div>
                                        <div class="col">
                                            <!-- Email input -->
                                            <div class="form-outline">
                                                <input class="form-control" type="text" name="placa" placeholder="Placa do veículo" id="placa" maxlength="8" value="<?= $placa ?>">

                                            </div>
                                        </div>
                                    </div>

                                    <hr />

                                    <div class="row">
                                        <div class="col">
                                            <!-- Name input -->
                                            <div class="form-outline">
                                                <input class="form-control" type="text" name="modelo" id="modelo" placeholder="Modelo do veículo" value="<?= $modelo ?>">

                                            </div>
                                        </div>
                                        <div class="col">
                                            <!-- Name input -->
                                            <div class="form-outline">
                                                <input class="form-control" type="text" name="cor" placeholder="Cor do veículo" value="<?= $cor ?>">

                                            </div>
                                        </div>
                                        <div class="col">
                                            <!-- Email input -->
                                            <div class="form-outline">
                                                <input class="form-control" type="text" name="ano" placeholder="Ano do veículo" value="<?= $ano ?>">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center mt-3">
                                        <button class="btn btn-outline-dark" type="submit">Cadastrar</button>
                                    </div>

                                </form>


                            </div>
                            <div class="modal-footer">
                                <p class="text-muted">Veículo só vai estar cadastrado se cliente já estiver cadastrado</p>
                            </div>
                        </div>
                    </div>
                </div>
            </span>
            <span class="text-end ">
                <a href="../veiculos/view-desativados.php" class="btn btn-warning mt-2"><i class="bi bi-dash fs-5"></i> Veículos desativados</a>
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

            td = tr[i].getElementsByTagName("td")[2];

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