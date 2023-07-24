<?php
include('../inc/header.php');


$now = new DateTime("now", new DateTimeZone("America/Sao_Paulo"));

if (!empty($_POST['entryDate']) || !empty($_POST['finalDate'])) {
    if (!empty($_POST['entryDate'])) {

        if ($_POST['status'] == '2') {
            $dateEntry = $_POST['entryDate'];
            $dateFinal = $_POST['finalDate'];
            $query = $conexao->prepare("SELECT * FROM movimentos WHERE data_entrada BETWEEN '$dateEntry' AND '$dateFinal' order by hora_entrada");
            $query->execute();

            $getDados = $query->fetchAll(PDO::FETCH_ASSOC);

            $query = "INSERT INTO logs(nome_func,evento,logs_func_id,tipo,data) VALUES(:nome_func,:evento,:func_id,:tipo,:data)";

            $data = array();
            $data['nome_func'] = $_SESSION['usuario'][1];
            $data['func_id'] = $_SESSION['usuario'][0];
            $data['evento'] = "Gerou relatório do dia {$dateEntry}";
            $data['tipo'] = "4";
            $data['data'] = $dataBr = $now->format("d/m/Y");

            $result = $conexaoClass->write($query, $data);

            if ($query) {
                $query = $conexao->prepare("SELECT sum(valor) as valor_total FROM movimentos where data_entrada BETWEEN '$dateEntry' AND '$dateFinal' ");
                $query->execute();

                $valueToday = $query->fetch(PDO::FETCH_ASSOC);

                $query = $conexao->prepare("SELECT count(movi_id) as count_clie FROM movimentos where data_entrada BETWEEN '$dateEntry' AND '$dateFinal'");
                $query->execute();

                $countClie = $query->fetch(PDO::FETCH_ASSOC);
            }
        } else if (!empty($_POST['entryDate']) || !empty($_POST['status'])) {

            $dateEntry = $_POST['entryDate'];
            $dateFinal = $_POST['finalDate'];
            if (!empty($_POST['status'])) {
                $status = $_POST['status'];
            } else {
                $status = '0';
            }
            $query = $conexao->prepare("SELECT * FROM movimentos WHERE data_entrada BETWEEN '$dateEntry' AND '$dateFinal' AND status = '$status'order by hora_entrada");
            $query->execute();

            $getDados = $query->fetchAll(PDO::FETCH_ASSOC);

            $query = "INSERT INTO logs(nome_func,evento,logs_func_id,tipo,data) VALUES(:nome_func,:evento,:func_id,:tipo,:data)";

            $data = array();
            $data['nome_func'] = $_SESSION['usuario'][1];
            $data['func_id'] = $_SESSION['usuario'][0];
            $data['evento'] = "Gerou relatório do dia {$dateEntry}";
            $data['tipo'] = "4";
            $data['data'] = $dataBr = $now->format("d/m/Y");

            $result = $conexaoClass->write($query, $data);

            if ($query) {
                $query = $conexao->prepare("SELECT sum(valor) as valor_total FROM movimentos where data_entrada BETWEEN '$dateEntry' AND '$dateFinal' ");
                $query->execute();

                $valueToday = $query->fetch(PDO::FETCH_ASSOC);

                $query = $conexao->prepare("SELECT count(movi_id) as count_clie FROM movimentos where data_entrada BETWEEN '$dateEntry' AND '$dateFinal' ");
                $query->execute();

                $countClie = $query->fetch(PDO::FETCH_ASSOC);
            }
        }
    } else {
        $query = $conexao->prepare("SELECT * FROM movimentos WHERE data_entrada BETWEEN '$dateEntry' AND '$dateFinal' order by hora_entrada");
        $query->execute();

        $getDados = $query->fetchAll(PDO::FETCH_ASSOC);

        $query = "INSERT INTO logs(nome_func,evento,logs_func_id,tipo,data) VALUES(:nome_func,:evento,:func_id,:tipo,:data)";

        $data = array();
        $data['nome_func'] = $_SESSION['usuario'][1];
        $data['func_id'] = $_SESSION['usuario'][0];
        $data['evento'] = "Gerou relatório";
        $data['tipo'] = "4";
        $data['data'] = $dataBr = $now->format("d/m/Y");

        $result = $conexaoClass->write($query, $data);
        if ($query) {
            $query = $conexao->prepare("SELECT sum(valor) as valor_total FROM movimentos where data_entrada BETWEEN '$dateEntry' AND '$dateFinal' ");
            $query->execute();

            $valueToday = $query->fetch(PDO::FETCH_ASSOC);

            $query = $conexao->prepare("SELECT count(movi_id) as count_clie FROM movimentos where data_entrada BETWEEN '$dateEntry' AND '$dateFinal'");
            $query->execute();

            $countClie = $query->fetch(PDO::FETCH_ASSOC);
        }
    }

?>
    <div class="home">
        <div class="container mt-5">
            <input type="text" class="form-control mb-4 w-25" placeholder="Buscar movimento placa" id="inpFiltrar" onkeyup="myFunction()">
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
                            <?php
                            }
                            ?>
                            <th scope="col">Status:</th>

                        </tr>
                    </thead>
                    <tbody class="table-secondary">
                        <?php
                        if (isset($getDados)) {
                            foreach ($getDados as $key => $value) :
                                $usuario_atual = $getDados[$key];

                                $nomeClie = $usuario_atual['nome_cliente'];
                                $placaClie = $usuario_atual['placa'];
                                $entryDay = $usuario_atual['data_entrada'];
                                $finalDay = $usuario_atual['data_saida'];
                                $vagaClie = $usuario_atual['movi_vaga_id'];
                                $EntryTime = $usuario_atual['hora_entrada'];
                                $FinalTime = $usuario_atual['hora_saida'];
                                $valor = $usuario_atual['valor'];
                                $status = $usuario_atual['status'];

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

                                    <?php if ($adm) {
                                    ?>
                                        <td><?= 'R$' . $valor . ',00' ?></td>

                                    <?php
                                    } ?>
                                    <td><?= $status ?></td>



                                </tr>

                            <?php endforeach; ?>
                        <?php   }  ?>

                    </tbody>

                </table>

            </div>

            <?php if ($adm) {
            ?>
                <div class="d-flex justify-content-center">
                    <div class="text-center alert alert-info mt-3 ">Valor total adquirido no dia: <b><?= 'R$' . $valueToday['valor_total'] . ',00' ?></b>
                        <br>Total de movimentos do dia: <b><?= $countClie['count_clie']  ?></b>
                    </div>
                </div>

            <?php
            } ?>

            <span class="mt-3">
                <a href="../reports" class="btn btn-warning fs-5"><i class="bi bi-arrow-90deg-left"></i></a>
            </span>
            <span class="mt-3" id="print">
                <a onclick="window.print()" class="btn btn-warning fs-5"><i class="bi bi-printer"></i></a>
            </span>
        </div>
    </div>
<?php } else { ?>
    <script>
        window.location.href = '../reports?vazio'
    </script>
<?php
} ?>
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

            td = tr[i].getElementsByTagName("td")[1];

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