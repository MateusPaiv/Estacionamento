<?php

include('../inc/header.php');

$up = new Logs();

$func_id = $_GET['func_id'];

$dadosMovimentos = $up->viewLogs($func_id);

?>
<div class="home">

    <div class="container mt-5">
        <label class="form-label">Buscar movimento pela data de entrada:</label>
        <input type="date" class="form-control mb-1 w-25" id="inpFiltrar">
        <button class="btn btn-warning mb-3" id="btnBusca">Filtrar</button>
        <div class="table-wrapper">
            <table class="table table-striped" id="tab">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Nome funcionário:</th>
                        <th scope="col">Evento:</th>
                        <th scope="col">Nome cliente:</th>
                        <th scope="col">Placa veículo:</th>
                        <th scope="col">Funcionário cadastrado:</th>
                        <th scope="col">Data do log:</th>
                    </tr>
                </thead>
                <tbody class="table-secondary">
                    <?php
                    if (isset($dadosMovimentos)) {
                        foreach ($dadosMovimentos as $key => $value) :
                            $getMov = $dadosMovimentos[$key];

                            $nome_funcionario = $getMov['nome_func'];
                            $evento = $getMov['evento'];
                            $nomeClie = $getMov['nome_clie'];
                            $placa = $getMov['placa_veic'];
                            $func_cad = $getMov['func_cad_nome'];
                            $data = $getMov['data'];
                    ?>
                            <tr>
                                <td><?= $nome_funcionario ?></td>
                                <td><?= $evento ?></td>
                                <td><?= $nomeClie ?></td>
                                <td><?= $placa ?></td>
                                <td><?= $func_cad ?></td>
                                <td><?= $data ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php   }  ?>


                </tbody>
            </table>
        </div>


        <span class="text-end">
            <a href="../employees" class="btn btn-warning fs-5"><i class="bi bi-arrow-90deg-left"></i></a>
        </span>
    </div>
</div>
<script>
    document.getElementById("btnBusca").addEventListener("click", Pesquisar);

    function Pesquisar() {

        var coluna = 5;

        var filtrar, tabela, tr, td, th, i;

        filtrar = document.getElementById("inpFiltrar");

        filtrar = filtrar.value.toUpperCase();

        tabela = document.getElementById("tab");

        tr = tabela.getElementsByTagName("tr");

        th = tabela.getElementsByTagName("th");

        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[coluna];
            if (td) {
                if (td.innerHTML.toUpperCase().indexOf(filtrar) > -1) {
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