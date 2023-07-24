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
        <form method="POST" class="w-25 " action="../logs/view.php">
            <label class="form-label">Selecione a data de entrada:</label>
            <input class="form-control" type="date" name="entryDate">

            <label class="form-label">Selecione a data de saída:</label>
            <input class="form-control" type="date" name="finalDate">

            <label class="form-label">Tipo do log:</label>
            <select class="form-select" name="status">
                <option value="#">Selecione..</option>
                <option value="1">Cadastros</option>
                <option value="2">Atualizações</option>
                <option value="3">Checks</option>
                <option value="4">Relatório</option>
            </select>

            <input class="btn btn-warning mt-4" type="submit" value="Gerar relatório">
        </form>

    </div>
</div>

<?php
include '../inc/footer.php';
?>