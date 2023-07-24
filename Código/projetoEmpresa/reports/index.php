<?php
include('../inc/header.php');
if (isset($_GET['vazio'])) {
    echo "<script>
    Swal.fire(
        'Campos vazios',
        'Preencha todos os campos',
        'error'
    )
</script>";
}
?>

<div class="home">

    <div class="container text-center d-flex justify-content-center mt-5">
        <br>
        <form method="POST" class="w-25" action="../reports/view.php">
            <label class="form-label">Selecione o dia de entrada:</label>
            <input class="form-control" type="date" name="entryDate">

            <label class="form-label">Selecione o dia de saída:</label>
            <input class="form-control" type="date" name="finalDate">

            <label class="form-label">Status do movimento:</label>
            <select class="form-select" name="status">
                <option value="Selecione um campo">Selecione..</option>
                <option value="0">Pendentes</option>
                <option value="1">Concluídos</option>
                <option value="2">Todos</option>
            </select>

            <input class="btn btn-warning mt-4" type="submit" value="Gerar relatório">
        </form>

    </div>
</div>

<?php
include '../inc/footer.php';
?>