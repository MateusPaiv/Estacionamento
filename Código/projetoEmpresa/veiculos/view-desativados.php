<?php
include('../inc/header.php');
?>
<div class="home">
    <div class="container-fluid mt-5">
        <div class="container-sm">

            <input type="text" class="form-control mb-4 w-25" placeholder="Buscar cliente pela placa" id="inpFiltrar" onkeyup="myFunction()">
            <h4 class="text-center text-warning bg-dark rounded">Veículos de clientes desativados</h4>
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

                        $query = $conexao->prepare("SELECT veiculos.* , clientes.* from veiculos inner join clientes on veiculos.veic_clie_id = clientes.clie_id ORDER BY nome_completo");
                        $query->execute();

                        $user = $query->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($user as $key => $value) :
                            $usuario_atual = $user[$key];
                        ?>
                            <tr>
                                <?php if ($usuario_atual['status'] != '1') { ?>
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
                <a href="../veiculos/index.php" class="btn btn-warning fs-5 mt-2"><i class="bi bi-arrow-90deg-left"></i></a>
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