<?php
include('../inc/header.php');
?>
<div class="home">
    <div class="container mt-5">
        <input type="text" class="form-control mb-4 w-25" placeholder="Buscar cliente pelo e-mail" id="inpFiltrar" onkeyup="myFunction()">
        <h4 class="text-center text-warning bg-dark rounded">Funcionários desativados</h4>

        <div class="table-wrapper">
            <table class="table table-striped" id="tab">
                <thead class="table-light">
                    <tr>
                        <th scope="col">CPF:</th>
                        <th scope="col">Nome Completo:</th>
                        <th scope="col">Nome de usuário:</th>
                        <th scope="col">E-mail:</th>
                        <th scope="col">Administrador:</th>
                        <th scope="col">Status:</th>
                        <th scope="col">Ações:</th>

                    </tr>
                </thead>
                <tbody class="table-dark">
                    <?php

                    $query = $conexao->prepare("SELECT * FROM funcionarios order by adm desc");
                    $query->execute();

                    $user = $query->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($user as $key => $value) :
                        $usuario_atual = $user[$key];

                        if ($usuario_atual['adm'] == '1') {
                            $usuario_atual['adm'] = "Sim";
                        } else {
                            $usuario_atual['adm'] = "Não";
                        }


                    ?>
                        <?php if ($usuario_atual['status'] != '1') { ?>
                            <tr>
                                <td><?= $usuario_atual['cpf_funcionarios'] ?></td>
                                <td><?= $usuario_atual['nome'] ?></td>
                                <td><?= $usuario_atual['nome_usuario'] ?></td>
                                <td><?= $usuario_atual['email'] ?></td>
                                <td><?= $usuario_atual['adm'] ?></td>

                                <?php
                                if ($usuario_atual['status'] == '0') { ?>
                                    <td><a href="../employees/active.php?func_id=<?php echo $usuario_atual['func_id'] ?>" class="text-danger fs-2" id="ativar"><i class="bi bi-toggle-off"></i></a></td>
                                <?php
                                }
                                ?>

                                <td><a href="../employees/update.php?func_id=<?php echo $usuario_atual['func_id'] ?>" class="btn btn-outline-warning"><i class="bi bi-pencil fs-5"></i></a></td>

                            </tr>
                    <?php }
                    endforeach; ?>
                </tbody>
            </table>
        </div>


        <span class="text-end">
            <a href="../employees" class="btn btn-warning fs-5"><i class="bi bi-arrow-90deg-left"></i></a>
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