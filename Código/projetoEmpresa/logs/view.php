<?php
if ( !empty($_POST['entryDate'])  || !empty($_POST['finalDate'])) {
    include('../inc/header.php');



    if ($_POST['status'] == '1') {
        $dateEntry = $_POST['entryDate'];
        $dateFinal = $_POST['finalDate'];
        $query = $conexao->prepare("SELECT * FROM logs WHERE data BETWEEN '$dateEntry' AND '$dateFinal' AND tipo = '1'");
        $query->execute();

        $getDados = $query->fetchAll(PDO::FETCH_ASSOC);

?>
        <div class="home">
            <div class="container mt-5">
                <input type="text" class="form-control mb-4 w-25" placeholder="Filtrar pelo nome do funcionário" id="inpFiltrar" onkeyup="myFunction()">

                <div class="table-wrapper">
                    <table class="table table-striped" id="tab">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">Funcionário:</th>
                                <th scope="col">Evento:</th>
                                <th scope="col">Nome cliente:</th>
                                <th scope="col">Placa Cliente:</th>
                                <th scope="col">Id funcionário:</th>
                                <th scope="col">Id Cliente:</th>
                                <th scope="col">Funcionário cadastrado:</th>
                                <th scope="col">Id de funcionário cadastrado:</th>
                                <th scope="col">Data:</th>

                            </tr>
                        </thead>
                        <tbody class="table-secondary">
                            <?php
                            if (isset($getDados)) {
                                foreach ($getDados as $key => $value) :
                                    $dados = $getDados[$key];

                                    $nomeFunc = $dados['nome_func'];
                                    $evento = $dados['evento'];
                                    $nomeClie = $dados['nome_clie'];
                                    $placa = $dados['placa_veic'];
                                    $func_id = $dados['logs_func_id'];
                                    $clie_id = $dados['logs_clie_id'];
                                    $func_cad_nome = $dados['func_cad_nome'];
                                    $func_cad_id = $dados['func_cad_id'];
                                    $data = $dados['data'];


                            ?>
                                    <tr>
                                        <td><?= $nomeFunc ?></td>
                                        <td><?= $evento ?></td>
                                        <td><?= $nomeClie ?></td>
                                        <td><?= $placa ?></td>
                                        <td><?= $func_id ?></td>
                                        <td><?= $clie_id ?></td>
                                        <td><?= $func_cad_nome ?></td>
                                        <td><?= $func_cad_id ?></td>
                                        <td><?= $data ?></td>
                                    </tr>

                                <?php endforeach; ?>
                            <?php   }  ?>

                        </tbody>

                    </table>

                </div>



                <span class="mt-3">
                    <a href="../logs" class="btn btn-warning fs-5"><i class="bi bi-arrow-90deg-left"></i></a>
                </span>
                <span class="mt-3" id="print">
                    <a onclick="window.print()" class="btn btn-warning fs-5"><i class="bi bi-printer"></i></a>
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

                    td = tr[i].getElementsByTagName("td")[0];

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
    <?php } else if ($_POST['status'] == '2') {

        $dateEntry = $_POST['entryDate'];
        $dateFinal = $_POST['finalDate'];
        $query = $conexao->prepare("SELECT * FROM logs WHERE data BETWEEN '$dateEntry' AND '$dateFinal' AND tipo = '2'");
        $query->execute();

        $getDados = $query->fetchAll(PDO::FETCH_ASSOC);
    ?>
        <div class="home">
            <div class="container mt-5">
                <input type="text" class="form-control mb-4 w-25" placeholder="Filtrar pelo nome do funcionário" id="inpFiltrar" onkeyup="myFunction()">
                <div class="table-wrapper">
                    <table class="table table-striped" id="tab">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">Funcionário:</th>
                                <th scope="col">Evento:</th>
                                <th scope="col">Nome cliente:</th>
                                <th scope="col">Placa Cliente:</th>
                                <th scope="col">Id funcionário:</th>
                                <th scope="col">Id Cliente:</th>
                                <th scope="col">Funcionário atualizado:</th>

                                <th scope="col">Data:</th>

                            </tr>
                        </thead>
                        <tbody class="table-secondary">
                            <?php
                            if (isset($getDados)) {
                                foreach ($getDados as $key => $value) :
                                    $dados = $getDados[$key];

                                    $nomeFunc = $dados['nome_func'];
                                    $evento = $dados['evento'];
                                    $nomeClie = $dados['nome_clie'];
                                    $placa = $dados['placa_veic'];
                                    $func_id = $dados['logs_func_id'];
                                    $clie_id = $dados['logs_clie_id'];
                                    $func_cad_nome = $dados['func_cad_nome'];

                                    $data = $dados['data'];


                            ?>
                                    <tr>
                                        <td><?= $nomeFunc ?></td>
                                        <td><?= $evento ?></td>
                                        <td><?= $nomeClie ?></td>
                                        <td><?= $placa ?></td>
                                        <td><?= $func_id ?></td>
                                        <td><?= $clie_id ?></td>
                                        <td><?= $func_cad_nome ?></td>

                                        <td><?= $data ?></td>
                                    </tr>

                                <?php endforeach; ?>
                            <?php   }  ?>

                        </tbody>

                    </table>


                </div>



                <span class="mt-3">
                    <a href="../logs" class="btn btn-warning fs-5"><i class="bi bi-arrow-90deg-left"></i></a>
                </span>
                <span class="mt-3" id="print">
                    <a onclick="window.print()" class="btn btn-warning fs-5"><i class="bi bi-printer"></i></a>
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

                    td = tr[i].getElementsByTagName("td")[0];

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
    <?php } else if ($_POST['status'] == '3') {
        $dateEntry = $_POST['entryDate'];
        $dateFinal = $_POST['finalDate'];
        $query = $conexao->prepare("SELECT a.*, b.nome_usuario as check_in,c.nome_usuario as check_out FROM logs a 
	left join funcionarios c on a.mano_check_in = c.func_id  
	left join funcionarios  b on a.mano_check_out = b.func_id WHERE  data BETWEEN '$dateEntry' AND '$dateFinal' AND tipo = '3' ORDER BY logs_id");
        $query->execute();

        $getDados = $query->fetchAll(PDO::FETCH_ASSOC);
    ?>
        <div class="home">
            <div class="container mt-5">
                <input type="text" class="form-control mb-4 w-25" placeholder="Buscar movimento pela placa" id="inpFiltrar" onkeyup="myFunction()">
                <div class="table-wrapper">
                    <table class="table table-striped" id="tab">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">Funcionário:</th>
                                <th scope="col">Evento:</th>
                                <th scope="col">Nome cliente:</th>
                                <th scope="col">Placa Cliente:</th>
                                <th scope="col">Id funcionário:</th>
                                <th scope="col">Manobrista:</th>
                                <th scope="col">Data:</th>


                            </tr>
                        </thead>
                        <tbody class="table-secondary">
                            <?php
                            if (isset($getDados)) {
                                foreach ($getDados as $key => $value) :
                                    $dados = $getDados[$key];

                                    $nomeFunc = $dados['nome_func'];
                                    $evento = $dados['evento'];
                                    $nomeClie = $dados['nome_clie'];
                                    $placa = $dados['placa_veic'];
                                    $func_id = $dados['logs_func_id'];
                                    $manobrista = $dados['check_in'];
                                    $out = $dados['check_out'];
                                    $data = $dados['data'];
                            ?>
                                    <tr>
                                        <td><?= $nomeFunc ?></td>
                                        <td><?= $evento ?></td>
                                        <td><?= $nomeClie ?></td>
                                        <td><?= $placa ?></td>
                                        <td><?= $func_id ?></td>
                                        <td><?= $manobrista ?><?= $out ?></td>
                                        <td><?= $data ?></td>


                                    </tr>

                                <?php endforeach; ?>
                            <?php   }  ?>

                        </tbody>

                    </table>


                </div>



                <span class="mt-3">
                    <a href="../logs" class="btn btn-warning fs-5"><i class="bi bi-arrow-90deg-left"></i></a>
                </span>
                <span class="mt-3" id="print">
                    <a onclick="window.print()" class="btn btn-warning fs-5"><i class="bi bi-printer"></i></a>
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
    <?php } else if ($_POST['status'] == '4') {
        $dateEntry = $_POST['entryDate'];
        $dateFinal = $_POST['finalDate'];
        $query = $conexao->prepare("SELECT * FROM logs WHERE data BETWEEN '$dateEntry' AND '$dateFinal' AND tipo = '4'");
        $query->execute();

        $getDados = $query->fetchAll(PDO::FETCH_ASSOC);
    ?>
        <div class="home">
            <div class="container mt-5">
                <input type="text" class="form-control mb-4 w-25" placeholder="Filtrar pelo nome do funcionário" id="inpFiltrar" onkeyup="myFunction()">
                <div class="table-wrapper">
                    <table class="table table-striped" id="tab">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">Funcionário:</th>
                                <th scope="col">Evento:</th>
                                <th scope="col">Id Funcionário:</th>
                                <th scope="col">Data:</th>



                            </tr>
                        </thead>
                        <tbody class="table-secondary">
                            <?php
                            if (isset($getDados)) {
                                foreach ($getDados as $key => $value) :
                                    $dados = $getDados[$key];

                                    $nomeFunc = $dados['nome_func'];
                                    $evento = $dados['evento'];

                                    $func_id = $dados['logs_func_id'];
                                    $data = $dados['data'];




                            ?>
                                    <tr>
                                        <td><?= $nomeFunc ?></td>
                                        <td><?= $evento ?></td>

                                        <td><?= $func_id ?></td>
                                        <td><?= $data ?></td>

                                    </tr>

                                <?php endforeach; ?>
                            <?php   }  ?>

                        </tbody>

                    </table>


                </div>



                <span class="mt-3">
                    <a href="../logs" class="btn btn-warning fs-5"><i class="bi bi-arrow-90deg-left"></i></a>
                </span>
                <span class="mt-3" id="print">
                    <a onclick="window.print()" class="btn btn-warning fs-5"><i class="bi bi-printer"></i></a>
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

                    td = tr[i].getElementsByTagName("td")[0];

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
    <?php }
} else {
    ?>

    <script>
        window.location.href = '../reports?vazio'
    </script>
<?php
} ?>

<?php
include '../inc/footer.php';
?>