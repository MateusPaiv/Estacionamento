<?php
include('../inc/header.php');
?>
<div class="home">
    <div class="container-fluid mt-5">
        <div class="container-sm">

            <input type="text" class="form-control mb-4 w-25" placeholder="Buscar cliente pelo e-mail" id="inpFiltrar" onkeyup="myFunction()">
            
            <h4 class="text-center text-warning bg-dark rounded">Tabela de clientes desativados</h4>
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
                            <th scope="col">Status:</th>
                            <th scope="col">Ações:</th>
                            <th scope="col"></th>



                        </tr>
                    </thead>
                    <tbody class="table-dark">
                        <?php

                        $query = $conexao->prepare("SELECT * FROM clientes where status = '0'");
                        $query->execute();

                        $user = $query->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($user as $key => $value) :
                            $usuario_atual = $user[$key];
                        ?>
                            <tr>
                                <?php if ($usuario_atual['status'] != '1') { ?>

                                    <td><?= $usuario_atual['clie_id'] ?></td>
                                    <td><?= $usuario_atual['cpf_clientes'] ?></td>
                                    <td><?= $usuario_atual['nome_completo'] ?></td>
                                    <td><?= $usuario_atual['email'] ?></td>
                                    <td><?= $usuario_atual['telefone'] ?></td>
                                    <td><?= $usuario_atual['horario_entrada'] ?></td>
                                    <td><?= $usuario_atual['horario_saida'] ?></td>

                                    <?php if ($usuario_atual['status'] == '0') { ?>
                                        <td><a href="../clients/active.php?clie_id=<?= $usuario_atual['clie_id'] ?>" class="text-danger fs-2"><i class="bi bi-toggle-off"></i></a></td>
                                    <?php } ?>

                                    <td><a href="../clients/visualizar.php?clie_id=<?= $usuario_atual['clie_id'] ?>" class="btn btn-warning">Veículo(s)</a></td>

                                    <td><a href="../clients/update.php?clie_id=<?= $usuario_atual['clie_id'] ?>" class="btn btn-outline-warning fs-5"><i class="bi bi-pencil"></i></a></td>

                                <?php } else { ?>
                                    <td>Nenhum cliente desativado do sistema</td>
                                <?php } ?>

                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>


            </div>
            <span class="text-start ">
                <a href="../clients/index.php" class="btn btn-warning mt-2"><i class="bi bi-arrow-90deg-left fs-5"></i></a>
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
<?php
include '../inc/footer.php';
?>