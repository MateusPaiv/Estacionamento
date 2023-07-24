<?php

include('../inc/header.php');

$up = new Movimentos();

$clie_id = $_GET['clie_id'];

$dadosMovimentos = $up->viewMovimentos($clie_id);

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
                        <th scope="col">Cliente:</th>
                        <th scope="col">Placa do veículo:</th>
                        <th scope="col">Vaga utilizada:</th>
                        <th scope="col">Dia de entrada:</th>
                        <th scope="col">Dia de saída:</th>
                        <th scope="col">Horário de entrada:</th>
                        <th scope="col">Horário de saída:</th>
                        <?php if ($adm) { ?>
                            <th scope="col">Valor pago:</th>
                        <?php } ?>
                        <th scope="col">Status:</th>

                    </tr>
                </thead>
                <tbody class="table-secondary">
                    <?php
                    if (isset($dadosMovimentos)) {
                        foreach ($dadosMovimentos as $key => $value) :
                            $getMov = $dadosMovimentos[$key];

                            $nomeClie = $getMov['nome_cliente'];
                            $placaClie = $getMov['placa'];
                            $entryDay = $getMov['data_entrada'];
                            $finalDay = $getMov['data_saida'];
                            $vagaClie = $getMov['movi_vaga_id'];
                            $EntryTime = $getMov['hora_entrada'];
                            $FinalTime = $getMov['hora_saida'];
                            $valor = $getMov['valor'];
                            $status = $getMov['status'];

                            if ($status == "1") {
                                $status = "Concluído";
                            } else {
                                $status = "Pendente";
                            }
                    ?>
                            <tr>
                                <td><?= $nomeClie ?></td>
                                <td><?= $placaClie ?></td>
                                <td><?= $vagaClie ?></td>
                                <td><?= $entryDay ?></td>
                                <td><?= $finalDay ?></td>
                                <td><?= $EntryTime ?></td>
                                <td><?= $FinalTime ?></td>
                                <?php if ($adm) { ?>
                                    <td><?= 'R$' . $valor . ',00' ?></td>
                                <?php } ?>
                                <td><?= $status ?></td>

                            </tr>
                        <?php endforeach; ?>
                    <?php   }  ?>


                </tbody>
            </table>
        </div>


        <span class="text-end">
            <a href="../clients" class="btn btn-warning fs-5"><i class="bi bi-arrow-90deg-left"></i></a>
        </span>
    </div>
</div>
<script>
    document.getElementById("btnBusca").addEventListener("click", Pesquisar);

    function Pesquisar() {

        var coluna = 3;

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